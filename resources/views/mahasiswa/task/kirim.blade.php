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
    <form action="{{ url('/task/' . $progress->progress_id . '/kirim_tugas') }}" method="POST" id="form-kirim">
        @csrf
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="border-radius: 20px; padding: 20px;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Mengirim Tugas</h5>
                    <button type="button" class="close" aria-label="Close" data-dismiss="modal" style="position: absolute; top: 10px; right: 15px; font-size: 24px; border: none; background: none; cursor: pointer;"> 
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <h2>{{ $progress->tugas->tugas_nama }}</h2>
                    <p>Yakin ingin mengirim tugas ini?</p>
                    <p>
                        @if($fileTugas)
                            <a href="{{ $fileTugas['path'] }}" download>
                                <i class="{{ $fileTugas['icon'] }}"></i> {{ $fileTugas['name'] }}
                            </a>
                        @else
                            <span>No file available for download.</span>
                        @endif
                    </p>
                    <div class="mt-4">
                        <button class="btn btn-warning" type="button" data-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-success">Kirim</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            $("#form-kirim").validate({
                rules: {},
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.status) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                }).then(() => {
                                    window.location.href = "{{ url('/dashboardmhs') }}";
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
                    return false; 
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
