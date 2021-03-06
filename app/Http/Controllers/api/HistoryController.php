<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HistoryOwnerResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\PurchasementResource;
use App\Order;
use App\Purchasment;
use App\Store;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function all()
    {
        $owner = auth()->user();
        $stores = Store::where('owner_id', $owner->id)->get();
        $list_store = $stores->map(function ($store) {
            return collect($store->toArray())->only('id')->all();
        });

        $orders = Order::all();
        $purchasements = Purchasment::all();
        $orders = $orders->intersect(Order::whereIn('store_id', $list_store)->get());
        $purchasements = $purchasements->intersect(Purchasment::whereIn('store_id', $list_store)->get());
        return response()->json([
            'status' => true,
            'message' => 'riwayat penjualan dan pembelian ditemukan',
            'data' => [
                'orders' => OrderResource::collection($orders),
                'purchasements' => PurchasementResource::collection($purchasements)
            ]
        ]);
    }
}
