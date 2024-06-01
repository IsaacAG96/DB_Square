<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

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
    

    
    


    // Editar la tabla
    public function edit($table)
    {
        return view('table.edit', compact('table'));
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
}
