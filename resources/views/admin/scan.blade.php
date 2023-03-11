@extends('layouts/app_admin')
@section('content_admin')
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <div>
        <button id="btn-checkin" class="btn btn-success">Check In</button>
        <button id="btn-checkout" class="btn btn-danger">Check Out</button>
    </div>
    <div id="checkin" class="mb-5"></div>
    <div id="checkout" class="mb-5"></div>



    <script>
        $(document).ready(function() {
            $('#btn-checkin').click(function() {
                $.ajax({
                    url: '/admin/scan/checkin',
                    type: 'GET',
                    success: function(response) {
                        $('#checkin').html(response);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });

        $(document).ready(function() {
            $('#btn-checkout').click(function() {
                $.ajax({
                    url: '/admin/scan/checkout',
                    type: 'GET',
                    success: function(response) {
                        $('#checkin').html(response);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });

        function CloseCheckIn() {
            $('#checkin').html('');
            location.reload();
        }

        function showAlertError(message) {
            Swal.fire({
                title: 'Warning !',
                text: message,
                icon: 'error',
                confirmButtonText: 'OK',
                willClose: () => {
                    window.location.href = "/admin/scan";
                }
            })
        }

        function showAlertSuccess(message) {
            Swal.fire({
                title: 'Success',
                text: message,
                icon: 'success',
                confirmButtonText: 'OK',
                willClose: () => {
                    window.location.href = "/admin/scan";
                }
            })
        }

        function showAlertInfo(message) {
            Swal.fire({
                title: 'Success',
                text: message,
                icon: 'info',
                confirmButtonText: 'Ok',
                willClose: () => {
                    window.location.href = "/admin/scan";
                }
            })
        }
    </script>
@endsection
