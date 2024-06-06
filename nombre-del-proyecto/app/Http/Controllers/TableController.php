<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use App\Exports\TableExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Mail;

class TableController extends Controller
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
            'coleccion_discos' => 'discos',
            'coleccion_viajes' => 'viajes',
            'agenda_contactos' => 'contactos',
            'lista_compra' => 'compra',
            'lista_programas' => 'programas',
            'lista_cuentas' => 'cuentas'
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
            return redirect()->route('table.gestionar')->with('error', 'La tabla no existe.');
        }

        // Obtener los IDs de propietarios con permisos compartidos
        $sharedOwners = DB::table('compartir')
            ->where('usuario_compartido', $userId)
            ->where('tipo_tabla', $table)
            ->pluck('propietario')
            ->toArray();

        // Incluir el ID del usuario actual
        $allowedOwners = array_merge([$userId], $sharedOwners);

        // Obtener los filtros
        $filters = $request->except(['sort_field', 'sort_order', 'page']);

        // Obtener datos de la tabla donde el id_propietario está en la lista de propietarios permitidos y aplicar filtros
        $query = DB::table($table)->whereIn('id_propietario', $allowedOwners);

        foreach ($filters as $field => $value) {
            if ($value) {
                $query->where($field, 'like', "%{$value}%");
            }
        }

        $data = $query->orderBy($sortField, $sortOrder)->get();

        // Obtener los nombres de los propietarios
        $ownerIds = $data->pluck('id_propietario')->unique()->toArray();
        $owners = DB::table('users')->whereIn('id', $ownerIds)->pluck('name', 'id');

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
            return redirect()->route('table.gestionar')->with('error', 'La tabla no existe.');
        }

        // Obtener los IDs de propietarios con permisos compartidos para edición
        $sharedOwners = DB::table('compartir')
            ->where('usuario_compartido', $userId)
            ->where('tipo_tabla', $table)
            ->where('editar', true)
            ->pluck('propietario')
            ->toArray();

        // Incluir el ID del usuario actual
        $allowedOwners = array_merge([$userId], $sharedOwners);

        // Obtener los filtros
        $filters = $request->except(['sort_field', 'sort_order', 'page']);

        // Obtener datos de la tabla donde el id_propietario está en la lista de propietarios permitidos y aplicar filtros
        $query = DB::table($table)->whereIn('id_propietario', $allowedOwners);

        foreach ($filters as $field => $value) {
            if ($value) {
                $query->where($field, 'like', "%{$value}%");
            }
        }

        $data = $query->orderBy($sortField, $sortOrder)->get();

        // Obtener los nombres de los propietarios
        $ownerIds = $data->pluck('id_propietario')->unique()->toArray();
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
            return redirect()->route('table.gestionar')->with('error', 'La tabla no existe.');
        }
    
        // Obtener el ID del usuario actual
        $userId = Auth::id();
    
        // Verificar que el usuario tenga permisos para editar
        $allowedOwners = DB::table('compartir')
            ->where('usuario_compartido', $userId)
            ->where('tipo_tabla', $table)
            ->where('editar', true)
            ->pluck('propietario')
            ->toArray();
    
        $allowedOwners[] = $userId; // Incluir el ID del usuario actual
    
        // Verificar que el registro pertenece a un propietario permitido
        $record = DB::table($table)->where('id', $id)->first();
    
        if (!$record || !in_array($record->id_propietario, $allowedOwners)) {
            return redirect()->route('table.edit', ['table' => $table])->with('error', 'No tienes permiso para editar este registro.');
        }
    
        // Validar los datos del formulario (exceptuando _token, _method y ULTIMA_MODIFICACION)
        $validatedData = $request->except('_token', '_method', 'ULTIMA_MODIFICACION');
    
        // Puedes añadir reglas de validación si es necesario
        $validatedData = $request->validate([
            'articulo' => 'required|string|max:255',
            'cantidad' => 'required|integer',
            'precio' => 'required|numeric',
            'peso_volumen' => 'required|numeric',
            'unidad_de_medida' => 'nullable|string|max:255',
            'tienda' => 'nullable|string|max:255',
            'fecha_creacion' => 'required|date',
            // No necesitas validar 'ULTIMA_MODIFICACION' porque lo actualizarás manualmente
        ]);
    
        // Actualizar el campo ULTIMA_MODIFICACION con la fecha y hora actual en la zona horaria de Madrid
        $validatedData['ultima_modificacion'] = now('Europe/Madrid');
    
        // Actualizar los datos del registro específico
        $affected = DB::table($table)
            ->where('id', $id)
            ->update($validatedData);
    
        if ($affected) {
            return redirect()->route('table.edit', ['table' => $table])->with('success', 'Datos actualizados correctamente.');
        } else {
            return redirect()->route('table.edit', ['table' => $table])->with('error', 'No se realizaron cambios.');
        }
    }
    
    

    public function deleteRecord(Request $request, $table, $id)
    {
        // Verificar si la tabla existe
        if (!Schema::hasTable($table)) {
            return redirect()->route('table.gestionar')->with('error', 'La tabla no existe.');
        }

        // Eliminar el registro sin importar el propietario
        DB::table($table)->where('id', $id)->delete();

        return redirect()->route('table.edit', ['table' => $table])->with('success', 'Registro eliminado correctamente.');
    }

    // Eliminar la tabla y sus registros
    public function deleteTable(Request $request, $table)
    {
        $userId = Auth::user()->id;

        // Eliminar todos los registros asociados al propietario
        DB::table($table)->where('id_propietario', $userId)->delete();

        // Determinar el campo booleano a actualizar
        $booleanFields = [
            'coleccion_discos' => 'discos',
            'coleccion_viajes' => 'viajes',
            'agenda_contactos' => 'contactos',
            'lista_compra' => 'compra',
            'lista_programas' => 'programas',
            'lista_cuentas' => 'cuentas'
        ];

        // Actualizar el campo booleano correspondiente en la tabla users
        if (array_key_exists($table, $booleanFields)) {
            $fieldToUpdate = $booleanFields[$table];
            DB::table('users')->where('id', $userId)->update([$fieldToUpdate => false]);
        }

        return redirect()->route('table.gestionar')->with('success', 'Tabla y registros eliminados correctamente.');
    }

    // Compartir la tabla
    public function share($table)
    {
        // Obtener los datos compartidos
        $sharedData = DB::table('compartir')
            ->join('users', 'compartir.usuario_compartido', '=', 'users.id')
            ->where('tipo_tabla', $table)
            ->select('compartir.*', 'users.name as user_name')
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
            'tipo_tabla' => $table,
            'propietario' => $userId,
            'usuario_compartido' => $sharedUserId,
            'visualizar' => true,
            'editar' => $permission == 'editar'
        ];

        DB::table('compartir')->insert($data);

        return redirect()->route('table.share', ['table' => $table])
            ->with('success', 'Tabla compartida correctamente.');
    }

    // Eliminar acceso compartido
    public function deleteSharedAccess($id)
    {
        DB::table('compartir')->where('id', $id)->delete();

        return back()->with('success', 'Acceso compartido eliminado correctamente.');
    }

    // Métodos para exportar tablas
    public function exportCsv(Request $request, $table)
    {
        $userId = Auth::id();
        $sortField = $request->input('sort_field', 'id');
        $sortOrder = $request->input('sort_order', 'asc');

        // Verificar si la tabla existe
        if (!Schema::hasTable($table)) {
            return redirect()->route('table.gestionar')->with('error', 'La tabla no existe.');
        }

        // Obtener los IDs de propietarios con permisos compartidos
        $sharedOwners = DB::table('compartir')
            ->where('usuario_compartido', $userId)
            ->where('tipo_tabla', $table)
            ->pluck('propietario')
            ->toArray();

        // Incluir el ID del usuario actual
        $allowedOwners = array_merge([$userId], $sharedOwners);

        // Obtener los filtros
        $filters = $request->except(['sort_field', 'sort_order', 'page']);

        // Obtener datos de la tabla donde el id_propietario está en la lista de propietarios permitidos y aplicar filtros
        $query = DB::table($table)->whereIn('id_propietario', $allowedOwners);

        foreach ($filters as $field => $value) {
            if ($value) {
                $query->where($field, 'like', "%{$value}%");
            }
        }

        $data = $query->orderBy($sortField, $sortOrder)->get();

        // Obtener los nombres de los propietarios
        $ownerIds = $data->pluck('id_propietario')->unique()->toArray();
        $owners = DB::table('users')->whereIn('id', $ownerIds)->pluck('name', 'id');

        // Convertir los datos a un array
        $dataArray = [];
        foreach ($data as $row) {
            $rowArray = (array) $row;
            if (isset($rowArray['id_propietario'])) {
                $rowArray['id_propietario'] = $owners[$rowArray['id_propietario']] . '#' . $rowArray['id_propietario'];
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
            return redirect()->route('table.gestionar')->with('error', 'La tabla no existe.');
        }

        // Obtener los IDs de propietarios con permisos compartidos
        $sharedOwners = DB::table('compartir')
            ->where('usuario_compartido', $userId)
            ->where('tipo_tabla', $table)
            ->pluck('propietario')
            ->toArray();

        // Incluir el ID del usuario actual
        $allowedOwners = array_merge([$userId], $sharedOwners);

        // Obtener los filtros
        $filters = $request->except(['sort_field', 'sort_order', 'page']);

        // Obtener datos de la tabla donde el id_propietario está en la lista de propietarios permitidos y aplicar filtros
        $query = DB::table($table)->whereIn('id_propietario', $allowedOwners);

        foreach ($filters as $field => $value) {
            if ($value) {
                $query->where($field, 'like', "%{$value}%");
            }
        }

        $data = $query->orderBy($sortField, $sortOrder)->get();

        // Obtener los nombres de los propietarios
        $ownerIds = $data->pluck('id_propietario')->unique()->toArray();
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
            return redirect()->route('table.gestionar')->with('error', 'La tabla no existe.');
        }

        // Obtener los nombres de las columnas de la tabla y sus propiedades
        $columns = Schema::getColumnListing($table);
        $columnsInfo = [];
        
        foreach ($columns as $column) {
            if ($column != 'fecha_creacion' && $column != 'ultima_modificacion' && $column != 'id' && $column != 'id_propietario') {
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
            return redirect()->route('table.gestionar')->with('error', 'La tabla no existe.');
        }

        // Obtener la descripción de la tabla
        $columns = Schema::getColumnListing($table);
        $validationRules = [];
        $validationMessages = [];

        foreach ($columns as $column) {
            // Omitir ciertas columnas
            if (in_array($column, ['id', 'id_propietario', 'fecha_creacion', 'ultima_modificacion'])) {
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
                $validationMessages["{$column}.required"] = "El campo {$column} es obligatorio.";
            }

            switch ($columnType->getType()->getName()) {
                case 'string':
                    $rules[] = 'string';
                    if ($columnType->getLength()) {
                        $rules[] = 'max:' . $columnType->getLength();
                        $validationMessages["{$column}.max"] = "El campo {$column} no debe exceder de {$columnType->getLength()} caracteres.";
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
        $validatedData['id_propietario'] = Auth::id();

        // Insertar el nuevo registro en la tabla
        DB::table($table)->insert($validatedData);

        return redirect()->route('table.edit', ['table' => $table])->with('success', 'Registro añadido correctamente.');
    }
    public function exportPdf(Request $request, $table)
    {
        $userId = Auth::id();
        $sortField = $request->input('sort_field', 'id'); // Campo por defecto para ordenar
        $sortOrder = $request->input('sort_order', 'asc'); // Orden por defecto

        // Verificar si la tabla existe
        if (!Schema::hasTable($table)) {
            return redirect()->route('table.gestionar')->with('error', 'La tabla no existe.');
        }

        // Obtener los IDs de propietarios con permisos compartidos
        $sharedOwners = DB::table('compartir')
            ->where('usuario_compartido', $userId)
            ->where('tipo_tabla', $table)
            ->pluck('propietario')
            ->toArray();

        // Incluir el ID del usuario actual
        $allowedOwners = array_merge([$userId], $sharedOwners);

        // Obtener los filtros
        $filters = $request->except(['sort_field', 'sort_order', 'page']);

        // Obtener datos de la tabla donde el id_propietario está en la lista de propietarios permitidos y aplicar filtros
        $query = DB::table($table)->whereIn('id_propietario', $allowedOwners);

        foreach ($filters as $field => $value) {
            if ($value) {
                $query->where($field, 'like', "%{$value}%");
            }
        }

        $data = $query->orderBy($sortField, $sortOrder)->get();

        // Obtener los nombres de los propietarios
        $ownerIds = $data->pluck('id_propietario')->unique()->toArray();
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

        $userId = Auth::id();
        $sortField = $request->input('sort_field', 'id');
        $sortOrder = $request->input('sort_order', 'asc');

        // Verificar si la tabla existe
        if (!Schema::hasTable($table)) {
            return redirect()->route('table.gestionar')->with('error', 'La tabla no existe.');
        }

        // Obtener los datos de la tabla aplicando los filtros
        $filters = $request->except(['sort_field', 'sort_order', 'page']);
        $query = DB::table($table)->where('id_propietario', $userId);

        foreach ($filters as $field => $value) {
            if ($value) {
                $query->where($field, 'like', "%{$value}%");
            }
        }

        $data = $query->orderBy($sortField, $sortOrder)->get();

        // Crear el contenido del correo
        $emailData = [
            'table' => $table,
            'data' => $data,
            'message' => $request->input('message', '')
        ];

        // Enviar el correo
        Mail::send('emails.shareTable', $emailData, function ($message) use ($request, $table) {
            $message->to($request->input('email'))
                ->subject('Compartir Tabla: ' . str_replace('_', ' ', $table));
        });

        return redirect()->route('table.share', ['table' => $table])->with('success', 'Correo enviado correctamente.');
    }
}
