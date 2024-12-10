@empty($tugas)
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
                <a href="{{ url('/kompen') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/kompen/' . $tugas->tugas_id . '/delete_ajax') }}" method="POST" id="form-delete">
        @csrf
        @method('DELETE')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data Jenis</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <h5><i class="icon fas fa-ban"></i> Konfirmasi !!!</h5>
                        Apakah Anda ingin menghapus data seperti di bawah ini?
                    </div>
                    <table class="table table-sm table-bordered table-striped">
                        <tr>
                            <th class="text-right col-3">Nama Tugas :</th>
                            <td class="col-9">{{ $tugas->tugas_nama }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Deskripsi Tugas :</th>
                            <td class="col-9">{{ $tugas->tugas_deskripsi }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Jenis Tugas :</th>
                            <td class="col-9">{{ $tugas->jenis->jenis_nama }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Tipe Tugas :</th>
                            <td class="col-9">{{ $tugas->tugas_tipe }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Kuota Tugas :</th>
                            <td class="col-9">{{ $tugas->tugas_kuota }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Jam Kompen :</th>
                            <td class="col-9">{{ $tugas->tugas_jam_kompen }} Jam</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Tanggal Tenggat :</th>
                            <td class="col-9">{{ $tugas->tugas_tenggat }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Kompetensi Tugas :</th>
                            <td class="col-9"> 
                                @foreach ($kompetensi as $data)
                                    <li>{{ $data->kompetensi->kompetensi_nama }}</li>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">File Tugas :</th>
                            <td class="col-9">
                                @if($fileData)
                                    <a href="{{ $fileData['path'] }}" class="btn btn-info" download>
                                        <i class="{{ $fileData['icon'] }}"></i> {{ $fileData['name'] }}
                                    </a>
                                @else
                                    <span>No file available for download.</span>
                                @endif
                            </td>
                        </tr>
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