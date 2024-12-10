@empty($progress)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a data-dismiss="modal" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/task/' . $progress->progress_id . '/upload_file') }}" method="POST" id="form-upload" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="border-radius: 20px; padding: 20px;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload Tugas</h5>
                    <button type="button" class="close" aria-label="Close" data-dismiss="modal" style="position: absolute; top: 10px; right: 15px; font-size: 24px; border: none; background: none; cursor: pointer;"> 
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <h2>{{ $progress->tugas->tugas_nama }}</h2>
                    <div class="form-group">
                        <label>Pilih File</label>
                        <input type="file" name="file_mahasiswa" id="file_mahasiswa" class="form-control" required>
                        <small id="error-file_mahasiswa" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="mt-4">
                        <button class="btn btn-warning" type="button" data-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-success">Upload</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            $("#form-upload").validate({
                rules: {
                    file_mahasiswa: { required: true, extension: "doc|docx|pdf|ppt|pptx|xls|xlsx|zip|rar" }
                }, 
                submitHandler: function(form) {
                    var formData = new FormData(form);
                    
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: formData,
                        processData: false, // Jangan proses data menjadi string
                        contentType: false, // Jangan tentukan tipe konten
                        success: function(response) {
                            if (response.status) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                }).then(() => {
                                    $('#modal-master').modal('hide');
                                    location.reload();
                                });
                            } else {
                                $('.error-text').text('');
                                if (response.msgField) {
                                    $.each(response.msgField, function(prefix, val) {
                                        $('#error-' + prefix).text(val[0]);
                                    });
                                }
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Kesalahan Server',
                                text: xhr.responseJSON ? xhr.responseJSON.message : 'Terjadi kesalahan, silakan coba lagi.'
                            });
                        }
                    });

                    return false; // Mencegah submit bawaan
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback'); // Tambahkan class error
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid'); // Tambahkan class saat ada error
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid'); // Hapus class error
                }
            });
        });
    </script>
@endempty
