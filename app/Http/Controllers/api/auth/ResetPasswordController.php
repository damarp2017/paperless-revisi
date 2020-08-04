<?php

namespace App\Http\Controllers\api\auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected function sendResetResponse(Request $request, $response)
    {
        return response(['message' => trans($response)], 200);
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        return response(['message' => trans($response)], 422);
    }
}
