<?php

namespace App\Http\Controllers\api;

use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Resources\StoreResource;
use App\Store;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::where('owner_id', auth()->user()->id)->get();
        $count = count($stores);
        if ($count > 0) {
            return response()->json([
                'status' => true,
                'message' => "mengambil data semua toko",
                'count' => $count,
                'data' => StoreResource::collection($stores),
            ], 200);
        } else {
            return response()->json([
                'status' => true,
                'message' => "maaf anda belum memiliki toko",
                'data' => []
            ], 200);
        }
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:50',
            'phone' => 'required|max:15',
            'address' => 'required',
            'store_logo' => 'required|mimes:jpg,png,jpeg|max:3072',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 400);
        }

        $store = new Store();
        $store->id = IdGenerator::generate(['table' => 'stores', 'length' => 10, 'prefix' =>'STR-']);
        $store->code = Str::random(6);
        $store->name = $request->name;
        $store->phone = $request->phone;
        $store->address = $request->address;
        $store->owner_id = auth()->user()->id;

        if ($request->store_logo != null) {
//            $file = $request->file('store_logo');
//            $file_name = date('ymdHis') . "-" . $file->getClientOriginalName();
//            $file_path = 'store-logo/' . $file_name;
//            Storage::disk('s3')->put($file_path, file_get_contents($file));
//            $store->store_logo = Storage::disk('s3')->url($file_path, $file_name);
            $response = cloudinary()->upload($request->file('store_logo')->getRealPath(), array("folder" => "stores", "overwrite" => TRUE, "resource_type" => "image"))->getSecurePath();
            $store->store_logo = $response;
        }

        $store->save();

        $staff = new Employee();
        $staff->id = IdGenerator::generate(['table' => 'employees', 'length' => 10, 'prefix' =>'EMP-']);
        $staff->store_id = $store->id;
        $staff->api_token = Str::random(80);
        $staff->username = "staff@$store->code";
        $staff->password = Hash::make("12345678");
        $staff->role = Employee::$ROLESTAFF;
        $staff->save();

        $cashier = new Employee();
        $cashier->id = IdGenerator::generate(['table' => 'employees', 'length' => 10, 'prefix' =>'EMP-']);
        $cashier->store_id = $store->id;
        $cashier->api_token = Str::random(80);
        $cashier->username = "cashier@$store->code";
        $cashier->password = Hash::make("12345678");
        $cashier->role = Employee::$ROLECASHIER;
        $cashier->save();

        return response()->json([
            'status' => true,
            'message' => "berhasil membuat toko",
            'data' => new StoreResource($store)
        ], 201);
    }
}
