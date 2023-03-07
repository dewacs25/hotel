<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class TransaceionController extends Controller
{
    public $email;
    public $name;

    public function __construct()
    {
        $this->middleware('auth');
       
    }

    public function Simpan(Request $req)
    {
        $req->validate([
            'checkin' => 'required',
            'checkout' => 'required',
            'token' => 'required',
        ]);

        $this->email = Auth::guard('web')->user()->email;
        $this->name = Auth::guard('web')->user()->name;

        $now = time();
        $plus_ten_minutes = strtotime('+2 minutes', $now); 
        $expire = date('y-m-d H:i:s', $plus_ten_minutes); 

        Transaction::create([
            'id_product' => $req->id_product,
            'token' => $req->token,
            'check_in'=>$req->checkin,
            'check_out'=>$req->checkout,
            'email'=>$this->email,
            'name'=>$this->name,
            'harga'=>$req->price,
            'expire'=>$expire
        ]);

        $jumlahNotif = session('notif') + 1;
        session()->put('notif', $jumlahNotif);

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil ditambahkan.',
        ]);
    }
}
