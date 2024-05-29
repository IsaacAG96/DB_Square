<?php

// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Mostrar el dashboard de administrador.
     */
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    /**
     * Mostrar la configuración de administrador.
     */
    public function settings()
    {
        return view('admin.settings');
    }
}
