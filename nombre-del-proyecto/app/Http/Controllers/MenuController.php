<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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

    public function importar(Request $request)
    {
        $tables = [];
        $excludedTables = [
            'failed_jobs', 'migrations', 'model_has_permissions', 'model_has_roles',
            'password_reset_tokens', 'permissions', 'personal_access_tokens', 'roles',
            'role_has_permissions', 'sessions', 'teams', 'team_invitations', 'team_user',
            'telescope_entries', 'telescope_entries_tags', 'telescope_monitoring', 'users',
            'compartir' // Excluir la tabla 'compartir'
        ];
        $excludedFields = ['id', 'fecha_creacion', 'ultima_modificacion', 'permiso_visualizar', 'id_propietario'];

        // Obtener todas las tablas
        $allTables = DB::connection()->getDoctrineSchemaManager()->listTableNames();

        foreach ($allTables as $tableName) {
            // Excluir tablas específicas
            if (!in_array($tableName, $excludedTables)) {
                if (Schema::hasTable($tableName)) {
                    // Obtener columnas de la tabla
                    $columns = Schema::getColumnListing($tableName);
                    // Filtrar los campos excluidos
                    $filteredColumns = array_diff($columns, $excludedFields);
                    $tables[$tableName] = $filteredColumns;
                }
            }
        }

        // Paginación
        $perPage = 5;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $tableCollection = collect($tables);
        $currentTables = $tableCollection->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $paginatedTables = new LengthAwarePaginator($currentTables, $tableCollection->count(), $perPage);
        $paginatedTables->setPath($request->url());

        // Obtener el usuario autenticado
        $user = Auth::user();
        $importedTables = [
            'agenda_contactos' => $user->contactos,
            'coleccion_discos' => $user->discos,
            'coleccion_viajes' => $user->viajes,
            'lista_compra' => $user->compra,
            'lista_programas' => $user->programas,
            'lista_cuentas' => $user->cuentas,
        ];

        return view('menu.importar', ['tables' => $paginatedTables, 'importedTables' => $importedTables]);
    }

    public function gestionar()
    {
        $user = Auth::user();

        // Obtener los campos booleanos del usuario
        $userTables = DB::table('users')->where('id', $user->id)->first([
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
                $availableTables[$table] = $booleanField;
            }
        }

        // Paginar los resultados
        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentPageItems = array_slice(array_keys($availableTables), ($currentPage - 1) * $perPage, $perPage);
        $paginatedTables = new LengthAwarePaginator($currentPageItems, count($availableTables), $perPage, $currentPage, [
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

    public function deleteTable($table)
    {
        \Schema::dropIfExists($table);
        return redirect()->route('menu.gestionar')->with('success', 'Tabla eliminada con éxito');
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
