<?php

namespace App\Http\Controllers\Administrative;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Controller
{
    /**
     * Displays the administrative dashboard.
     *
     * Fetches the authenticated administrative user and passes the data to the dashboard view.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get the authenticated administrative user.
        $data = Auth::guard('administrative')->user();

        // Return the dashboard view with the user data.
        return view('administrative.dashboard', compact('data'));
    }
}
