<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use App\Exports\TableExport;
use App\Notifications\ShareTableNotification;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NotifiableUser;
use App\Http\Controllers\Controller as BaseController;

class TableController extends BaseController
{
    public function gestionar()
    {
        $user = Auth::user();
        $userId = $user->id;

        $userTables = DB::table('users')->where('id', $userId)->first([
            'discos', 'viajes', 'contactos', 'compra', 'programas', 'cuentas'
        ]);

        $tables = [
            'disc_collection' => 'discos',
            'travel_collection' => 'viajes',
            'contacts' => 'contactos',
            'shopping_list' => 'compra',
            'program_list' => 'programas',
            'accounts_list' => 'cuentas'
        ];

        $availableTables = [];
        foreach ($tables as $table => $booleanField) {
            if ($userTables->$booleanField) {
                $availableTables[] = $table;
            }
        }

        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentPageItems = array_slice($availableTables, ($currentPage - 1) * $perPage, $perPage);
        $paginatedTables = new LengthAwarePaginator($currentPageItems, count($availableTables), $perPage, $currentPage, [
            'path' => Paginator::resolveCurrentPath()
        ]);

        return view('menu.gestionar', ['tables' => $paginatedTables]);
    }

    public function view(Request $request, $table)
    {
        $userId = Auth::id();
        $sortField = $request->input('sort_field', 'id');
        $sortOrder = $request->input('sort_order', 'asc');
    
        if (!Schema::hasTable($table)) {
            return redirect()->route('table.gestionar')->with('error', 'The table does not exist');
        }
    
        $sharedOwners = DB::table('share')
            ->where('shared_user', $userId)
            ->where('table_type', $table)
            ->pluck('owner')
            ->toArray();
    
        $allowedOwners = array_merge([$userId], $sharedOwners);
    
        $filters = $request->except(['sort_field', 'sort_order', 'page']);
    
        $query = DB::table($table)->whereIn('owner_id', $allowedOwners);
    
        foreach ($filters as $field => $value) {
            if ($value) {
                $query->where($field, 'like', "%{$value}%");
            }
        }
    
        $perPage = 10;
        $data = $query->orderBy($sortField, $sortOrder)->paginate($perPage);
    
        $ownerIds = collect($data->items())->pluck('owner_id')->unique()->toArray();
        $owners = DB::table('users')
            ->whereIn('id', $ownerIds)
            ->get(['id', 'name', 'profile_photo_path'])
            ->keyBy('id');
    
        // Procesar el nombre de la tabla
        $processedTableName = $this->processTableName($table);
    
        return view('table.view', [
            'table' => $table,
            'processedTableName' => $processedTableName,
            'data' => $data,
            'owners' => $owners,
            'sortField' => $sortField,
            'sortOrder' => $sortOrder,
            'filters' => $filters
        ]);
    }
    
    private function processTableName($tableName)
    {
        if (preg_match('/_(\d+)$/', $tableName)) {
            return preg_replace('/_\d+$/', '', $tableName);
        }
        return $tableName;
    }
    

    public function edit(Request $request, $table)
    {
        $userId = Auth::id();
        $sortField = $request->input('sort_field', 'id');
        $sortOrder = $request->input('sort_order', 'asc');

        if (!Schema::hasTable($table)) {
            return redirect()->route('table.gestionar')->with('error', 'The table does not exist');
        }

        $sharedOwners = DB::table('share')
            ->where('shared_user', $userId)
            ->where('table_type', $table)
            ->where('edit', true)
            ->pluck('owner')
            ->toArray();

        $allowedOwners = array_merge([$userId], $sharedOwners);

        $filters = $request->except(['sort_field', 'sort_order', 'page']);

        $query = DB::table($table)->whereIn('owner_id', $allowedOwners);

        foreach ($filters as $field => $value) {
            if ($value) {
                $query->where($field, 'like', "%{$value}%");
            }
        }

        $perPage = 10;
        $data = $query->orderBy($sortField, $sortOrder)->paginate($perPage);

        $ownerIds = collect($data->items())->pluck('owner_id')->unique()->toArray();
        $owners = DB::table('users')->whereIn('id', $ownerIds)->pluck('name', 'id');

        return view('table.edit', [
            'table' => $table,
            'data' => $data,
            'owners' => $owners,
            'sortField' => $sortField,
            'sortOrder' => $sortOrder,
            'filters' => $filters
        ]);
    }

    public function update(Request $request, $table, $id)
    {
        // Verificar si la tabla existe
        if (!Schema::hasTable($table)) {
            return redirect()->route('table.gestionar')->with('error', 'The table does not exist');
        }

        // Obtener el ID del usuario actual
        $userId = Auth::id();

        // Verificar que el usuario tenga permisos para editar
        $allowedOwners = DB::table('share')
            ->where('shared_user', $userId)
            ->where('table_type', $table)
            ->where('edit', true)
            ->pluck('owner')
            ->toArray();

        $allowedOwners[] = $userId; // Incluir el ID del usuario actual

        // Verificar que el registro pertenece a un propietario permitido
        $record = DB::table($table)->where('id', $id)->first();

        if (!$record || !in_array($record->owner_id, $allowedOwners)) {
            return redirect()->route('table.edit', ['table' => $table])->with('error', 'You do not have permission to edit this record');
        }

        // Validar los datos del formulario (exceptuando _token, _method y updated_at)
        $validatedData = $request->except('_token', '_method', 'updated_at');

        // Obtener la descripción de la tabla
        $columns = Schema::getColumnListing($table);
        $validationRules = [];
        $validationMessages = [];

        foreach ($columns as $column) {
            if (in_array($column, ['id', 'owner_id', 'created_at', 'updated_at'])) {
                continue;
            }

            $columnType = Schema::getConnection()->getDoctrineColumn($table, $column);

            $rules = [];
            if (!$columnType->getNotnull()) {
                $rules[] = 'nullable';
            } else {
                $rules[] = 'required';
                $validationMessages["{$column}.required"] = "The field {$column} is required";
            }

            switch ($columnType->getType()->getName()) {
                case 'string':
                    $rules[] = 'string';
                    if ($columnType->getLength()) {
                        $rules[] = 'max:' . $columnType->getLength();
                        $validationMessages["{$column}.max"] = "The field {$column} must not exceed {$columnType->getLength()} characters";
                    }
                    break;
                case 'integer':
                    $rules[] = 'integer';
                    break;
                case 'float':
                case 'decimal':
                    $rules[] = 'numeric';
                    break;
                case 'boolean':
                    $rules[] = 'boolean';
                    break;
                case 'date':
                case 'datetime':
                    $rules[] = 'date';
                    break;
            }

            $validationRules[$column] = implode('|', $rules);
        }

        // Validar los datos del formulario
        $validatedData = $request->validate($validationRules, $validationMessages);

        // Actualizar el campo updated_at con la fecha y hora actual en la zona horaria de Madrid
        $validatedData['updated_at'] = now('Europe/Madrid');

        // Actualizar los datos del registro específico
        $affected = DB::table($table)
            ->where('id', $id)
            ->update($validatedData);

        if ($affected) {
            return redirect()->route('table.edit', ['table' => $table])->with('success', 'Data updated successfully');
        } else {
            return redirect()->route('table.edit', ['table' => $table])->with('error', 'No changes were made');
        }
    }

    public function deleteRecord(Request $request, $table, $id)
    {
        // Verificar si la tabla existe
        if (!Schema::hasTable($table)) {
            return redirect()->route('table.gestionar')->with('error', 'The table does not exist');
        }
    
        // Verificar que el usuario tenga permisos para eliminar
        $userId = Auth::id();
        $sharedOwners = DB::table('share')
            ->where('shared_user', $userId)
            ->where('table_type', $table)
            ->pluck('owner')
            ->toArray();
    
        $allowedOwners = array_merge([$userId], $sharedOwners);
    
        $record = DB::table($table)->where('id', $id)->first();
    
        if (!$record || !in_array($record->owner_id, $allowedOwners)) {
            return redirect()->route('table.edit', ['table' => $table])->with('error', 'You do not have permission to delete this record');
        }
    
        // Eliminar el registro
        DB::table($table)->where('id', $id)->delete();
    
        return redirect()->route('table.edit', ['table' => $table])->with('success', 'Record deleted successfully');
    }
    
    public function deleteTable(Request $request, $table)
    {
        $userId = Auth::user()->id;

        DB::table($table)->where('owner_id', $userId)->delete();

        $booleanFields = [
            'disc_collection' => 'discos',
            'travel_collection' => 'viajes',
            'contacts' => 'contactos',
            'shopping_list' => 'compra',
            'program_list' => 'programas',
            'accounts_list' => 'cuentas'
        ];

        if (array_key_exists($table, $booleanFields)) {
            $fieldToUpdate = $booleanFields[$table];
            DB::table('users')->where('id', $userId)->update([$fieldToUpdate => false]);
        }

        return redirect()->route('menu.gestionar')->with('success', 'Table and records deleted successfully');
    }

    public function share($table)
    {
        $userId = Auth::id();

        $sharedData = DB::table('share')
            ->join('users', 'share.shared_user', '=', 'users.id')
            ->where('table_type', $table)
            ->where('owner', $userId)
            ->select('share.*', 'users.name as user_name', 'users.profile_photo_path')
            ->get();

        return view('table.share', compact('table', 'sharedData'));
    }

    public function processShare(Request $request, $table)
    {
        $userId = Auth::id();
        $sharedUserId = $request->input('user_id');
        $permission = $request->input('permission');

        $existingShare = DB::table('share')
            ->where('table_type', $table)
            ->where('owner', $userId)
            ->where('shared_user', $sharedUserId)
            ->first();

        if ($existingShare) {
            if (($permission == 'edit' && $existingShare->edit) || ($permission == 'view' && $existingShare->view)) {
                return redirect()->route('table.share', ['table' => $table])
                    ->with('error', 'The table has already been shared with this user with the same permission.');
            }

            DB::table('share')
                ->where('id', $existingShare->id)
                ->update([
                    'view' => $permission == 'view',
                    'edit' => $permission == 'edit'
                ]);

            return redirect()->route('table.share', ['table' => $table])
                ->with('success', 'Table sharing permissions updated successfully.');
        } else {
            $data = [
                'table_type' => $table,
                'owner' => $userId,
                'shared_user' => $sharedUserId,
                'view' => $permission == 'view',
                'edit' => $permission == 'edit'
            ];

            DB::table('share')->insert($data);

            return redirect()->route('table.share', ['table' => $table])
                ->with('success', 'Table shared successfully.');
        }
    }

    public function deleteSharedAccess($id)
    {
        DB::table('share')->where('id', $id)->delete();

        return back()->with('success', 'Shared access removed successfully');
    }

    public function exportCsv(Request $request, $table)
    {
        $userId = Auth::id();
        $sortField = $request->input('sort_field', 'id');
        $sortOrder = $request->input('sort_order', 'asc');

        if (!Schema::hasTable($table)) {
            return redirect()->route('table.gestionar')->with('error', 'The table does not exist');
        }

        $sharedOwners = DB::table('share')
            ->where('shared_user', $userId)
            ->where('table_type', $table)
            ->pluck('owner')
            ->toArray();

        $allowedOwners = array_merge([$userId], $sharedOwners);

        $filters = $request->except(['sort_field', 'sort_order', 'page']);

        $query = DB::table($table)->whereIn('owner_id', $allowedOwners);

        foreach ($filters as $field => $value) {
            if ($value) {
                $query->where($field, 'like', "%{$value}%");
            }
        }

        $data = $query->orderBy($sortField, $sortOrder)->get();

        $ownerIds = $data->pluck('owner_id')->unique()->toArray();
        $owners = DB::table('users')->whereIn('id', $ownerIds)->pluck('name', 'id');

        $dataArray = [];
        foreach ($data as $row) {
            $rowArray = (array) $row;
            if (isset($rowArray['owner_id'])) {
                $rowArray['owner_id'] = $owners[$rowArray['owner_id']] . '#' . $rowArray['owner_id'];
            }
            $dataArray[] = $rowArray;
        }

        $filename = $table . '.csv';
        $handle = fopen('php://output', 'w');
        ob_start();

        fputcsv($handle, array_keys($dataArray[0]));

        foreach ($dataArray as $row) {
            fputcsv($handle, $row);
        }

        fclose($handle);
        $content = ob_get_clean();

        return Response::make($content, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }

    public function exportExcel(Request $request, $table)
    {
        $userId = Auth::id();
        $sortField = $request->input('sort_field', 'id');
        $sortOrder = $request->input('sort_order', 'asc');

        if (!Schema::hasTable($table)) {
            return redirect()->route('table.gestionar')->with('error', 'The table does not exist');
        }

        $sharedOwners = DB::table('share')
            ->where('shared_user', $userId)
            ->where('table_type', $table)
            ->pluck('owner')
            ->toArray();

        $allowedOwners = array_merge([$userId], $sharedOwners);

        $filters = $request->except(['sort_field', 'sort_order', 'page']);

        $query = DB::table($table)->whereIn('owner_id', $allowedOwners);

        foreach ($filters as $field => $value) {
            if ($value) {
                $query->where($field, 'like', "%{$value}%");
            }
        }

        $data = $query->orderBy($sortField, $sortOrder)->get();

        $ownerIds = $data->pluck('owner_id')->unique()->toArray();
        $owners = DB::table('users')->whereIn('id', $ownerIds)->pluck('name', 'id');

        $dataArray = [];
        foreach ($data as $row) {
            $dataArray[] = (array) $row;
        }

        return Excel::download(new TableExport($table, $dataArray, $owners), $table . '.xlsx');
    }

    public function create($table)
    {
        if (!Schema::hasTable($table)) {
            return redirect()->route('table.gestionar')->with('error', 'The table does not exist');
        }

        $columns = Schema::getColumnListing($table);
        $columnsInfo = [];

        foreach ($columns as $column) {
            if ($column != 'fecha_creacion' && $column != 'updated_at' && $column != 'id' && $column != 'owner_id') {
                $columnsInfo[$column] = !Schema::getConnection()->getDoctrineColumn($table, $column)->getNotnull();
            }
        }

        return view('table.create', [
            'table' => $table,
            'columnsInfo' => $columnsInfo
        ]);
    }

    public function store(Request $request, $table)
    {
        if (!Schema::hasTable($table)) {
            return redirect()->route('table.gestionar')->with('error', 'The table does not exist');
        }

        $columns = Schema::getColumnListing($table);
        $validationRules = [];
        $validationMessages = [];

        foreach ($columns as $column) {
            if (in_array($column, ['id', 'owner_id', 'created_at', 'updated_at'])) {
                continue;
            }

            $columnType = Schema::getConnection()->getDoctrineColumn($table, $column);

            $rules = [];
            if (!$columnType->getNotnull()) {
                $rules[] = 'nullable';
            } else {
                $rules[] = 'required';
                $validationMessages["{$column}.required"] = "The field {$column} is required";
            }

            switch ($columnType->getType()->getName()) {
                case 'string':
                    $rules[] = 'string';
                    if ($columnType->getLength()) {
                        $rules[] = 'max:' . $columnType->getLength();
                        $validationMessages["{$column}.max"] = "The field {$column} must not exceed {$columnType->getLength()} characters";
                    }
                    break;
                case 'integer':
                    $rules[] = 'integer';
                    break;
                case 'float':
                case 'decimal':
                    $rules[] = 'numeric';
                    break;
                case 'boolean':
                    $rules[] = 'boolean';
                    break;
                case 'date':
                case 'datetime':
                    $rules[] = 'date';
                    break;
            }

            $validationRules[$column] = implode('|', $rules);
        }

        $validatedData = $request->validate($validationRules, $validationMessages);

        $validatedData['owner_id'] = Auth::id();

        DB::table($table)->insert($validatedData);

        return redirect()->route('table.edit', ['table' => $table])->with('success', 'Record added successfully');
    }

    public function exportPdf(Request $request, $table)
    {
        $userId = Auth::id();
        $sortField = $request->input('sort_field', 'id');
        $sortOrder = $request->input('sort_order', 'asc');

        if (!Schema::hasTable($table)) {
            return redirect()->route('table.gestionar')->with('error', 'The table does not exist');
        }

        $sharedOwners = DB::table('share')
            ->where('shared_user', $userId)
            ->where('table_type', $table)
            ->pluck('owner')
            ->toArray();

        $allowedOwners = array_merge([$userId], $sharedOwners);

        $filters = $request->except(['sort_field', 'sort_order', 'page']);

        $query = DB::table($table)->whereIn('owner_id', $allowedOwners);

        foreach ($filters as $field => $value) {
            if ($value) {
                $query->where($field, 'like', "%{$value}%");
            }
        }

        $data = $query->orderBy($sortField, $sortOrder)->get();

        $ownerIds = $data->pluck('owner_id')->unique()->toArray();
        $owners = DB::table('users')->whereIn('id', $ownerIds)->pluck('name', 'id');

        $pdf = PDF::loadView('pdf.table', [
            'table' => $table,
            'data' => $data,
            'owners' => $owners,
            'sortField' => $sortField,
            'sortOrder' => $sortOrder,
            'filters' => $filters
        ])->setPaper('a4', 'landscape');

        return $pdf->download($table . '.pdf');
    }

    public function sendEmail(Request $request, $table)
    {
        $request->validate([
            'email' => 'required|email',
            'message' => 'nullable|string',
        ]);

        $user = Auth::user();
        $email = $request->input('email');
        $message = $request->input('message', '');
        $userName = $user->name;

        $notifiable = new NotifiableUser($email);

        Notification::send($notifiable, new ShareTableNotification($table, $message, $userName));

        return redirect()->route('table.share', ['table' => $table])
            ->with('success', 'Email sent successfully');
    }
}
