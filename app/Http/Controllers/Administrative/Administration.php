<?php

namespace App\Http\Controllers\Administrative;

use App\Http\Controllers\Controller;

class Administration extends Controller
{
    /**
     * Redirects to the administrative dashboard.
     *
     * This method redirects the user to the 'administrativo/administracion/administrativo' route.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        // Redirect the user to the specified route.
        return redirect('administrativo/administracion/administrativo');
    }
}