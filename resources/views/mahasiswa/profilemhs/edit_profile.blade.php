@empty($mahasiswa)
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
                    <a data-dismiss="modal" class="btn btn-warning">Kembali</a>
                </div>
            </div>
        </div>
    @else
        <form action="{{ url('/profilemhs/' . $mahasiswa->user_id . '/update_profile') }}" method="POST" id="form-edit"
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
                            <label>Kompetensi Tugas</label>
                            <div id="kompetensi-container">
                                @foreach ($kompetensiMahasiswa as $kt)
                                    <div class="kompetensi-group">
                                        <select name="kompetensi_id[]" class="form-control kompetensi-select" readonly>
                                            <option value="">- Pilih Kompetensi -</option>
                                            @foreach ($kompetensi as $k)
                                                <option value="{{ $k->kompetensi_id }}" {{ $kt->kompetensi_id == $k->kompetensi_id ? 'selected' : '' }}>{{ $k->kompetensi_nama }}</option>
                                            @endforeach
                                        </select>
                                        <button type="button" class="btn btn-sm btn-danger remove-kompetensi ml-2">Hapus</button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" id="add-kompetensi" class="btn btn-sm btn-success mt-2">Tambah Kompetensi</button>
                            <small id="error-kompetensi_id" class="error-text form-text text-danger"></small>
                        </div>

                        <div class="form-group">
                            <label>Prodi</label>
                            <input value="{{ $mahasiswa->prodi->prodi_nama }}" type="text" name="prodi" id="prodi" class="form-control" readonly>
                            <small id="error-prodi" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Semester</label>
                            <input value="{{ $mahasiswa->semester }}" type="text" name="semester" id="semester" class="form-control" readonly>
                            <small id="error-semester" class="error-text form-text text-danger"></small>
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
            $(document).ready(function () {
                const kompetensiOptions = @json($kompetensi);

                $('#add-kompetensi').click(function () {
                    const selectedCompetency = $('#kompetensi-container .kompetensi-select:last').val();  // Check last selected competency

                    if (!selectedCompetency) {
                        Swal.fire({
                            icon: 'info',
                            title: 'Pilih Kompetensi Terlebih Dahulu',
                            text: 'Harap pilih kompetensi terlebih dahulu sebelum menambah kompetensi baru.'
                        });
                        return;
                    }

                    const existingSelections = $('.kompetensi-select').map(function () {
                        return $(this).val();
                    }).get();

                    const filteredOptions = kompetensiOptions.filter(k => !existingSelections.includes(k.kompetensi_id.toString()));

                    if (filteredOptions.length === 0) {
                        Swal.fire({
                            icon: 'info',
                            title: 'Tidak Ada Kompetensi Tersisa',
                            text: 'Semua kompetensi telah dipilih.'
                        });
                        return;
                    }

                    const newDropdown = $('<div class="kompetensi-group mt-2">')
                        .append('<select name="kompetensi_id[]" class="form-control kompetensi-select" required></select>')
                        .append('<button type="button" class="btn btn-sm btn-danger remove-kompetensi ml-2">Hapus</button>');

                    filteredOptions.forEach(option => {
                        newDropdown.find('select').append(`<option value="${option.kompetensi_id}">${option.kompetensi_nama}</option>`);
                    });

                    $('#kompetensi-container').append(newDropdown);
                });

                $(document).on('click', '.remove-kompetensi', function () {
                    $(this).closest('.kompetensi-group').remove();
                });
            });

            $(document).ready(function() {
                $("#form-edit").validate({
                    rules: {
                        mahasiswa_nama: {
                            required: true,
                            maxlength: 100
                        },
                        kompetensi_id: { 
                            required: true, 
                            number: true 
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
