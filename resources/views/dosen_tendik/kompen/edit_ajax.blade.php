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
    <form action="{{ url('/kompen/' . $tugas->tugas_id . '/update_ajax') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Tugas Kompen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Tugas</label>
                        <input value="{{ $tugas->tugas_nama }}" type="text" name="tugas_nama" id="tugas_nama" class="form-control" required>
                        <small id="error-tugas_nama" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Jenis Tugas</label>
                        <select name="jenis_id" id="jenis_id" class="form-control" required>
                            <option value="">- Pilih Jenis -</option>
                            @foreach ($jenis as $j)
                                <option {{ $j->jenis_id == $tugas->jenis_id ? 'selected' : '' }} value="{{ $j->jenis_id }}">{{ $j->jenis_nama }}</option>
                            @endforeach
                        </select>
                        <small id="error-jenis_id" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Kompetensi Tugas</label>
                        <select name="kompetensi_id" id="kompetensi_id" class="form-control" required>
                        <option value="">- Pilih Kompetensi -</option>
                        @foreach ($kompetensi as $k)
                            <option {{ $k->kompetensi_id == $tugas->kompetensi_id ? 'selected' : '' }} value="{{ $k->kompetensi_id }}">{{ $k->kompetensi_nama }}</option>
                        @endforeach
                        </select>
                        <small id="error-kompetensi_id" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi Tugas</label>
                        <textarea name="tugas_deskripsi" id="tugas_deskripsi" class="form-control" rows="4" required>{{ $tugas->tugas_deskripsi }}</textarea>
                        <small id="error-tugas_deskripsi" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Tipe Tugas</label>
                        <select name="tugas_tipe" id="tugas_tipe" class="form-control" required>
                            <option value="">- Pilih Tipe Tugas -</option>
                            @foreach ($tipe as $t)
                                <option value="{{ $t }}" {{ $t == $tugas->tugas_tipe ? 'selected' : '' }}>
                                    {{ $t }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-tugas_tipe" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Kuota Tugas</label>
                        <input value="{{ $tugas->tugas_kuota }}" type="number" name="tugas_kuota" id="tugas_kuota" class="form-control" required>
                        <small id="error-tugas_kuota" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Jam Kompen</label>
                        <input value="{{ $tugas->tugas_jam_kompen }}" type="number" name="tugas_jam_kompen" id="tugas_jam_kompen" class="form-control" required>
                        <small id="error-tugas_jam_kompen" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Tenggat</label>
                        <input value="{{ $tugas->tugas_tenggat }}" type="datetime-local" name="tugas_tenggat" id="tugas_tenggat" class="form-control" required>
                        <small id="error-tugas_tenggat" class="error-text form-text text-danger"></small>
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
            $('#jenis_id').on('change', function() {
                let jenisId = $(this).val();
                $('#kompetensi_id').empty().append('<option value="">- Pilih Kompetensi -</option>');

                if (jenisId) {
                    $.ajax({
                        url: `/kompen/getkompetensi/${jenisId}`,
                        type: 'GET',
                        success: function(response) {
                            response.forEach(function(kompetensi) {
                                $('#kompetensi_id').append(
                                    `<option value="${kompetensi.kompetensi_id}">${kompetensi.kompetensi_nama}</option>`
                                );
                            });
                        },
                        error: function() {
                            alert('Gagal mengambil data kompetensi');
                        }
                    });
                }
            });
        });

        $(document).ready(function() {
            $("#form-edit").validate({
                rules: {
                    tugas_nama: { required: true, minlength: 3, maxlength: 100 },
                    jenis_id: { required: true, number: true },
                    tugas_tipe: { required: true},
                    tugas_deskripsi: { required: true, minlength: 10 },
                    tugas_kuota: { required: true, number: true, max: 10 },
                    tugas_jam_kompen: { required: true, number: true, max: 50 },
                    tugas_tenggat: { required: true},
                    kompetensi_id: { required: true, number: true }
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: 'POST',
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.status) {
                                $('#myModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                                dataTugas.ajax.reload(); 
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
                            console.error("Status: " + status);
                            console.error("Error: " + error);
                            console.error("Response: " + xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: 'Gagal mengirim data.'
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