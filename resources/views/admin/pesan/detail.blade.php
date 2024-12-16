@empty($mahasiswa)
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
                <a href="{{ url('/pesan') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form id="form-validasi">
        @csrf
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="border-radius: 20px; padding: 20px;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Apply Tugas</h5>
                    <button type="button" class="close" aria-label="Close" data-dismiss="modal" style="position: absolute; top: 10px; right: 15px; font-size: 24px; border: none; background: none; cursor: pointer;"> 
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <p>Mahasiswa {{ $mahasiswa->mahasiswa_nama }} ingin mengajukan pengaktifan akun, terima?</p>
                    <table>
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
                        <tr>
                            <th class="text-right col-3">Foto KTM :</th>
                            <td>
                               <img src="{{ asset($mahasiswa->ktm) }}" alt="Foto KTM" style="width: 500px; height: 250px;">
                            </td>
                        </tr>
                    </table>
                    <div class="mt-4">
                        <button type="button" id="btn-tolak" class="btn btn-danger" onclick="submitForm('{{ url('/pesan/' . $mahasiswa->mahasiswa_id . '/decline_mahasiswa') }}')">Tolak</button>
                        <button type="button" id="btn-terima" class="btn btn-success" onclick="submitForm('{{ url('/pesan/' . $mahasiswa->mahasiswa_id . '/acc_mahasiswa') }}')">Terima</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        function submitForm(route) {
            $.ajax({
                url: route,
                type: 'POST',
                data: $('#form-validasi').serialize(),
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