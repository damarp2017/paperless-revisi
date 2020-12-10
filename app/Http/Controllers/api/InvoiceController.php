<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceResource;
use App\Order;
use App\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use PDF;

class InvoiceController extends Controller
{
    public function invoice(Order $order)
    {
        $details = new InvoiceResource($order);
        $filename = $details->id . ".pdf";
        $filepath = "invoice/" . $filename;
        $pdf = PDF::loadView('exports.invoice', compact(['details']));

        Storage::put($filepath, $pdf->output());

        return response()->json([
            'status' => true,
            'message' => "OK",
            'data' => [
                'url' => URL::to("uploads/".$filepath)
            ]
        ]);
    }
}
