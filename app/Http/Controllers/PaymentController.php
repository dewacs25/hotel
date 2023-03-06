<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($token)
    {
        $data = Transaction::where('token', $token)->get()->first();

        $customerDetails = [
            'name' => $data->name,
            'email' => $data->email,
            'product' => $data->product->nama_lapangan,
        ];

        $transactionDetails = [
            'order_id' => $data->token,
            'gross_amount' => $data->harga,
        ];

        $payload = [
            'transaction_details' => $transactionDetails,
            'customer_details' => $customerDetails,
        ];

        \Midtrans\Config::$serverKey =  config('services.midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
        \Midtrans\Config::$isSanitized = config('services.midtrans.isSanitized');
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = config('services.midtrans.is3ds');

        $snapToken = \Midtrans\Snap::getSnapToken($payload);
        return view('payment', [
            'data' => $data,
            'snapToken'=>$snapToken
        ]);
    }

    public function cancel($token)
    {
        Transaction::where('token', $token)->delete();
        if (session('notif') == 1) {
            session()->forget('notif');
        }else{
            $notif = session('notif') - 1;
            session()->put('notif',$notif);
        }
        return redirect()->back();
    }
}
