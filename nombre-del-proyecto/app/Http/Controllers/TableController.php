<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use App\Models\User;


class TableController extends Controller
{
    public function view($table)
    {
        // Verificar si la tabla existe
        if (!\Schema::hasTable($table)) {
            return redirect()->route('menu.gestionar')->with('error', 'La tabla no existe.');
        }

        // Obtener datos de la tabla
        $data = DB::table($table)->get();

        return view('table.view', [
            'table' => $table,
            'data' => $data
        ]);
    }

    public function edit($table)
    {
        // Lógica para editar la tabla
        return view('table.edit', compact('table'));
    }

    public function delete($table)
    {
        \Schema::dropIfExists($table);
        return redirect()->route('menu.gestionar')->with('success', 'Tabla eliminada con éxito');
    }

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

    public function deleteSharedAccess($id)
    {
        DB::table('compartir')->where('id', $id)->delete();

        return back()->with('success', 'Acceso compartido eliminado correctamente.');
    }

}
