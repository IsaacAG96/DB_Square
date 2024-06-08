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
    // Mostrar las tablas que tiene el usuario
    public function gestionar()
    {
        $user = Auth::user();
        $userId = $user->id;

        // Obtener los campos booleanos del usuario
        $userTables = DB::table('users')->where('id', $userId)->first([
            'discos', 'viajes', 'contactos', 'compra', 'programas', 'cuentas'
        ]);

        // Definir las tablas y sus campos booleanos correspondientes
        $tables = [
            'disc_collection' => 'discos',
            'travel_collection' => 'viajes',
            'contacts' => 'contactos',
            'shopping_list' => 'compra',
            'program_list' => 'programas',
            'accounts_list' => 'cuentas'
        ];

        // Filtrar las tablas basándose en los campos booleanos del usuario
        $availableTables = [];
        foreach ($tables as $table => $booleanField) {
            if ($userTables->$booleanField) {
                $availableTables[] = $table;
            }
        }

        // Paginar los resultados
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
        $sortField = $request->input('sort_field', 'id'); // Campo por defecto para ordenar
        $sortOrder = $request->input('sort_order', 'asc'); // Orden por defecto

        // Verificar si la tabla existe
        if (!Schema::hasTable($table)) {
            return redirect()->route('table.gestionar')->with('error', 'The table does not exist');
        }

        // Obtener los IDs de propietarios con permisos compartidos
        $sharedOwners = DB::table('share')
            ->where('shared_user', $userId)
            ->where('table_type', $table)
            ->pluck('owner')
            ->toArray();

        // Incluir el ID del usuario actual
        $allowedOwners = array_merge([$userId], $sharedOwners);

        // Obtener los filtros
        $filters = $request->except(['sort_field', 'sort_order', 'page']);

        // Obtener datos de la tabla donde el id_propietario está en la lista de propietarios permitidos y aplicar filtros
        $query = DB::table($table)->whereIn('owner_id', $allowedOwners);

        foreach ($filters as $field => $value) {
            if ($value) {
                $query->where($field, 'like', "%{$value}%");
            }
        }

        $perPage = 10; // Número de registros por página
        $data = $query->orderBy($sortField, $sortOrder)->paginate($perPage);

        // Obtener los nombres de los propietarios
        $ownerIds = collect($data->items())->pluck('owner_id')->unique()->toArray();
        $owners = DB::table('users')
            ->whereIn('id', $ownerIds)
            ->get(['id', 'name', 'profile_photo_path'])
            ->keyBy('id');

        return view('table.view', [
            'table' => $table,
            'data' => $data,
            'owners' => $owners,
            'sortField' => $sortField,
            'sortOrder' => $sortOrder,
            'filters' => $filters
        ]);
    }


    public function edit(Request $request, $table)
    {
        $userId = Auth::id();
        $sortField = $request->input('sort_field', 'id'); // Campo por defecto para ordenar
        $sortOrder = $request->input('sort_order', 'asc'); // Orden por defecto

        // Verificar si la tabla existe
        if (!Schema::hasTable($table)) {
            return redirect()->route('table.gestionar')->with('error', 'The table does not exist');
        }

        // Obtener los IDs de propietarios con permisos compartidos para edición
        $sharedOwners = DB::table('share')
            ->where('shared_user', $userId)
            ->where('table_type', $table)
            ->where('edit', true)
            ->pluck('owner')
            ->toArray();

        // Incluir el ID del usuario actual
        $allowedOwners = array_merge([$userId], $sharedOwners);

        // Obtener los filtros
        $filters = $request->except(['sort_field', 'sort_order', 'page']);

        // Obtener datos de la tabla donde el id_propietario está en la lista de propietarios permitidos y aplicar filtros
        $query = DB::table($table)->whereIn('owner_id', $allowedOwners);

        foreach ($filters as $field => $value) {
            if ($value) {
                $query->where($field, 'like', "%{$value}%");
            }
        }

        $perPage = 10; // Número de registros por página
        $data = $query->orderBy($sortField, $sortOrder)->paginate($perPage);

        // Obtener los nombres de los propietarios
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

        if (!$record || !in_array($record->id_propietario, $allowedOwners)) {
            return redirect()->route('table.edit', ['table' => $table])->with('error', 'You do not have permission to edit this record');
        }

        // Validar los datos del formulario (exceptuando _token, _method y ULTIMA_MODIFICACION)
        $validatedData = $request->except('_token', '_method', 'updated_at');

        // Puedes añadir reglas de validación si es necesario
        $validatedData = $request->validate([
            'item' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'weight_volume' => 'required|numeric',
            'unit_of_measurement' => 'nullable|string|max:255',
            'store' => 'nullable|string|max:255',
            'created_at' => 'required|date',
        ]);

        // Actualizar el campo ULTIMA_MODIFICACION con la fecha y hora actual en la zona horaria de Madrid
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

        // Eliminar el registro sin importar el propietario
        DB::table($table)->where('id', $id)->delete();

        return redirect()->route('table.edit', ['table' => $table])->with('success', 'Record deleted successfully');
    }

    // Eliminar la tabla y sus registros
    public function deleteTable(Request $request, $table)
    {
        $userId = Auth::user()->id;

        // Eliminar todos los registros asociados al propietario
        DB::table($table)->where('owner_id', $userId)->delete();

        // Determinar el campo booleano a actualizar
        $booleanFields = [
            'disc_collection' => 'discos',
            'travel_collection' => 'viajes',
            'contacts' => 'contactos',
            'shopping_list' => 'compra',
            'program_list' => 'programas',
            'accounts_list' => 'cuentas'
        ];

        // Actualizar el campo booleano correspondiente en la tabla users
        if (array_key_exists($table, $booleanFields)) {
            $fieldToUpdate = $booleanFields[$table];
            DB::table('users')->where('id', $userId)->update([$fieldToUpdate => false]);
        }

        return redirect()->route('table.gestionar')->with('success', 'Table and records deleted successfully');
    }

    // Compartir la tabla
    public function share($table)
    {
        $userId = Auth::id();

        // Obtener los datos compartidos
        $sharedData = DB::table('share')
            ->join('users', 'share.shared_user', '=', 'users.id')
            ->where('table_type', $table)
            ->where('owner', $userId) // Asegúrate de que solo se incluyen las filas del propietario actual
            ->select('share.*', 'users.name as user_name', 'users.profile_photo_path')
            ->get();

        return view('table.share', compact('table', 'sharedData'));
    }

    // Procesar compartir la tabla
    public function processShare(Request $request, $table)
    {
        $userId = Auth::id();
        $sharedUserId = $request->input('user_id');
        $permission = $request->input('permission');

        $data = [
            'table_type' => $table,
            'owner' => $userId,
            'shared_user' => $sharedUserId,
            'view' => true,
            'edit' => $permission == 'edit'
        ];

        DB::table('share')->insert($data);

        return redirect()->route('table.share', ['table' => $table])
            ->with('success', 'Table shared successfully');
    }

    // Eliminar acceso compartido
    public function deleteSharedAccess($id)
    {
        DB::table('share')->where('id', $id)->delete();

        return back()->with('success', 'Shared access removed successfully');
    }

    // Métodos para exportar tablas
    public function exportCsv(Request $request, $table)
    {
        $userId = Auth::id();
        $sortField = $request->input('sort_field', 'id');
        $sortOrder = $request->input('sort_order', 'asc');

        // Verificar si la tabla existe
        if (!Schema::hasTable($table)) {
            return redirect()->route('table.gestionar')->with('error', 'The table does not exist');
        }

        // Obtener los IDs de propietarios con permisos compartidos
        $sharedOwners = DB::table('share')
            ->where('shared_user', $userId)
            ->where('table_type', $table)
            ->pluck('owner')
            ->toArray();

        // Incluir el ID del usuario actual
        $allowedOwners = array_merge([$userId], $sharedOwners);

        // Obtener los filtros
        $filters = $request->except(['sort_field', 'sort_order', 'page']);

        // Obtener datos de la tabla donde el id_propietario está en la lista de propietarios permitidos y aplicar filtros
        $query = DB::table($table)->whereIn('owner_id', $allowedOwners);

        foreach ($filters as $field => $value) {
            if ($value) {
                $query->where($field, 'like', "%{$value}%");
            }
        }

        $data = $query->orderBy($sortField, $sortOrder)->get();

        // Obtener los nombres de los propietarios
        $ownerIds = $data->pluck('owner_id')->unique()->toArray();
        $owners = DB::table('users')->whereIn('id', $ownerIds)->pluck('name', 'id');

        // Convertir los datos a un array
        $dataArray = [];
        foreach ($data as $row) {
            $rowArray = (array) $row;
            if (isset($rowArray['owner_id'])) {
                $rowArray['owner_id'] = $owners[$rowArray['owner_id']] . '#' . $rowArray['owner_id'];
            }
            $dataArray[] = $rowArray;
        }

        // Crear el archivo CSV
        $filename = $table . '.csv';
        $handle = fopen('php://output', 'w');
        ob_start();

        // Agregar encabezados de las columnas
        fputcsv($handle, array_keys($dataArray[0]));

        // Agregar datos de las filas
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

        // Verificar si la tabla existe
        if (!Schema::hasTable($table)) {
            return redirect()->route('table.gestionar')->with('error', 'The table does not exist');
        }

        // Obtener los IDs de propietarios con permisos compartidos
        $sharedOwners = DB::table('share')
            ->where('shared_user', $userId)
            ->where('table_type', $table)
            ->pluck('owner')
            ->toArray();

        // Incluir el ID del usuario actual
        $allowedOwners = array_merge([$userId], $sharedOwners);

        // Obtener los filtros
        $filters = $request->except(['sort_field', 'sort_order', 'page']);

        // Obtener datos de la tabla donde el id_propietario está en la lista de propietarios permitidos y aplicar filtros
        $query = DB::table($table)->whereIn('owner_id', $allowedOwners);

        foreach ($filters as $field => $value) {
            if ($value) {
                $query->where($field, 'like', "%{$value}%");
            }
        }

        $data = $query->orderBy($sortField, $sortOrder)->get();

        // Obtener los nombres de los propietarios
        $ownerIds = $data->pluck('owner_id')->unique()->toArray();
        $owners = DB::table('users')->whereIn('id', $ownerIds)->pluck('name', 'id');

        // Convertir los datos a un array
        $dataArray = [];
        foreach ($data as $row) {
            $dataArray[] = (array) $row;
        }

        // Generar el archivo Excel
        return Excel::download(new TableExport($table, $dataArray, $owners), $table . '.xlsx');
    }

    private function getDataForTable($table)
    {
        // Implementa este método para obtener los datos de la tabla
        return DB::table($table)->get();
    }

    public function create($table)
    {
        // Verificar si la tabla existe
        if (!Schema::hasTable($table)) {
            return redirect()->route('table.gestionar')->with('error', 'The table does not exist');
        }

        // Obtener los nombres de las columnas de la tabla y sus propiedades
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
        // Verificar si la tabla existe
        if (!Schema::hasTable($table)) {
            return redirect()->route('table.gestionar')->with('error', 'The table does not exist');
        }

        // Obtener la descripción de la tabla
        $columns = Schema::getColumnListing($table);
        $validationRules = [];
        $validationMessages = [];

        foreach ($columns as $column) {
            // Omitir ciertas columnas
            if (in_array($column, ['id', 'owner_id', 'fecha_creacion', 'updated_at'])) {
                continue;
            }

            // Obtener la definición de la columna
            $columnType = Schema::getConnection()->getDoctrineColumn($table, $column);

            // Construir reglas de validación
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
                    // Añadir más tipos según sea necesario
            }

            $validationRules[$column] = implode('|', $rules);
        }

        // Validar los datos del formulario
        $validatedData = $request->validate($validationRules, $validationMessages);

        // Añadir el id_propietario al nuevo registro
        $validatedData['owner_id'] = Auth::id();

        // Insertar el nuevo registro en la tabla
        DB::table($table)->insert($validatedData);

        return redirect()->route('table.edit', ['table' => $table])->with('success', 'Record added successfully');
    }
    public function exportPdf(Request $request, $table)
    {
        $userId = Auth::id();
        $sortField = $request->input('sort_field', 'id'); // Campo por defecto para ordenar
        $sortOrder = $request->input('sort_order', 'asc'); // Orden por defecto

        // Verificar si la tabla existe
        if (!Schema::hasTable($table)) {
            return redirect()->route('table.gestionar')->with('error', 'The table does not exist');
        }

        // Obtener los IDs de propietarios con permisos compartidos
        $sharedOwners = DB::table('share')
            ->where('shared_user', $userId)
            ->where('table_type', $table)
            ->pluck('owner')
            ->toArray();

        // Incluir el ID del usuario actual
        $allowedOwners = array_merge([$userId], $sharedOwners);

        // Obtener los filtros
        $filters = $request->except(['sort_field', 'sort_order', 'page']);

        // Obtener datos de la tabla donde el id_propietario está en la lista de propietarios permitidos y aplicar filtros
        $query = DB::table($table)->whereIn('owner_id', $allowedOwners);

        foreach ($filters as $field => $value) {
            if ($value) {
                $query->where($field, 'like', "%{$value}%");
            }
        }

        $data = $query->orderBy($sortField, $sortOrder)->get();

        // Obtener los nombres de los propietarios
        $ownerIds = $data->pluck('owner_id')->unique()->toArray();
        $owners = DB::table('users')->whereIn('id', $ownerIds)->pluck('name', 'id');

        $pdf = PDF::loadView('pdf.table', [
            'table' => $table,
            'data' => $data,
            'owners' => $owners,
            'sortField' => $sortField,
            'sortOrder' => $sortOrder,
            'filters' => $filters
        ])->setPaper('a4', 'landscape'); // Configurar orientación horizontal

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
        $userName = $user->name; // Obtener el nombre del usuario que comparte la tabla

        // Crear el objeto notifiable
        $notifiable = new NotifiableUser($email);

        // Enviar la notificación
        Notification::send($notifiable, new ShareTableNotification($table, $message, $userName));

        return redirect()->route('table.share', ['table' => $table])
            ->with('success', 'Email sent successfully');
    }
}
