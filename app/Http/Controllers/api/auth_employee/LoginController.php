<?php

namespace App\Http\Controllers\api\auth_employee;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthEmployeeResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        if (Auth::guard('employee')->attempt(['username' => request('username'), 'password' => request('password')])) {
            $employee = Auth::guard('employee')->user();
            $message = "Login Successfull";
            return response()->json([
                'status' => true,
                'message' => $message,
                'data' => new AuthEmployeeResource($employee)
            ], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Your credentials does not match', 'data' => (object)[]], 401);
        }
    }
}
