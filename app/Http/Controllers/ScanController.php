<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class ScanController extends Controller
{
    public function index()
    {
        return view('admin.scan', [
            'page' => 'Scan QrCode'
        ]);
    }

    public function CheckIn()
    {
        return view('admin.scan.checkin');
    }
    public function CheckOut()
    {
        return view('admin.scan.checkout');
    }

    public function validasi(Request $req)
    {
        $qr = $req->qr_code;
        $cek = Booking::where('token', $qr)->get()->first();
        if ($cek) {
            if ($cek->status == 'pending') {
                $cek->update([
                    'status' => 'check-in'
                ]);
                $cek->save();
                return response()->json([
                    'status' => 200,
                    'message' => 'Check In Success'
                ]);
            } elseif ($cek->status == 'check-in') {
                return response()->json([
                    'status' => 201,
                    'message' => 'Sudah Melakukan Check In Sebelumnya'
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Anda Telah Check Out'
                ]);
            }
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Data "' . $qr . '" Tidak Ditemukan'
            ]);
        }
    }

    public function validasiCheckOut(Request $req)
    {
        $qr = $req->qr_code;
        $cek = Booking::where('token', $qr)->get()->first();
        if ($cek) {
            if ($cek->status == 'pending') {

                return response()->json([
                    'status' => 400,
                    'message' => 'User Belum Check In'
                ]);
            } elseif ($cek->status == 'check-in') {
                $cek->update([
                    'status' => 'check-out'
                ]);
                $cek->save();
                return response()->json([
                    'status' => 200,
                    'message' => 'Check Out Berhasil'
                ]);
            } else {
                return response()->json([
                    'status' => 201,
                    'message' => 'Anda Telah Check Out'
                ]);
            }
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Data "' . $qr . '" Tidak Ditemukan'
            ]);
        }
    }
}
