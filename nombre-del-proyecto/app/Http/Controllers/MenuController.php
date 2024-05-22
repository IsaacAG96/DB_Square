<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        return view('menu.index');
    }

    public function crear()
    {
        return view('menu.crear');
    }

    public function gestionar()
    {
        return view('menu.gestionar');
    }

    public function importar()
    {
        return view('menu.importar');
    }
}
