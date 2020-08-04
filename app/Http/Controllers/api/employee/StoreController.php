<?php

namespace App\Http\Controllers\api\employee;

use App\Http\Controllers\Controller;
use App\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        $store = Store::with(['employee' => function($query) {
            $query->where('id', auth()->user()->id);
        }])->first();

        return response()->json([
            'status' => true,
            'message' => "berhasil mengambil data toko tempat bekerja",
            'data' => $store
        ]);
    }
}
