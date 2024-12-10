@if(empty($dosen) && empty($tendik))
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
                <a href="{{ url('/profile') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/profile/' . ($dosen ? $dosen->user_id : $tendik->user_id) . '/update_profile') }}" method="POST" id="form-edit"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Profile Anda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    @if($dosen)
                        <div class="form-group">
                            <label>NIDN</label>
                            <input value="{{ $dosen->nidn }}" type="text" name="nidn" id="nidn" class="form-control" readonly>
                            <small id="error-nidn" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input value="{{ $dosen->dosen_nama }}" type="text" name="dosen_nama" id="dosen_nama" class="form-control" required>
                            <small id="error-dosen_nama" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>No. Telp</label>
                            <input value="{{ $dosen->dosen_no_telp }}" type="text" name="dosen_no_telp" id="dosen_no_telp" class="form-control" required>
                            <small id="error-dosen_no_telp" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input value="{{ $dosen->dosen_email }}" type="email" name="dosen_email" id="dosen_email" class="form-control" required>
                            <small id="error-dosen_email" class="error-text form-text text-danger"></small>
                        </div>
                    @elseif($tendik)
                        <div class="form-group">
                            <label>NIP</label>
                            <input value="{{ $tendik->nip }}" type="text" name="nip" id="nip" class="form-control" readonly>
                            <small id="error-nip" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input value="{{ $tendik->tendik_nama }}" type="text" name="tendik_nama" id="tendik_nama" class="form-control" required>
                            <small id="error-tendik_nama" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>No. Telp</label>
                            <input value="{{ $tendik->tendik_no_telp }}" type="text" name="tendik_no_telp" id="tendik_no_telp" class="form-control" required>
                            <small id="error-tendik_no_telp" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input value="{{ $tendik->tendik_email }}" type="email" name="tendik_email" id="tendik_email" class="form-control" required>
                            <small id="error-tendik_email" class="error-text form-text text-danger"></small>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </form>
@endif

        <script>
            $(document).ready(function() {
                $("#form-edit").validate({
                    rules: {
                        dosen_nama: {
                            required: true,
                            maxlength: 100
                        },
                        dosen_no_telp: {
                            required: true,
                            maxlength: 15
                        },
                        dosen_email: {
                            required: true,
                            maxlength: 100
                        },
                        tendik_nama: {
                            required: true,
                            maxlength: 100
                        },
                        tendik_no_telp: {
                            required: true,
                            maxlength: 15
                        },
                        tendik_email: {
                            required: true,
                            maxlength: 100
                        }
                    },
                    submitHandler: function(form) {
                        var formData = new FormData(
                            form);
                        $.ajax({
                            url: form.action,
                            type: form.method,
                            data: $(form).serialize(),
                            success: function(response) {
                                if (response.status) {
                                    $('#myModal').modal('hide');
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: response.message
                                    });
                                    setTimeout(function() {
                                        location.reload();
                                    }, 2000);
                                } else {
                                    $('.error-text').text('');
                                    $.each(response.msgField, function(prefix, val) {
                                        $('#error-' + prefix).text(val[0]);
                                    });
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Terjadi Kesalahan',
                                        text: response.message
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                console.log('Response:', xhr.responseText);  
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: 'Ada masalah saat mengirim permintaan.'
                                });
                            }
                        });
                        return false;
                    },
                    errorElement: 'span',
                    errorPlacement: function(error, element) {
                        error.addClass('invalid-feedback');
                        element.closest('.form-group').append(error);
                    },
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass('is-invalid');
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).removeClass('is-invalid');
                    }
                });
            });
        </script>
