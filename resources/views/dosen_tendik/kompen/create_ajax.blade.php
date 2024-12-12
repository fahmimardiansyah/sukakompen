<form action="{{ url('/kompen/ajax') }}" method="POST" id="form-tambah" enctype="multipart/form-data">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Tugas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Tugas</label>
                    <input type="text" name="tugas_nama" id="tugas_nama" class="form-control" required>
                    <small id="error-tugas_nama" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Jenis Tugas</label>
                    <select name="jenis_id" id="jenis_id" class="form-control" required>
                        <option value="">- Pilih Jenis -</option>
                        @foreach ($jenis as $j)
                            <option value="{{ $j->jenis_id }}">{{ $j->jenis_nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-jenis_id" class="error-text form-text text-danger"></small>
                </div>
                
                <div class="form-group">
                    <label>Kompetensi Tugas</label>
                    <div id="kompetensi-container">
                        <div class="kompetensi-group">
                            <h6 class="d-flex justify-content-between align-items-center">
                                Kompetensi 
                                <button type="button" class="btn btn-sm btn-danger remove-kompetensi ml-2">×</button>
                            </h6>
                            <select name="kompetensi_id[]" class="form-control kompetensi-select" required>
                                <option value="">- Pilih Kompetensi -</option>
                                @foreach ($kompetensi as $k)
                                    <option value="{{ $k->kompetensi_id }}">{{ $k->kompetensi_nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="button" id="add-kompetensi" class="btn btn-sm btn-success mt-2">Tambah Kompetensi</button>
                    <small id="error-kompetensi_id" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Deskripsi Tugas</label>
                    <textarea name="tugas_deskripsi" id="tugas_deskripsi" class="form-control" rows="4" required></textarea>
                    <small id="error-tugas_deskripsi" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Tipe Tugas</label>
                    <select name="tugas_tipe" id="tugas_tipe" class="form-control" required>
                        <option value="">- Pilih Tipe Tugas -</option>
                        @foreach ($tipe as $type)
                            <option value="{{ $type }}">{{ $type }}</option>
                        @endforeach
                    </select>
                    <small id="error-tugas_tipe" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Kuota Tugas</label>
                    <input type="number" name="tugas_kuota" id="tugas_kuota" class="form-control" required>
                    <small id="error-tugas_kuota" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Upload File Tugas</label>
                    <input type="file" name="file_tugas" id="file_tugas" class="form-control">
                    <small id="error-file_tugas" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Jam Kompen</label>
                    <input type="number" name="tugas_jam_kompen" id="tugas_jam_kompen" class="form-control" required>
                    <small id="error-tugas_jam_kompen" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Tanggal Tenggat</label>
                    <input type="datetime-local" name="tugas_tenggat" id="tugas_tenggat" class="form-control" required>
                    <small id="error-tugas_tenggat" class="error-text form-text text-danger"></small>
                </div>
            
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        const kompetensiOptions = @json($kompetensi);

        $('#add-kompetensi').click(function() {
            const selectedCompetency = $('#kompetensi-container .kompetensi-select:last')
                .val(); 

            if (!selectedCompetency) {
                Swal.fire({
                    icon: 'info',
                    title: 'Pilih Kompetensi Terlebih Dahulu',
                    text: 'Harap pilih kompetensi terlebih dahulu sebelum menambah kompetensi baru.'
                });
                return;
            }

            const existingSelections = $('.kompetensi-select').map(function() {
                return $(this).val();
            }).get();

            const filteredOptions = kompetensiOptions.filter(k => !existingSelections.includes(k
                .kompetensi_id.toString()));

            if (filteredOptions.length === 0) {
                Swal.fire({
                    icon: 'info',
                    title: 'Tidak Ada Kompetensi Tersisa',
                    text: 'Semua kompetensi telah dipilih.'
                });
                return;
            }

            const newIndex = $('.kompetensi-group').length + 1;

            const newDropdown = $(`
                <div class="kompetensi-group mt-2">
                    <h6 class="d-flex justify-content-between align-items-center">
                        Kompetensi ${newIndex}
                        <button type="button" class="btn btn-sm btn-danger remove-kompetensi ml-2">Hapus</button>
                    </h6>
                    <select name="kompetensi_id[]" class="form-control kompetensi-select" required>
                        <option value="">- Pilih Kompetensi -</option>
                    </select>
                </div>
            `);

            filteredOptions.forEach(option => {
                newDropdown.find('select').append(
                    `<option value="${option.kompetensi_id}">${option.kompetensi_nama}</option>`
                );
            });

            $('#kompetensi-container').append(newDropdown);
        });

        $(document).on('click', '.remove-kompetensi', function() {
            $(this).closest('.kompetensi-group').remove();

            toggleRemoveButtonVisibility();
        });

        function toggleRemoveButtonVisibility() {
            if ($('.kompetensi-group').length === 1) {
                $('.remove-kompetensi').hide(); 
            } else {
                $('.remove-kompetensi').show(); 
            }

            $('.kompetensi-group:first .remove-kompetensi').hide();
        }

        toggleRemoveButtonVisibility();
    });

    $(document).ready(function() {
        $("#form-tambah").validate({
            rules: {
                tugas_nama: { required: true, minlength: 3, maxlength: 100 },
                jenis_id: { required: true, number: true },
                tugas_tipe: { required: true},
                tugas_deskripsi: { required: true, minlength: 10 },
                tugas_kuota: { required: true, number: true, max: 10 },
                tugas_jam_kompen: { required: true, number: true, max: 50 },
                tugas_tenggat: { required: true},
                kompetensi_id: { required: true, number: true },
                file_tugas: { extension: "doc|docx|pdf|ppt|pptx|xls|xlsx|zip|rar" }
            },
            submitHandler: function(form) {
                let formData = new FormData(form);

                $.ajax({
                    url: form.action,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
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