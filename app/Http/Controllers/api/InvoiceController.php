<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceResource;
use App\Order;
use App\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PDF;

class InvoiceController extends Controller
{
    public function invoice(Order $order)
    {
//        $details = new InvoiceResource($order);
//        $pdf = PDF::loadView('exports.invoice', compact(['details']));
//        $filename = $details->id . ".pdf";
//        $filepath = "invoice/" . $filename;
//        Storage::disk()->put($filepath, $pdf->output());
//        $invoice_path = Storage::disk()->url($filepath,$filename);
//
//        dd(public_path($invoice_path));
//
//        $response = cloudinary()->upload($pdf->output(), array(
//            "folder" => "invoices",
//            "resource_type" => "auto",
//            "public_id" => $details->id.".pdf"))->getSecurePath();
//
//        return response()->json([
//            'status' => true,
//            'message' => "OK",
//            'data' => [
//                'url' => $response
//            ]
//        ]);
    }
}
