<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class TableController extends Controller
{
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

    public function view($table)
    {
        $userId = Auth::id();

        // Verificar si la tabla existe
        if (!Schema::hasTable($table)) {
            return redirect()->route('table.gestionar')->with('error', 'La tabla no existe.');
        }

        // Obtener datos de la tabla donde id_propietario es el usuario actual o está compartido con el usuario actual
        $data = DB::table($table)
            ->where('id_propietario', $userId)
            ->orWhere(function ($query) use ($userId, $table) {
                $query->whereIn('id_propietario', function ($subQuery) use ($userId, $table) {
                    $subQuery->select('propietario')
                        ->from('compartir')
                        ->where('tipo_tabla', $table)
                        ->where('usuario_compartido', $userId)
                        ->where('visualizar', true);
                });
            })
            ->get();

        // Transformar datos
        $transformedData = $data->map(function ($item) {
            $item = (array) $item;
            unset($item['id']);

            $owner = DB::table('users')->where('id', $item['id_propietario'])->first();
            $item['id_propietario'] = $owner ? $owner->name . '#' . $owner->id : 'Unknown';

            return (object) $item;
        });

        return view('table.view', [
            'table' => $table,
            'data' => $transformedData
        ]);
    }
}
