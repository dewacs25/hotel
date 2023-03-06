@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow">
                    <div class="card-header">Payment</div>

                    <div class="card-body">
                       <p>{{ $data->name }}</p>
                       <p>{{ $data->email }}</p>
                       <hr>
                       <p>Nama Kamar : {{ $data->product->nama_product }}</p>
                       <p>Check In : {{ $data->check_in }}</p>
                       <p>Check Out : {{ $data->check_out }}</p>
                       <h4>Harga : {{ $data->harga }}</h4>
                    </div>
                    <div class="card-footer">
                        <button id="pay-button" class="btn btn-success">Pay</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.clientKey') }}"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function(){
          // SnapToken acquired from previous step
          snap.pay('{{ $snapToken }}', {
            // Optional
            onSuccess: function(result){
            
            window.alert('Silahkan Cek Email Anda Untuk Melihat Lebih Detail Bukti Pembayaran')
            },
            // Optional
            onPending: function(result){
              location.reload();
            },
            // Optional
            onError: function(result){
                location.reload();
            }
          });
        };
      </script>
@endsection
