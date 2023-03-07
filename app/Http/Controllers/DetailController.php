<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DetailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('expire');
        
    }

    public function inputCheckIn(Request $req)
    {
        $value = $req->value;
        
    }

    public function index($id,$nama)
    {
        $cek = Product::find($id);
        return view('detailPesanan',[
            'product'=>$cek,
        ]);
    }
}
