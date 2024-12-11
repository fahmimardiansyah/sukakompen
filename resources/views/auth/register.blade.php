<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register Pengguna</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('login.css') }}">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center"><a href="{{ url('/') }}" class="h1"><b>Admin</b>LTE</a></div>
            <div class="card-body">
                <p class="login-box-msg">Sign up to start your session</p>
                <form action="{{ url('register') }}" method="POST" id="form-register">
                    @csrf
                    <div class="form-group">
                        <label>Level Pengguna</label>
                        <select name="level_id" id="level_id" class="form-control" required>
                            <option value="">- Pilih Level -</option>
                            @foreach($level as $l)
                                <option value="{{ $l->level_id }}">{{ $l->level_nama }}</option>
                            @endforeach
                        </select>
                        <small id="error-level_id" class="error-text form-text text-danger"></small>
                    </div>

                    <!-- Biodata fields will be dynamically added here -->
                    <div id="biodata-fields"></div>

                    <div class="row">
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
                        </div>
                    </div>
                    <p class="login-box-msg">Sudah Punya Akun? <a href="{{ url('login') }}">Sign in</a></p>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>

    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- jquery-validation -->
    <script src="{{ asset('adminlte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>


    <style>
        select {
            color: #535353; 
        }
    
        option {
            color: #535353; 
        }z
        .form-control.kompetensi-select {
        width: 320px; 
        height: 40px; 
        padding: 5px 10px;
        font-size: 14px; 
        color: rgb(255, 255, 255); 
        border: 1px solid #ccc; 
        border-radius: 5px; 
        }

        .form-control::placeholder {
        color: rgb(255, 255, 255); 
        }

    </style>
    
    <script>
        $(document).ready(function () {
            // Inisialisasi validasi
            const formValidator = $("#form-register").validate({
                rules: {
                    level_id: { required: true, number: true },
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function (response) {
                            if (response.status) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                }).then(function () {
                                    window.location = response.redirect;
                                });
                            } else {
                                showValidationErrors(response.msgField);
                            }
                        },
                        error: function (xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: xhr.responseText
                            });
                        }
                    });
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element) {
                    $(element).removeClass('is-invalid');
                }
            });

            $('#level_id').change(function () {
                const levelId = $(this).val();
                let biodataFields = '';
                const rules = {};

                if (levelId == 1) { // Admin
                    biodataFields += generateAdminFields();
                    $.extend(rules, adminRules());
                } else if (levelId == 2) { // Dosen
                    biodataFields += generateDosenFields();
                    $.extend(rules, dosenRules());
                } else if (levelId == 3) { // Tendik
                    biodataFields += generateTendikFields();
                    $.extend(rules, tendikRules());
                } else if (levelId == 4) { // Mahasiswa
                    biodataFields += generateMahasiswaFields();
                    $.extend(rules, mahasiswaRules());
                }

                $('#biodata-fields').html(biodataFields);

                // Update validasi
                formValidator.settings.rules = rules;
            });
        });

        function generateAdminFields() {
            return `
                <div class="input-group mb-3">
                    <input type="text" name="nip" class="form-control" placeholder="NIP" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-id-badge"></span></div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="admin_nama" class="form-control" placeholder="Nama" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-user"></span></div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="admin_no_telp" class="form-control" placeholder="No. Telepon" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-phone"></span></div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="admin_email" class="form-control" placeholder="Email SSO" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                    </div>
                </div>`;
        }

        function generateDosenFields() {
            return `
                <div class="input-group mb-3">
                    <input type="text" name="nidn" class="form-control" placeholder="NIDN" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-id-badge"></span></div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="dosen_nama" class="form-control" placeholder="Nama" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-user"></span></div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="dosen_no_telp" class="form-control" placeholder="No. Telepon" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-phone"></span></div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="dosen_email" class="form-control" placeholder="Email SSO" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                    </div>
                </div>`;
        }

        function generateTendikFields() {
            return `
                <div class="input-group mb-3">
                    <input type="text" name="nip" class="form-control" placeholder="NIP" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-id-badge"></span></div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="tendik_nama" class="form-control" placeholder="Nama" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-user"></span></div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="tendik_no_telp" class="form-control" placeholder="No. Telepon" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-phone"></span></div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="tendik_email" class="form-control" placeholder="Email SSO" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                    </div>
                </div>`;
        }

        function generateMahasiswaFields() {
            return `
                <div class="input-group mb-3">
                    <input type="text" name="nim" class="form-control" placeholder="NIM" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-id-badge"></span></div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="mahasiswa_nama" class="form-control" placeholder="Nama" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-user"></span></div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <select name="prodi_id" id="prodi_id" class="form-control" required>
                        <option value="">- Pilih Prodi -</option>
                        @foreach($prodi as $p)
                            <option value="{{ $p->prodi_id }}">{{ $p->prodi_nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group mb-3">
                    <input type="number" name="semester" class="form-control" placeholder="Semester" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-graduation-cap"></span></div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div id="kompetensi-container">
                        <div class="kompetensi-group">
                            <h6 class="d-flex justify-content-between align-items-center">
                                <b>Kompetensi<b>
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
                </div>`;
        }

        $(document).on('click', '#add-kompetensi', function () {
            const kompetensiField = `
                <div class="kompetensi-group mb-2">
                            <div class="kompetensi-group">
                            <h6 class="d-flex justify-content-between align-items-center">
                                <b>Kompetensi<b> 
                                <button type="button" class="btn btn-sm btn-danger remove-kompetensi ml-2">×</button>
                            </h6>
                    <select name="kompetensi_id[]" class="form-control kompetensi-select" required>
                        <option value="">- Pilih Kompetensi -</option>
                        @foreach ($kompetensi as $k)
                            <option value="{{ $k->kompetensi_id }}">{{ $k->kompetensi_nama }}</option>
                        @endforeach
                    </select>
                </div>`;
            $('#kompetensi-container').append(kompetensiField);
        });

        // Fungsi untuk menghapus kompetensi
        $(document).on('click', '.remove-kompetensi', function () {
            $(this).closest('.kompetensi-group').remove();
        });

        function adminRules() {
            return {
                nip: { required: true, maxlength: 20 },
                admin_nama: { required: true, maxlength: 100 },
                admin_no_telp: { required: true, maxlength: 15 }
            };
        }

        function dosenRules() {
            return {
                nidn: { required: true, maxlength: 20 },
                dosen_nama: { required: true, maxlength: 100 },
                dosen_no_telp: { required: true, maxlength: 15 }
            };
        }

        function tendikRules() {
            return {
                nip: { required: true, maxlength: 20 },
                tendik_nama: { required: true, maxlength: 100 },
                tendik_no_telp: { required: true, maxlength: 15 }
            };
        }

        function mahasiswaRules() {
            return {
                nim: { required: true, maxlength: 20 },
                mahasiswa_nama: { required: true, maxlength: 100 },
                prodi_id: { required: true, number: true },
                semester: { required: true, number: true, max: 8 },
                kompetensi_id: { required: true, number: true },
            };
        }
    </script>
</body>

</html>
