@empty($approve)
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
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Penerimaan Tugas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success">
                    <h5><i class="icon fas fa-info-circle"></i> Informasi !!!</h5>
                    Tugas telah dikumpulkan
                </div>
                <table class="table table-sm table-bordered table-striped">
                    <tr>
                        <th class="text-right col-3">Nama Mahasiswa :</th>
                        <td class="col-9">{{ $approve->mahasiswa->mahasiswa_nama }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Nama Tugas :</th>
                        <td class="col-9">{{ $approve->tugas->tugas_nama }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Deskripsi Tugas :</th>
                        <td class="col-9">
                            {{ $approve->tugas->tugas_deskripsi }}
                        </td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Bobot Tugas :</th>
                        <td class="col-9">{{ $approve->tugas->tugas_jam_kompen }} Jam</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Download :</th>
                        <td class="col-9">
                            @if($fileTugas)
                                <a href="{{ $fileTugas['path'] }}" class="btn btn-info" download>
                                    <i class="{{ $fileTugas['icon'] }}"></i> {{ $fileTugas['name'] }}
                                </a>
                            @else
                                <span>No file available for download.</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn-tolak" class="btn btn-danger" onclick="submitForm('{{ url('/pesan/' . $approve->approval_id . '/decline_tugas') }}')">Tolak</button>

                <button type="button" id="btn-terima" class="btn btn-success" onclick="submitForm('{{ url('/pesan/' . $approve->approval_id . '/acc_tugas') }}')">Terima</button>
            </div>
        </div>
    </div>
    <script>
        function submitForm(route) {
            $.ajax({
                url: route,
                type: 'POST',
                data: $('#form-apply').serialize(),
                success: function(response) {
                    if (response.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        }).then(() => {
                            window.location.href = "{{ url('/pesan') }}";
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
        }
    </script>
@endempty
