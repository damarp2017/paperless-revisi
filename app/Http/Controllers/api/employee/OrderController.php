<?php

namespace App\Http\Controllers\api\employee;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Order;
use App\OrderDetail;
use App\Product;
use App\Store;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $_products = $request['products'];
        $employee = Auth::user();
        $store = Store::where('id', $employee->store->id)->first();

        $total_price = (array)null;
        $total_discount_by_percent = (array)null;


        $order = new Order();
        $order->id = IdGenerator::generate(['table' => 'orders', 'length' => 20, 'prefix' => 'ORD' . date('ym') . '-']);
        $order->store_id = $store->id;

        foreach ($_products as $_product) {
            $product = Product::where('id', $_product['id'])->first();
            $order_detail = new OrderDetail();
            $order_detail->id = IdGenerator::generate(['table' => 'order_details', 'length' => 20, 'prefix' => 'DTL' . date('ym') . '-']);
            $order_detail->order_id = $order->id;
            $order_detail->product_id = $product->id;
            $order_detail->name = $product->name;
            $order_detail->image = $product->image;
            $order_detail->price = $product->price;
            $order_detail->quantity = $_product['quantity'];
            $order_detail->discount_by_percent = $product->discount_by_percent ? $product->discount_by_percent : 0;
            $total_price[] = $order_detail->price * $order_detail->quantity;
            $total_discount_by_percent[] = $order_detail->price * $order_detail->discount_by_percent / 100 * $order_detail->quantity;
            $order_detail->save();
            if ($product->quantity != null) {
                if ($product->quantity >= $order_detail->quantity) {
                    $product->quantity -= $order_detail->quantity;
                    $product->update();
                } else {
                    $order_details = OrderDetail::where('order_id', $order->id)->get();
                    foreach ($order_details as $order_detail) {
                        $order_detail->forceDelete();
                    }
                    $order->forceDelete();
                    return response()->json([
                        'status' => false,
                        'message' => "Maximum order $order_detail->name is $product->quantity",
                        'data' => (object)[],
                    ], 400);
                }
            }
        }

        $order->total_price = array_sum($total_price);
        $order->total_discount = array_sum($total_discount_by_percent);
        $order->total_price_with_discount = $order->total_price - $order->total_discount;
        $order->save();

        return response()->json([
            'status' => true,
            'message' => "berhasil membuat orderan",
            'data' => new OrderResource($order),
        ], 201);
    }
}
