<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\Paginator;

class MenuController extends Controller
{
    public function index()
    {
        if (!Session::has('welcome_shown')) {
            Session::put('welcome_shown', true);
            $showWelcomeMessage = true;
        } else {
            $showWelcomeMessage = false;
        }

        return view('menu.index', compact('showWelcomeMessage'));
    }

    public function importar()
    {
        $excludedTables = [
            'failed_jobs', 'migrations', 'model_has_permissions', 'model_has_roles',
            'password_reset_tokens', 'permissions', 'personal_access_tokens', 'roles',
            'role_has_permissions', 'sessions', 'teams', 'team_invitations', 'team_user',
            'telescope_entries', 'telescope_entries_tags', 'telescope_monitoring', 'users',
            'compartir'
        ];

        $excludedFields = ['id', 'fecha_creacion', 'ultima_modificacion', 'id_propietario'];

        $tables = Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();

        $filteredTables = [];
        foreach ($tables as $table) {
            if (!in_array($table, $excludedTables)) {
                $columns = Schema::getColumnListing($table);
                $filteredColumns = array_diff($columns, $excludedFields);
                $filteredTables[$table] = $filteredColumns;
            }
        }

        // Paginar las tablas, 5 por página
        $perPage = 5;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentPageItems = array_slice($filteredTables, ($currentPage - 1) * $perPage, $perPage);

        $paginatedTables = new LengthAwarePaginator(
            $currentPageItems,
            count($filteredTables),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );

        $user = auth()->user();

        $importedTables = [
            'agenda_contactos' => $user->contactos,
            'coleccion_discos' => $user->discos,
            'coleccion_viajes' => $user->viajes,
            'lista_compra' => $user->compra,
            'lista_programas' => $user->programas,
            'lista_cuentas' => $user->cuentas,
        ];

        return view('menu.importar', [
            'tables' => $paginatedTables,
            'importedTables' => $importedTables
        ]);
    }

    public function gestionar()
    {
        $userId = auth()->user()->id;
        $user = auth()->user();

        $tableMappings = [
            'coleccion_discos' => 'discos',
            'coleccion_viajes' => 'viajes',
            'agenda_contactos' => 'contactos',
            'lista_compra' => 'compra',
            'lista_programas' => 'programas',
            'lista_cuentas' => 'cuentas'
        ];

        $tableData = [];

        foreach ($tableMappings as $table => $field) {
            if ($user->$field) {
                // Contar registros donde id_propietario es igual al ID del usuario
                $count = DB::table($table)->where('id_propietario', $userId)->count();

                // Buscar en la tabla compartir para las tablas compartidas con el usuario
                $sharedCount = DB::table('compartir')
                    ->where('usuario_compartido', $userId)
                    ->where('tipo_tabla', $table)
                    ->count();

                // Sumar los registros propios y compartidos
                $totalCount = $count + $sharedCount;

                if ($totalCount > 0) {
                    $tableData[$table] = $totalCount;
                }
            }
        }

        // Convertir la colección a una instancia de LengthAwarePaginator
        $currentPage = Paginator::resolveCurrentPage();
        $perPage = 10;
        $currentPageItems = array_slice($tableData, ($currentPage - 1) * $perPage, $perPage);
        $paginatedTables = new LengthAwarePaginator($currentPageItems, count($tableData), $perPage, $currentPage, [
            'path' => Paginator::resolveCurrentPath()
        ]);

        return view('menu.gestionar', ['tables' => $paginatedTables]);
    }

    public function gestionarTablas()
    {
        $userId = auth()->user()->id;

        $tables = collect([
            'coleccion_discos' => auth()->user()->discos,
            'agenda_contactos' => auth()->user()->contactos,
            'coleccion_viajes' => auth()->user()->viajes,
            'lista_compra' => auth()->user()->compra,
            'lista_programas' => auth()->user()->programas,
            'lista_cuentas' => auth()->user()->cuentas,
        ])->filter();

        $tableData = $tables->mapWithKeys(function ($enabled, $table) use ($userId) {
            $count = DB::table($table)
                ->where('id_propietario', $userId)
                ->count();

            $sharedCount = DB::table('compartir')
                ->where('usuario_compartido', $userId)
                ->where('tipo_tabla', $table)
                ->count();

            return [$table => $count + $sharedCount];
        });

        // Convertir la colección a una instancia de LengthAwarePaginator
        $currentPage = Paginator::resolveCurrentPage();
        $perPage = 10;
        $currentPageItems = $tableData->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $paginatedTables = new LengthAwarePaginator($currentPageItems, $tableData->count(), $perPage, $currentPage, [
            'path' => Paginator::resolveCurrentPath()
        ]);

        return view('menu.gestionar', ['tables' => $paginatedTables]);
    }

    public function editTable($table)
    {
        // Lógica para editar la tabla
        // Devuelve una vista con un formulario de edición para la tabla específica
        return view('menu.edit', compact('table'));
    }

    public function deleteTable(Request $request, $table)
    {
        $userId = Auth::user()->id;
    
        // Eliminar todos los registros asociados al propietario
        DB::table($table)->where('id_propietario', $userId)->delete();
    
        // Cambiar el booleano de la tabla users
        DB::table('users')->where('id', $userId)->update([$table => false]);
    
        return redirect()->route('menu.index')->with('success', 'Tabla y registros eliminados correctamente.');
    }

    public function viewTable($table)
    {
        // Verificar si la tabla existe
        if (!Schema::hasTable($table)) {
            return redirect()->route('menu.gestionar')->with('error', 'La tabla no existe.');
        }

        // Obtener datos de la tabla
        $data = DB::table($table)->get();

        return view('menu.view', [
            'table' => $table,
            'data' => $data
        ]);
    }

    public function importTable(Request $request)
    {
        $user = Auth::user();
        $tableName = $request->input('table');

        // Cambia el campo correspondiente a true
        switch ($tableName) {
            case 'agenda_contactos':
                $user->contactos = true;
                break;
            case 'coleccion_discos':
                $user->discos = true;
                break;
            case 'coleccion_viajes':
                $user->viajes = true;
                break;
            case 'lista_compra':
                $user->compra = true;
                break;
            case 'lista_programas':
                $user->programas = true;
                break;
            case 'lista_cuentas':
                $user->cuentas = true;
                break;
            default:
                return redirect()->route('menu.importar')->with('error', 'Tabla no válida.');
        }

        $user->save();

        return redirect()->route('menu.importar')->with('success', 'Tabla importada correctamente.');
    }
}
