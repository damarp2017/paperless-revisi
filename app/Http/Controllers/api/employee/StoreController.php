<?php

namespace App\Http\Controllers\api\employee;

use App\Http\Controllers\Controller;
use App\Http\Resources\StoreResource;
use App\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        $store = Store::where('id', auth()->user()->store->id)->first();

        return response()->json([
            'status' => true,
            'message' => "berhasil mengambil data toko tempat bekerja",
            'data' => new StoreResource($store)
        ]);
    }
}
