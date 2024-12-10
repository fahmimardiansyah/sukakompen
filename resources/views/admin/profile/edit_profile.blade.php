@empty($admin)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                        Data yang anda cari tidak ditemukan
                    </div>
                    <a href="{{ url('/profil') }}" class="btn btn-warning">Kembali</a>
                </div>
            </div>
        </div>
    @else
        <form action="{{ url('/profil/' . $admin->user_id . '/update_profile') }}" method="POST" id="form-edit"
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
                        <div class="form-group">
                            <label>NIP</label>
                            <input value="{{ $admin->nip }}" type="text" name="nip" id="nip" class="form-control" readonly>
                            <small id="error-nip" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input value="{{ $admin->admin_nama }}" type="text" name="admin_nama" id="admin_nama" class="form-control" required>
                            <small id="error-admin_nama" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>No. Telp</label>
                            <input value="{{ $admin->admin_no_telp }}" type="text" name="admin_no_telp" id="admin_no_telp" class="form-control" required>
                            <small id="error-admin_no_telp" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input value="{{ $admin->admin_email }}" type="email" name="admin_email" id="admin_email" class="form-control" required>
                            <small id="error-admin_email" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
        <script>
            $(document).ready(function() {
                $("#form-edit").validate({
                    rules: {
                        admin_nama: {
                            required: true,
                            maxlength: 100
                        },
                        admin_no_telp: {
                            required: true,
                            maxlength: 15
                        },
                        admin_email: {
                            required: true,
                            maxlength: 100
                        },
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
    @endempty
