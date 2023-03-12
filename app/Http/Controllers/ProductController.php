<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(6);
        return view('admin/product', [
            'page' => 'product',
            'products' => $products
        ]);
    }

    public function Tambah(Request $req)
    {

        $req->validate([
            'nama_product' => 'required|min:3',
            'deskripsi' => 'required',
            'harga' => 'required',
            'gambar' => 'required',
        ]);

        $namaGambar = 'Product-' . date('ymd') . '-' . uniqid() . '.' . $req->gambar->getClientOriginalExtension();

        $tambah = Product::create([
            'nama_product' => $req->nama_product,
            'deskripsi' => $req->deskripsi,
            'harga' => $req->harga,
            'gambar' => $namaGambar,
        ]);

        if ($tambah) {
            $req->gambar->storeAs('public/image/product/', $namaGambar, 'local');
            return redirect()->back()->with(session()->flash('success', 'Data Berhasil Di Tambahkan'));
        }
    }

    public function delete($id)
    {
        $cek = Product::where('id_product', $id)->get()->first();
        if ($cek) {
            if (file_exists(public_path('storage/image/product/' . $cek->gambar))) {
                unlink(public_path('storage/image/product/' . $cek->gambar));
            }
            $cek->delete();
            $booking = Booking::where('id_product', $cek->id_product)->get();
            $transaction = Transaction::where('id_product', $cek->id_product)->get();

            foreach ($booking as $e) {
                $e->delete();
            }
            foreach ($transaction as $f) {
                $f->delete();
            }
        }
        return redirect()->back();
    }
}
