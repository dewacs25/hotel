<?php

namespace App\Http\Controllers;

use App\Mail\QrMasuk;
use App\Models\Booking;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use LaravelQRCode\Facades\QRCode;


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
        if ($data == null || $data->status == 'success') {
            return redirect('/')->with(session()->flash('dataExpire', 'Data Pesanan Booking Telah Expire'));
        }

        $expiredData = Transaction::where('expire', '<=', Carbon::now())->where('id_transaction', $data->id_transaction)->where('status', 'pending')->get();
        if (!count($expiredData) < 1) {
            return redirect('/')->with(session()->flash('dataExpire', 'Data Pesanan Booking Telah Expire'));
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
            'snapToken' => $snapToken,
            'expire' => $data->expire,
        ]);
    }

    public function cancel($token)
    {
        Transaction::where('token', $token)->delete();
        if (session('notif') == 1) {
            session()->forget('notif');
        } else {
            $notif = session('notif') - 1;
            session()->put('notif', $notif);
        }
        return redirect()->back();
    }

    public function PaymentSuccess(Request $req)
    {
        $data = Transaction::where('token', $req->t)->get()->first();

        $data->update([
            'status' => 'success'
        ]);;

        $data->save();

        $token = md5($data->token) . '-' . date('ymdhis') . uniqid();
        $namaQr = $data->token . uniqid() . date('ymdhis') . '.' . 'png';
        $qrCodePath = storage_path('app/imageQr/');

        QrCode::text($token)->setOutfile($qrCodePath . $namaQr)->png();

        if (file_exists(storage_path('app/imageQr/' . $namaQr))) {
            $booking = Booking::create([
                'id_product' => $data->id_product,
                'id' => auth()->guard('web')->user()->id,
                'check_in' => $data->check_in,
                'check_out' => $data->check_out,
                'token' => $token,
                'qr' => $namaQr,
                'status' => 'pending'
            ]);

            $dataMail = [
                'qr' => $namaQr
            ];

            Mail::to($data->email)->send(new QrMasuk($dataMail));

        }
    }
}
