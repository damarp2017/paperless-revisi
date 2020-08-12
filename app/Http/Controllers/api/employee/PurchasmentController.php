<?php

namespace App\Http\Controllers\api\employee;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Product;
use App\Purchasment;
use App\Store;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PurchasmentController extends Controller
{
    public function index()
    {
        $employee = Auth::user();
        $store = Store::where('id', $employee->store->id)->first();

        return response()->json([
            'status' => true,
            'message' => "berhasil mengambil data pembelian",
            'data' => $store,
        ], 200);
    }

    public function new(Request $request)
    {
        $employee = Auth::user();
        $store = Store::where('id', $employee->store->id)->first();

//        dd($request->all());

        $rules = [
            'category_id' => 'required',
            'name' => 'required|max:100',
            'description' => '',
            'image' => 'required|mimes:jpg,png,jpeg|max:3072',
            'price' => ['required', 'numeric', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
            'quantity' => '',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 400);
        }

        $purchasement = new Purchasment();
        $purchasement->id = IdGenerator::generate(['table' => 'purchasments', 'length' => 20, 'prefix' => 'PCM' . date('ym') . '-']);
        $purchasement->store_id = $store->id;
        $purchasement->name = $request->name;
        $purchasement->price = $request->price;
        $purchasement->quantity = $request->quantity;
        $purchasement->date = $request->date;
        $purchasement->save();

        $product = new Product();
        $product->id = IdGenerator::generate(['table' => 'products', 'length' => 12, 'prefix' => 'PRO-']);
        $product->category_id = $request->category_id;
        $product->store_id = $store->id;
        $product->name = $request->name;

        if ($request->image != null) {
            $file = $request->file('image');
            $file_name = date('ymdHis') . "-" . $file->getClientOriginalName();
            $file_path = 'product/' . $file_name;
            Storage::disk('s3')->put($file_path, file_get_contents($file));
            $product->image = Storage::disk('s3')->url($file_path, $file_name);
        }

        $product->description = $request->description;
        $product->price = $request->sell_price;
        $product->quantity = $request->quantity;
        $product->status = 1;
        $product->save();

        return response()->json([
            'status' => true,
            'message' => "berhasil menambahkan pembelian",
            'data' => $purchasement,
        ], 201);
    }

    public function restock(Request $request)
    {
        $employee = Auth::user();
        $store = Store::where('id', $employee->store->id)->first();
        $product = Product::where('id', $request->product_id)->first();

//        dd($product);

        $rules = [
            'product_id' => 'required',
            'price' => ['required', 'numeric', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
            'quantity' => 'required',
            'date' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 400);
        }

        $purchasement = new Purchasment();
        $purchasement->id = IdGenerator::generate(['table' => 'purchasments', 'length' => 20, 'prefix' => 'PCM' . date('ym') . '-']);
        $purchasement->store_id = $store->id;
        $purchasement->name = $product->name;
        $purchasement->price = $request->price;
        $purchasement->quantity = $request->quantity;
        $purchasement->date = $request->date;
        $purchasement->save();

        $product->quantity += $request->quantity;
        $product->update();

        return response()->json([
            'status' => true,
            'message' => "berhasil melakukan restock pada produk",
            'data' => $purchasement,
        ], 200);
    }
}
