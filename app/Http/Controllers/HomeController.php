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
        $this->middleware('expire');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */



    public function index()
    {
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

    public function ex(Request $req)
    {
        $expiredData = Transaction::where('expire', '<=', Carbon::now())->where('id_transaction',$req->id_transaction)->where('status','pending')->get();
        if (count($expiredData) < 1) {
            return response()->json([
                'statusExpire' => 200,
            ]);
        }else{
            return response()->json([
                'statusExpire' => 201,
            ]);
        }
    }
}
