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
        $details = new InvoiceResource($order);
        $pdf = PDF::loadView('exports.invoice', compact(['details']));
        $filename = $details->id . ".pdf";
        $filepath = "invoice/" . $filename;
        Storage::disk('s3')->put($filepath, $pdf->output());
        $url = Storage::disk('s3')->url($filepath,$filename);
        return response()->json([
            'status' => true,
            'message' => "OK",
            'data' => [
                'url' => $url
            ]
        ]);
    }
}
