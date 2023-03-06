@extends('layouts/app_admin');
@section('content_admin')
    @if ($errors->any())
        <script>
            $(document).ready(function() {
                var errors = "";
                @foreach ($errors->all() as $error)
                    errors += "{{ $error }}" + "\n\n";
                @endforeach
                errorValidate(errors);
            });
        </script>
    @endif
    @if (session()->has('success'))
        <script>
            Success("{{ session('success') }}");
        </script>
    @endif


    <div class="container mt-3">

        <div id="tambah-data-container" class="mb-5"></div>

        <div class="row">
            @foreach ($products as $product)
                <div class="col-md-4">
                    <div class="card">

                        <img class="card-img-top"
                            src="{{ asset('storage/image/product/'.$product->gambar) }}"
                            alt="">
                        <div class="card-body">
                            <h3>{{ $product->nama_product }}</h3>
                            <p>{!! $product->deskripsi !!}</p>
                            <p>Rp.{{ number_format($product->harga, 2, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
            {{ $products->links('pagination::bootstrap-4') }}
            
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#btn-tambah-product').click(function() {
                $.ajax({
                    url: '/admin/product/tambah',
                    type: 'GET',
                    success: function(response) {
                        $('#tambah-data-container').html(response);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
        $(document).on('click', '#btn-tutup-form', function() {
            $('#tambah-data-container').html('');
            $('#preview-gambar').attr('src', '{{ asset('image/imgNone.png') }}');
            $('#gambar').val('');
        });
    </script>
@endsection
