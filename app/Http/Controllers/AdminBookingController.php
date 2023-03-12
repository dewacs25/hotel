<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::orderBy('created_at','desc')->paginate(10);

        return view('admin.booking',[
            'page'=>'Booking',
            'bookings'=>$bookings
        ]);
    }
}
