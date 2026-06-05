<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CustomerModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ResetPassword extends Controller
{
    /**
     * Display the password reset view for the given token.
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('customer.password')->with(['token' => $token, 'email' => $request->email]);
    }

    /**
     * Reset the given user's password.
     */
    public function reset(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages(), $this->attributes());

        $user = CustomerModel::where('email', $request->email)->first();

        if ($user && $user->status === 'Cancelado') {
            throw ValidationException::withMessages([
                'email' => [trans('auth.cancelled')],
            ]);
        }

        $response = Password::broker('customers')->reset(
            $this->credentials($request),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->setRememberToken(Str::random(60));
                $user->save();
            }
        );

        if ($response === Password::PASSWORD_RESET) {
            return $this->sendResetResponse($request, $response);
        }

        return $this->sendResetFailedResponse($request, $response);
    }

    /**
     * Get the password reset validation rules.
     */
    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:6|regex:/^(?=.*[0-9])(?=.*[^\w\s]).{6,}$/',
            'repassword' => 'required|same:password',
        ];
    }

    /**
     * Get the password reset validation error messages.
     */
    protected function validationErrorMessages()
    {
        return [
            'password.regex' => 'La contraseña debe tener al menos 6 caracteres, incluir un número y un carácter especial.',
        ];
    }

    /**
     * Get the password reset validation attributes.
     */
    protected function attributes()
    {
        return [
            'email' => 'correo electrónico',
            'password' => 'contraseña',
            'repassword' => 'repetir contraseña',
        ];
    }

    /**
     * Get the password reset credentials from the request.
     */
    protected function credentials(Request $request)
    {
        return $request->only('email', 'password', 'token');
    }

    /**
     * Get the response for a successful password reset.
     */
    protected function sendResetResponse(Request $request, $response)
    {
        if ($request->ajax()) {
            return new JsonResponse(['message' => trans($response)], 200);
        }

        return redirect('cliente/acceso')->with('status', trans($response));
    }

    /**
     * Get the response for a failed password reset.
     */
    protected function sendResetFailedResponse(Request $request, $response)
    {
        if ($request->ajax()) {
            throw ValidationException::withMessages([
                'email' => [trans($response)],
            ]);
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => trans($response)]);
    }
}