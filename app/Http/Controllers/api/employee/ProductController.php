<?php

namespace App\Http\Controllers\api\employee;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Product;
use App\Store;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $employee = Auth::user();
        $products = Product::with(['store.employee' => function ($query) use ($employee) {
            $query->where('id', $employee);
        }])->get();

        $count = count($products);

        if ($count <= 0) {
            return response()->json([
                'status' => true,
                'message' => 'belum ada produk',
                'data' => []
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'berhasil menampilkan semua produk',
            'data' => ProductResource::collection($products)
        ]);
    }

    public function store(Request $request)
    {
        $employee = Auth::user();
        $store = Store::with(['employee' => function ($query) use ($employee) {
            $query->where('id', $employee);
        }])->first();

//        dd($store);

        $rules = [
            'category_id' => 'required',
            'name' => 'required|max:100',
            'image' => 'required|mimes:jpg,png,jpeg|max:3072',
            'description' => '',
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

        $product = new Product();
        $product->id = IdGenerator::generate(['table' => 'products', 'length' => 12, 'prefix' => 'PRO-']);
        $product->category_id = $request->category_id;
        $product->store_id = $store->id;
        $product->name = $request->name;

        if ($request->code != null) {
            $product->code = $request->code;
        }
        if ($request->image != null) {
            $file = $request->file('image');
            $file_name = date('ymdHis') . "-" . $file->getClientOriginalName();
            $file_path = 'product/' . $file_name;
            Storage::disk('s3')->put($file_path, file_get_contents($file));
            $product->image = Storage::disk('s3')->url($file_path, $file_name);
        }
        $product->description = $request->description;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->status = $request->status;
        $product->save();

        return response()->json([
            'status' => true,
            'message' => "$product->name has been created",
            'data' => new ProductResource($product),
        ], 201);
    }
}
