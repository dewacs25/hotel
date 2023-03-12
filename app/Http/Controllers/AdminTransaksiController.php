<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminTransaksiController extends Controller
{
    
    public function index()
    {
        $transaksis = Transaction::orderBy('created_at','desc')->paginate(10);
        return view('admin.transaksi',[
            'page'=>'Transaksi',
            'transaksis'=>$transaksis
        ]);
    }
}
