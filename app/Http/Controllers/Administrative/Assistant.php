<?php

namespace App\Http\Controllers\Administrative;

use App\Http\Controllers\Controller;

class Assistant extends Controller
{
    /**
     * Redirects to the product management page.
     *
     * This method redirects the user to the 'administrativo/auxiliar/producto' route for managing products.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        // Redirect the user to the product management page.
        return redirect('administrativo/auxiliar/producto');
    }
}
