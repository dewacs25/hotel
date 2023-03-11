<div class="container">
    <center class="mt-3">
        <button onclick="CloseCheckIn()" class="btn btn-close"></button>
        <div class="col-lg-6 col-12">
            <h3>Check Out</h3>
            <div class="bg-danger rounded-3" id="reader" width="600px"></div>
            <input type="hidden" id="result">
        </div>
    </center>
</div>
<script>
    // $('#result').val('test');
    function onScanSuccess(decodedText, decodedResult) {
        // alert(decodedText);
        $('#result').val(decodedText);
        let id = decodedText;
        html5QrcodeScanner.clear().then(_ => {
            // var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({

                url: "{{ route('validasi2') }}",
                type: 'POST',
                data: {
                    _methode: "POST",
                    _token: "{{ csrf_token() }}",
                    qr_code: id
                },
                success: function(response) {

                    // console.log(response);
                    if (response.status == 200) {
                        showAlertSuccess(response.message)
                    } else if (response.status == 201) {
                        showAlertInfo(response.message)
                    } else {
                        showAlertError(response.message)
                    }

                }
            });
        }).catch(error => {
            alert('something wrong');
        });

    }

    function onScanFailure(error) {
        // handle scan failure, usually better to ignore and keep scanning.
        // for example:
        // console.warn(`Code scan error = ${error}`);
    }

    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", {
            fps: 10,
            qrbox: {
                width: 260,
                height: 260
            }
        },
        /* verbose= */
        false);
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);

   
</script>