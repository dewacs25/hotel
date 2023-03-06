<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
