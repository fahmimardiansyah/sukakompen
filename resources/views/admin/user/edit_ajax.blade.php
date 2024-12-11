@empty($user)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" arialabel="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/user') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/user/' . $user->user_id . '/update_ajax') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data User</h5>
                    <button type="button" class="close" data-dismiss="modal" arialabel="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Level Pengguna</label>
                        <select name="level_id" id="level_id" class="form-control" disabled>
                            <option value="">- Pilih Level -</option>
                            @foreach ($level as $l)
                                <option {{ $l->level_id == $user->level_id ? 'selected' : '' }}
                                    value="{{ $l->level_id }}">{{ $l->level_nama }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="level_id" value="{{ $user->level_id }}">
                        <small id="error-level_id" class="error-text form-text textdanger"></small>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input value="{{ $user->username }}" type="text" name="username" id="username"
                            class="form-control" required>
                        <small id="error-username" class="error-text form-text textdanger"></small>
                    </div>
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
                    @elseif($mahasiswa)
                        <div class="form-group">
                            <label>NIM</label>
                            <input value="{{ $mahasiswa->nim }}" type="text" name="nim" id="nim" class="form-control" readonly>
                            <small id="error-nim" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input value="{{ $mahasiswa->mahasiswa_nama }}" type="text" name="mahasiswa_nama" id="mahasiswa_nama" class="form-control" required>
                            <small id="error-mahasiswa_nama" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Prodi</label>
                            <select name="prodi_id" id="prodi_id" class="form-control" disabled>
                                <option value="">- Pilih Level -</option>
                                @foreach ($prodi as $p)
                                    <option {{ $p->prodi_id == $mahasiswa->prodi_id ? 'selected' : '' }}
                                        value="{{ $p->prodi_id }}">{{ $p->prodi_nama }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="prodi_id" value="{{ $mahasiswa->prodi_id }}">
                            <small id="error-prodi_id" class="error-text form-text textdanger"></small>
                        </div>
                        <div class="form-group">
                            <label>Semester</label>
                            <input value="{{ $mahasiswa->semester }}" type="text" name="semester" id="semester" class="form-control" readonly>
                            <small id="error-semester" class="error-text form-text text-danger"></small>
                        </div>
                    @endif
                    <div class="form-group">
                        <label>Password</label>
                        <input value="" type="password" name="password" id="password" class="form-control">
                        <small class="form-text text-muted">Abaikan jika tidak ingin ubah password</small>
                        <small id="error-password" class="error-text form-text textdanger"></small>
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
                    level_id: {
                        required: true,
                        number: true
                    },
                    username: {
                        required: true,
                        minlength: 3,
                        maxlength: 20
                    },
                    password: {
                        minlength: 5,
                        maxlength: 20
                    }
                },
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
                                });
                                setTimeout(() => location.reload(), 2000);
                            } else {
                                $('.error-text').text('');
                                $.each(response.msgField, (prefix, val) => {
                                    $('#error-' + prefix).text(val[0]);
                                });
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message
                                });
                            }
                        },
                        error: function(xhr) {
                            console.error('Error:', xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Kesalahan',
                                text: 'Gagal mengirim data'
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
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>

@endempty