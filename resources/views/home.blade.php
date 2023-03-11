@extends('layouts.app')

@section('content')
    
 
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow">
                    <div class="card-header">Product</div>

                    <div class="card-body">
                        <div class="row">
                            @foreach ($products as $product)
                                <div class="col-6">
                                    <div class="card">
                                        <img src="{{ asset('storage/image/product/' . $product->gambar) }}"
                                            class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $product->nama_product }}</h5>
                                            <p class="card-text">{!! $product->deskripsi !!}</p>
                                            <span>Rp.{{ number_format($product->harga, 2, ',', '.') }}</span>
                                            @if ($product->status == 'booking')
                                            <p>Booking</p>
                                            @else

                                            <a href="/booking/{{ $product->id_product }}/{{ $product->nama_product }}"
                                                class="btn btn-outline-primary badge link-dark">Booking
                                                Now</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        function dataExpire() {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Data Booking Telah Expire',
            })
        }
    </script>
    @if (session()->has('dataExpire'))
    <script>
        dataExpire()
    </script>
@endif
@endsection
