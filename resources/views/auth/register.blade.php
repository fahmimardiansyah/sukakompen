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
    <link rel="stylesheet" href="{{ asset(path: 'login.css') }}">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="modal fade" id="verificationModal" tabindex="-1" role="dialog" aria-labelledby="verificationModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="verificationModalLabel">Verifikasi Kode</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p id="modal-verification-content">Masukkan kode verifikasi yang telah dikirim ke email Anda.</p>
                        <div class="form-group">
                            <!-- Single input for the verification code -->
                            <input type="text" id="verification_code" class="form-control" maxlength="6" placeholder="Masukkan kode verifikasi" required>
                        </div>
                        <small id="verificationError" class="text-danger d-none">Kode verifikasi salah. Silakan coba lagi.</small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-info btn-block" id="submitVerification">Verifikasi</button>
                    </div>
                </div>
            </div>
        </div>
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
                    <p class="login-box-msg">Sudah Punya Akun? <a href="{{ url('/login') }}">Sign in</a></p>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>

    <div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false" data-width="75%"></div>

    <meta name="csrf-token" content="{{ csrf_token() }}">

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
        .verification-digit {
            width: 50px;
            height: 50px;
            text-align: center;
            font-size: 18px;
            border: 2px dashed #ccc;
            margin-right: 5px;
        }

        .verification-digit:focus {
            border-color: #007bff;
        }
        
        select {
            color: #535353; 
        }
    
        option {
            color: #535353; 
        }

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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        $(document).ready(function () {
            // Form Validator
            const formValidator = $("#form-register").validate({
                rules: {
                    level_id: { required: true, number: true },
                },
                submitHandler: function (form) {
                    // Pendaftaran AJAX
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function (response) {
                            if (response.status) {
                                if (response.modal) {
                                    // Tampilkan modal untuk verifikasi
                                    $('#verificationModalLabel').text(response.modal.title);
                                    $('#modal-verification-content').text(response.modal.content);
                                    $('#verificationModal').modal('show');
                                    
                                    // Simpan URL tindakan (action_url) ke tombol submit
                                    $('#submitVerification').data('action-url', response.modal.action_url);
                                } else {
                                    window.location.href = response.redirect;
                                }
                            } else {
                                console.error('Validasi gagal:', response.msgField);
                            }
                        },
                        error: function (xhr) {
                            console.error('Terjadi kesalahan:', xhr.responseText);
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

            // Verifikasi Kode
            $('#submitVerification').on('click', function () {
                const verificationCode = $('#verification_code').val().trim();

                if (verificationCode.length === 6) {
                    $.ajax({
                        url: '/verifikasi',  // Remove user_id from the URL
                        type: 'POST',
                        data: {
                            verification_code: verificationCode,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (response.status) {
                                alert('Verifikasi berhasil!');
                                window.location.href = "{{ url('/login') }}";
                            } else {
                                $('#verificationError').removeClass('d-none');
                            }
                        },
                        error: function (xhr) {
                            console.error('Terjadi kesalahan:', xhr.responseText);
                        }
                    });
                } else {
                    $('#verificationError').removeClass('d-none').text('Silakan masukkan kode verifikasi lengkap.');
                }
            });

            // Level ID Change Event
            $('#level_id').change(function () {
                const levelId = $(this).val();
                let biodataFields = '';
                const rules = {};

                if (levelId == 2) { // Dosen
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

        function generateDosenFields() {
            return `
                <div class="input-group mb-3">
                    <input type="text" id="username" name="username" class="form-control" placeholder="Email SSO">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    <small id="error-username" class="error-text text-danger"></small>
                </div>
                <div class="input-group mb-3">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <small id="error-password" class="error-text text-danger"></small>
                </div>`;
        }

        function generateTendikFields() {
            return `
                <div class="input-group mb-3">
                    <input type="text" id="username" name="username" class="form-control" placeholder="Email SSO">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    <small id="error-username" class="error-text text-danger"></small>
                </div>
                <div class="input-group mb-3">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <small id="error-password" class="error-text text-danger"></small>
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
