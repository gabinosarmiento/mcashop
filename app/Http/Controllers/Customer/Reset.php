<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CustomerModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class Reset extends Controller
{
    /**
     * Display the form to request a password reset link.
     */
    public function showLinkRequestForm()
    {
        return view('customer.email');
    }

    /**
     * Send a reset link to the given customer.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email'], [], ['email' => 'correo electrónico']);

        $user = CustomerModel::where('email', $request->email)->first();

        if ($user && $user->status === 'Cancelado') {
            throw ValidationException::withMessages([
                'email' => [trans('auth.cancelled')],
            ]);
        }

        $response = Password::broker('customers')->sendResetLink($request->only('email'));

        if ($response === Password::RESET_LINK_SENT) {
            return $this->sendResetLinkResponse($request, $response);
        }

        return $this->sendResetLinkFailedResponse($request, $response);
    }

    /**
     * Get the response for a successful password reset link.
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        if ($request->ajax()) {
            return new JsonResponse(['message' => trans($response)], 200);
        }

        return back()->with('status', trans($response));
    }

    /**
     * Get the response for a failed password reset link.
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        if ($request->ajax()) {
            throw ValidationException::withMessages(['email' => [trans($response)]]);
        }

        return back()->withInput($request->only('email'))->withErrors(['email' => trans($response)]);
    }
}