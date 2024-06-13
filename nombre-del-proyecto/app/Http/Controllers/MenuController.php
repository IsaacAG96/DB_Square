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
            'share','imported_tables' // Excluir la tabla 'compartir'
        ];
        $excludedFields = ['id', 'created_at', 'updated_at', 'owner_id'];

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
            'contacts' => $user->contactos,
            'disc_collection' => $user->discos,
            'travel_collection' => $user->viajes,
            'shopping_list' => $user->compra,
            'program_list' => $user->programas,
            'accounts_list' => $user->cuentas,
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
    
        // Obtener tablas personalizadas
        $customTables = DB::connection()->getDoctrineSchemaManager()->listTableNames();
        $userCustomTables = [];
        foreach ($customTables as $customTable) {
            if (strpos($customTable, '_' . $user->id) !== false) {
                $userCustomTables[] = $customTable;
            }
        }
    
        return view('menu.gestionar', [
            'tables' => $paginatedTables,
            'customTables' => $userCustomTables
        ]);
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
        return redirect()->route('menu.gestionar')->with('success', 'Table deleted successfully');
    }

    public function importTable(Request $request)
    {
        $user = Auth::user();
        $tableName = $request->input('table');

        // Cambia el campo correspondiente a true
        switch ($tableName) {
            case 'contacts':
                $user->contactos = true;
                break;
            case 'disc_collection':
                $user->discos = true;
                break;
            case 'travel_collection':
                $user->viajes = true;
                break;
            case 'shopping_list':
                $user->compra = true;
                break;
            case 'program_list':
                $user->programas = true;
                break;
            case 'accounts_list':
                $user->cuentas = true;
                break;
            default:
                return redirect()->route('menu.importar')->with('error', 'Invalid table');
        }

        $user->save();

        return redirect()->route('menu.importar')->with('success', 'Table imported successfully');
    }

    public function crear()
    {
        // Lógica para mostrar la vista de crear tabla
        return view('menu.crear');
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'numCampos' => 'required|integer|min:1|max:7',
        ]);

        $user = Auth::user();
        $nombre = $request->input('nombre') . '_' . $user->id;
        $numCampos = $request->input('numCampos');

        // Verificar si la tabla ya existe
        if (Schema::hasTable($nombre)) {
            return redirect()->route('menu.crear')->with('error', 'Table already exists and was not created');
        }

        // Crear la tabla en la base de datos
        Schema::create($nombre, function ($table) use ($request, $numCampos, $user) {
            $table->id();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->integer('owner_id');

            for ($i = 0; $i < $numCampos; $i++) {
                $fieldName = $request->input("field_name_$i");
                $fieldType = $request->input("field_type_$i");
                $isNullable = $request->has("field_nullable_$i");

                $column = $table->$fieldType($fieldName);
                if ($isNullable) {
                    $column->nullable();
                }
            }
        });

        // Redirigir con un mensaje de éxito
        return redirect()->route('menu.crear')->with('success', 'Table created successfully');
    }
    public function deleteCustomTable($table)
    {
        // Verificar si la tabla existe antes de eliminarla
        if (Schema::hasTable($table)) {
            Schema::dropIfExists($table);
            return redirect()->route('menu.gestionar')->with('success', 'Table deleted successfully');
        }

        return redirect()->route('menu.gestionar')->with('error', 'Table does not exist');
    }
}
