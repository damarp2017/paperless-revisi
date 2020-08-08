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
        $products = Product::where('store_id', $employee->store->id)->get();

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

    public function show(Product $product)
    {
        $employee = Auth::user();
        $product = Product::where('id', $product->id)->where('store_id', $employee->store->id)->first();

        if ($product) {
            return response()->json([
                'status' => true,
                'message' => 'berhasil menampilkan produk',
                'data' => new ProductResource($product)
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'not found',
            'data' => (object)[],
        ], 404);
    }

    public function store(Request $request)
    {
        $employee = Auth::user();

        $store = Store::where('id', $employee->store->id)->first();

        $rules = [
            'category_id' => 'required',
            'name' => 'required|max:100',
            'description' => '',
            'price' => ['required', 'numeric', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
            'status' => 'required',
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
            'message' => "berhasil menambahkan produk",
            'data' => new ProductResource($product),
        ], 201);
    }

    public function update(Request $request, Product $product)
    {
        $employee = Auth::user();
        $product = Product::where('id', $product->id)->where('store_id', $employee->store->id)->first();

        if ($product) {
            $rules = [
                'category_id' => 'required',
                'name' => 'required|max:100',
                'image' => 'mimes:jpg,png,jpeg|max:3072',
                'description' => '',
                'price' => ['required', 'numeric', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
                'status' => 'required',
                'quantity' => '',
                'discount_by_percent' => ''
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()
                ], 400);
            }

            $product->category_id = $request->category_id;
            $product->name = $request->name;

            if ($request->code != null) {
                $product->code = $request->code;
            }

            $product->description = $request->description;
            $product->price = $request->price;
            $product->quantity = $request->quantity;
            $product->status = $request->status;
            $product->discount_by_percent = $request->discount_by_percent;

            $product->update();
            return response()->json([
                'status' => true,
                'message' => 'berhasil mengubah produk',
                'data' => new ProductResource($product)
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'not found',
            'data' => (object)[],
        ], 404);
    }

    public function updateImage(Request $request, Product $product)
    {
        $employee = Auth::user();
        $product = Product::where('id', $product->id)->where('store_id', $employee->store->id)->first();
        if ($product) {
            $rules = [
                'image' => 'mimes:jpg,png,jpeg|max:3072',
            ];
            if ($request->image != null) {
                $file = $request->file('image');
                $file_name = date('ymdHis') . "-" . $file->getClientOriginalName();
                $file_path = 'product/' . $file_name;
                Storage::disk('s3')->put($file_path, file_get_contents($file));
                $product->image = Storage::disk('s3')->url($file_path, $file_name);
            }
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()
                ], 400);
            }
            $product->update();
            return response()->json([
                'status' => true,
                'message' => "berhasil mengubah gambar produk",
                'data' => new ProductResource($product),
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'not found',
                'data' => (object)[],
            ], 404);
        }
    }

    public function destroy(Product $product)
    {
        $employee = Auth::user();
        $product = Product::where('id', $product->id)->where('store_id', $employee->store->id)->first();
        if ($product) {
            $product->delete();
            return response()->json([
                'status' => true,
                'message' => "berhasil menghapus produk",
                'data' => new ProductResource($product),
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'not found',
                'data' => (object)[],
            ], 404);
        }
    }
}
