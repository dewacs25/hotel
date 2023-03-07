<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('expire');
        

    }

    public function index($token)
    {
        $data = Transaction::where('token', $token)->get()->first();
        if ($data == null) {
            return redirect('/')->with(session()->flash('dataExpire','Data Pesanan Booking Telah Expire'));
        }

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

        
        // dd($diffInSeconds);
        return view('payment', [
            'data' => $data,
            'snapToken'=>$snapToken,
            'expire'=>$data->expire,
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
