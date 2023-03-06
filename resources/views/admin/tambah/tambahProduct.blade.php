<form action="{{ route('tambah.product') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-3">

                <input type="text" name="nama_product" class="form-control" id="exampleFormControlInput1"
                    placeholder="Nama Kamar">
            </div>
            <div class="form-group mb-3">
                <label for="editor">Deskripsi :</label>
                <textarea name="deskripsi" id="editor"></textarea>
            </div>
            <div class="form-group mb-3">

                <input type="number" name="harga" class="form-control" id="exampleFormControlInput1"
                    placeholder="Harga Kamar">
            </div>
            <div class="form-group mb-3">

                <input type="file" id="gambar" name="gambar">

            </div>

            <div class="form-group mb-3">
                <button type="submit" class="btn btn-success">Tambah</button>
                <button type="button" class="btn btn-danger" id="btn-tutup-form">Batal</button>

            </div>
        </div>
        <div class="col-md-6">
            <img id="preview-gambar" src="{{ asset('image/imgNone.png') }}" alt="Rusak"
                class="w-100 border border-3">
        </div>


</form>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => {
            console.error(error);
        });

    $('#gambar').change(function() {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#preview-gambar').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        } else {
            $('#preview-gambar').attr('src', '{{ asset('image/imgNone.png') }}');
        }
    });

   
</script>
