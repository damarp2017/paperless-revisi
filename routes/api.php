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

Route::get('/', function () {
    return response()->json([
        'message' => 'welcome'
    ]);
});

// Auth
Route::prefix('v1')->group(function () {
    // auth owner
    Route::get('email/verify/{id}', [
        \App\Http\Controllers\api\auth\VerificationController::class,
        'verify'
    ])->name('api.verification.verify');

    Route::get('email/resend', [
        \App\Http\Controllers\api\auth\VerificationController::class,
        'resend'
    ])->name('api.verification.resend');

    Route::post('login', [
        \App\Http\Controllers\api\auth\LoginController::class,
        'login'
    ]);

    Route::post('register', [
        \App\Http\Controllers\api\auth\RegisterController::class,
        'register'
    ]);

    Route::post('password/email', [
        \App\Http\Controllers\api\auth\ForgotPasswordController::class,
        'sendResetLinkEmail'
    ]);

    Route::post('password/reset', [
        \App\Http\Controllers\api\auth\ResetPasswordController::class,
        'reset'
    ]);

    // category
    Route::get('category', 'api\CategoryController@index');

    // owner
    Route::get('store', [
        \App\Http\Controllers\api\StoreController::class,
        'index'
    ])->middleware(['auth:api', 'verified']);

    Route::post('store', [
        \App\Http\Controllers\api\StoreController::class,
        'store'
    ])->middleware(['auth:api', 'verified']);

    Route::prefix('employee')->group(function () {
        // auth employee
        Route::post('login', [
            \App\Http\Controllers\api\auth_employee\LoginController::class,
            'login'
        ]);

        Route::get('store', [
            \App\Http\Controllers\api\employee\StoreController::class,
            'index'
        ])->middleware(['auth:employee-api']);

        Route::get('product', [
            \App\Http\Controllers\api\employee\ProductController::class,
            'index'
        ])->middleware(['auth:employee-api']);

        Route::post('product', [
            \App\Http\Controllers\api\employee\ProductController::class,
            'store'
        ])->middleware(['auth:employee-api']);

        Route::get('product/{product}', [
            \App\Http\Controllers\api\employee\ProductController::class,
            'show'
        ])->middleware(['auth:employee-api']);

        Route::put('product/{product}', [
            \App\Http\Controllers\api\employee\ProductController::class,
            'update'
        ])->middleware(['auth:employee-api']);

        Route::post('product/{product}/image', [
            \App\Http\Controllers\api\employee\ProductController::class,
            'updateImage'
        ])->middleware(['auth:employee-api']);

        Route::delete('product/{product}', [
            \App\Http\Controllers\api\employee\ProductController::class,
            'destroy'
        ])->middleware(['auth:employee-api']);
    });

    Route::post('order', [
        \App\Http\Controllers\api\employee\OrderController::class,
        'store'
    ])->middleware(['auth:employee-api']);

    Route::get('order/history', [
        \App\Http\Controllers\api\employee\OrderController::class,
        'history'
    ])->middleware(['auth:employee-api']);

    Route::get('history/all', [
        \App\Http\Controllers\api\HistoryController::class,
        'all'
    ])->middleware(['auth:api', 'verified']);

    Route::get('purchasement', [
        \App\Http\Controllers\api\employee\PurchasmentController::class,
        'index'
    ])->middleware(['auth:employee-api', 'verified']);

    Route::post('purchasement/new', [
        \App\Http\Controllers\api\employee\PurchasmentController::class,
        'new'
    ])->middleware(['auth:employee-api', 'verified']);

    Route::post('purchasement/restock', [
        \App\Http\Controllers\api\employee\PurchasmentController::class,
        'restock'
    ])->middleware(['auth:employee-api', 'verified']);

    Route::get('invoice/{order}', [
        \App\Http\Controllers\api\InvoiceController::class,
        'invoice'
    ])->name('invoice');
});
