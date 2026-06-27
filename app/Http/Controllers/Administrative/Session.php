<?php

namespace App\Http\Controllers\Administrative;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class Session extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'administrativo/tablero';

    /**
     * Show the application's login form.
     */
    public function showLoginForm()
    {
        return view('administrative.session');
    }

    /**
     * Login the administrative user.
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        $credentials = $request->only('email', 'password');

        $user = Auth::guard('administrative')->getProvider()->retrieveByCredentials($credentials);

        if ($user && $user->status === 'Cancelado') {
            throw ValidationException::withMessages(['email' => [trans('auth.cancelled')]]);
        }

        if (Auth::guard('administrative')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            return response(['redirect' => route($this->redirectTo)], 200);
        }

        throw ValidationException::withMessages(['email' => [trans('auth.failed')]]);
    }

    /**
     * Logout the administrative user.
     */
    public function logout(Request $request)
    {
        Auth::guard('administrative')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('administrativo/acceso');
    }

    /**
     * Validate the administrative login request.
     */
    protected function validateLogin(Request $request)
    {
        $request->validate(['email' => 'required|email', 'password' => 'required'], [], ['email' => 'correo electrónico', 'password' => 'contraseña']);
    }
}
