<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $balances = Transaction::where('status','success')->sum('harga');

        return view('admin.dashboard',[
            'page'=>'Dashboard',
            'balance'=>$balances
        ]);
    }
}
