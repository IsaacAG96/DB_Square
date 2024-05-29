<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        // Lógica para compartir la tabla
        // Aquí puedes implementar la funcionalidad para compartir la tabla, como mostrar un formulario para ingresar el usuario con el que se compartirá
        return view('table.share', compact('table'));
    }
}
