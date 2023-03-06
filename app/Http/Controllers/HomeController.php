<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        // $now = time();
        // $plus_ten_minutes = strtotime('+1 minutes', $now); 
        // $e = date('y-m-d H:i:s', $plus_ten_minutes); 
        // dd($e); 


        $products = Product::paginate(6);

        // session()->forget('notif');
        return view('home', [
            'products' => $products
        ]);
    }

    public function transaksi()
    {
        $transactions = Transaction::where('email', Auth::guard('web')->user()->email)->get();

        return view('transaksi', [
            'transactions' => $transactions
        ]);
    }
}
