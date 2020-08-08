<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function (){
    return response()->json([
       'message' => 'welcome'
    ]);
});

// Auth
Route::prefix('v1')->group(function () {
    // auth owner
    Route::get('email/verify/{id}', 'api\auth\VerificationController@verify')->name('api.verification.verify');
    Route::get('email/resend', 'api\auth\VerificationController@resend')->name('api.verification.resend');
    Route::post('login', 'api\auth\LoginController@login');
    Route::post('register', 'api\auth\RegisterController@register');
    Route::post('password/email', 'api\auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'api\auth\ResetPasswordController@reset');

    // category
    Route::get('category', 'api\CategoryController@index');

    // owner
    Route::get('store', 'api\StoreController@index')->middleware(['auth:api', 'verified']);
    Route::post('store', 'api\StoreController@store')->middleware(['auth:api', 'verified']);



    Route::prefix('employee')->group(function () {
        // auth employee
        Route::post('login', 'api\auth_employee\LoginController@login');
        Route::get('store', 'api\employee\StoreController@index')->middleware(['auth:employee-api']);

        Route::get('product', 'api\employee\ProductController@index')->middleware(['auth:employee-api']);
        Route::post('product', 'api\employee\ProductController@store')->middleware(['auth:employee-api']);
    });
});
