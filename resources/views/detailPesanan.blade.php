@extends('layouts.app')

@section('content')
    <div class="container">
        
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow">
                    <div class="card-header">{{ $product->nama_product }}</div>

                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6">
                                <p>{!! $product->deskripsi !!}</p>
                                <h3>Harga : Rp.{{ number_format($product->harga, 2, ',', '.') }}</h3>


                            </div>
                            <div class="col-md-6">
                                <img id="preview-gambar" src="{{ asset('storage/image/product/' . $product->gambar) }}"
                                    alt="Rusak" class="w-100 border border-3">
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card border-0 shadow mt-3">
                    <div class="card-body">


                        <div class="row">
                            <div class="col-md-6">
                                <p>Nama : {{ Auth::guard('web')->user()->name }}</p>
                                <p>Email : {{ Auth::guard('web')->user()->email }}</p>

                                <div class="form-group mb-2">
                                    <label for="price">Total Harga :</label><br>
                                    <input id="price" class="form-control bg-transparent border-0" type="text"
                                        disabled>
                                </div>

                                <div class="form-group">
                                    <button id="tambah-data" class="btn btn-success">Booking</button>
                                    <a href="/" class="btn btn-danger" id="btn-tutup-form">Batal</a>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="checkin">Check In</label><br>
                                    <input id="checkin" class="form-control" type="datetime-local"
                                        onchange="calculatePrice()">
                                </div>
                                <div class="form-group">
                                    <label for="checkout">Check Out</label><br>
                                    <input id="checkout" class="form-control" type="datetime-local"
                                        onchange="calculatePrice()">
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const checkinInput = document.querySelector('#checkin');
        const checkoutInput = document.querySelector('#checkout');

        // Set min attribute for checkin input to current datetime
        checkinInput.min = new Date().toISOString().slice(0, -8);

        checkinInput.addEventListener('input', () => {
            // Set min attribute for checkout input to checkin value
            checkoutInput.min = checkinInput.value;

            // Validate checkin input
            if (new Date(checkinInput.value) < new Date()) {
                alert('Check-in time must be after current time.');
                checkinInput.value = '';
            }
        });

        checkoutInput.addEventListener('input', () => {
            // Validate checkout input
            if (new Date(checkoutInput.value) < new Date(checkinInput.value)) {
                alert('Check-out time must be after check-in time.');
                checkoutInput.value = '';
            }
        });

        function calculatePrice() {
            const checkin = new Date(document.getElementById('checkin').value);
            const checkout = new Date(document.getElementById('checkout').value);
            const diffTime = Math.abs(checkout - checkin);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); // convert to days
            let price = {{ $product->harga }};
            if (diffDays > 0) {
                price = price * diffDays; // set the price based on the number of days
            }
            document.getElementById('price').value = price;
        }

        $(document).ready(function() {
            $('#tambah-data').click(function() {
                Swal.fire({
                    title: 'Anda yakin ingin menambahkan data?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Tambahkan!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Panggil fungsi untuk melakukan insert data
                        tambahData();
                    }
                });
            });
        });

        function tambahData() {
            // Ambil nilai input dari form
            var checkin = $('#checkin').val();
            var checkout = $('#checkout').val();
            var price = $('#price').val();
            var random = Math.random().toString(20).substring(2);
            var token = '{{ Auth::user()->email }}'+'-'+random;

            // Buat objek FormData untuk mengirim data ke server
            var formData = new FormData();
            formData.append('_methode', 'POST');
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('id_product', '{{ $product->id_product }}');
            formData.append('checkin', checkin);
            formData.append('checkout', checkout);
            formData.append('price', price);
            formData.append('token', token);

            
            $.ajax({
                type: "POST",
                url: "/booking", 
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                   
                    Swal.fire(
                        'Sukses!',
                        'Pesanan Berhasil Silahkan Lakukan Pembayaran.',
                        'success'
                    ).then(function() {
                        window.location = '/transaksi/'+token;
                    });
                },
                error: function(xhr, status, error) {
                    
                    Swal.fire(
                        'Error!',
                        'Terjadi kesalahan saat menambahkan data.',
                        'error'
                    );
                }
            });
        }
    </script>
@endsection
