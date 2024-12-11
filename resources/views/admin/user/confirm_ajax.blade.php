@empty($user)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
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
    <form action="{{ url('/user/' . $user->user_id . '/delete_ajax') }}" method="POST" id="form-delete">
        @csrf
        @method('DELETE')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <h5><i class="icon fas fa-ban"></i> Konfirmasi !!!</h5>
                        Apakah Anda ingin menghapus data seperti di bawah ini?
                    </div>
                    <table class="table table-sm table-bordered table-striped">
                        <tr>
                            <th class="text-right col-3">Level Pengguna :</th>
                            <td class="col-9">{{ $user->level->level_nama }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Username :</th>
                            <td class="col-9">{{ $user->username }}</td>
                        </tr>
                        @if($user->level_id == 1)
                            <tr>
                                <th class="text-right col-3">NIP :</th>
                                <td class="col-9">{{ $admin->nip }}</td>
                            </tr> 
                            <tr>
                                <th class="text-right col-3">Nama :</th>
                                <td class="col-9">{{ $admin->admin_nama }}</td>
                            </tr>
                            <tr>
                                <th class="text-right col-3">No. Telp :</th>
                                <td class="col-9">{{ $admin->admin_no_telp }}</td>
                            </tr>
                            <tr>
                                <th class="text-right col-3">Email :</th>
                                <td class="col-9">{{ $admin->admin_email }}</td>
                            </tr>
                        @elseif($user->level_id == 2)
                            <tr>
                                <th class="text-right col-3">NIDN :</th>
                                <td class="col-9">{{ $dosen->nidn }}</td>
                            </tr> 
                            <tr>
                                <th class="text-right col-3">Nama :</th>
                                <td class="col-9">{{ $dosen->dosen_nama }}</td>
                            </tr>
                            <tr>
                                <th class="text-right col-3">No. Telp :</th>
                                <td class="col-9">{{ $dosen->dosen_no_telp }}</td>
                            </tr>
                            <tr>
                                <th class="text-right col-3">Email :</th>
                                <td class="col-9">{{ $dosen->dosen_email }}</td>
                            </tr>
                        @elseif($user->level_id == 3)
                            <tr>
                                <th class="text-right col-3">NIP :</th>
                                <td class="col-9">{{ $tendik->nip }}</td>
                            </tr> 
                            <tr>
                                <th class="text-right col-3">Nama :</th>
                                <td class="col-9">{{ $tendik->tendik_nama }}</td>
                            </tr>
                            <tr>
                                <th class="text-right col-3">No. Telp :</th>
                                <td class="col-9">{{ $tendik->tendik_no_telp }}</td>
                            </tr>
                            <tr>
                                <th class="text-right col-3">Email :</th>
                                <td class="col-9">{{ $tendik->tendik_email }}</td>
                            </tr>
                        @elseif($user->level_id == 4)
                            <tr>
                                <th class="text-right col-3">NIM :</th>
                                <td class="col-9">{{ $mahasiswa->nim }}</td>
                            </tr> 
                            <tr>
                                <th class="text-right col-3">Nama :</th>
                                <td class="col-9">{{ $mahasiswa->mahasiswa_nama }}</td>
                            </tr>
                            <tr>
                                <th class="text-right col-3">Jumlah Alpa :</th>
                                <td class="col-9">{{ $mahasiswa->jumlah_alpa ?? '0'}} Jam</td>
                            </tr>
                            <tr>
                                <th class="text-right col-3">Prodi :</th>
                                <td class="col-9">{{ $mahasiswa->prodi->prodi_nama }}</td>
                            </tr>
                            <tr>
                                <th class="text-right col-3">Kompetensi :</th>
                                <td class="col-9">
                                    @foreach ($kompetensi as $data)
                                        <li>{{ $data->kompetensi->kompetensi_nama }}</li>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <th class="text-right col-3">Semester :</th>
                                <td class="col-9">{{ $mahasiswa->semester }}</td>
                            </tr>
                        @endif
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                    <button type="submit" class="btn btn-primary">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            $("#form-delete").validate({
                rules: {},
                submitHandler: function(form) {
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
                                dataUser.ajax.reload();
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