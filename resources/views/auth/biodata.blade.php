<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biodata Pengguna</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('register.css') }}">
</head>

<body class="hold-transition login-page">
<div class="login-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="{{ url('/') }}" class="h1"><b>Admin</b>LTE</a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Lengkapi Biodata Anda</p>
            <form action="{{ route('biodata.save') }}" method="POST" id="form-biodata">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user_id }}">
                <input type="hidden" name="level_id" value="{{ $level_id }}">

                <!-- Dinamis berdasarkan Level -->
                @if($level_id == 1) <!-- Admin -->
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
                        <input type="text" name="admin_no_telp" class="form-control" placeholder="No.Telepon" required>
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-user"></span></div>
                        </div>
                    </div>
                @elseif($level_id == 2) <!-- Dosen -->
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
                        <input type="text" name="dosen_no_telp" class="form-control" placeholder="No.Telepon" required>
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-user"></span></div>
                        </div>
                    </div>
                @elseif($level_id == 3) <!-- Tendik -->
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
                        <input type="text" name="tendik_no_telp" class="form-control" placeholder="No.Telepon" required>
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-user"></span></div>
                        </div>
                    </div>
                @elseif($level_id == 4) <!-- Mahasiswa -->
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
                        <input type="text" name="prodi" class="form-control" placeholder="Program Studi" required>
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-book"></span></div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="number" name="semester" class="form-control" placeholder="Semester" required>
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-graduation-cap"></span></div>
                        </div>
                    </div>
                @endif

                <div class="row">
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block" id="btn-submit">Selesai</button>
                    </div>
                </div>
                
                <script>
                    document.getElementById("form-register").addEventListener("submit", function(e) {
                        e.preventDefault(); // Mencegah form agar tidak refresh halaman
                
                        let form = this;
                
                        $.ajax({
                            url: form.action,
                            type: form.method,
                            data: $(form).serialize(),
                            success: function(response) {
                                if (response.status) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Biodata Berhasil Disimpan',
                                        text: 'Anda akan diarahkan ke halaman login.',
                                        timer: 3000,
                                        showConfirmButton: false
                                    }).then(function() {
                                        window.location.href = '{{ url("login") }}'; // Redirect ke login
                                    });
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
                    });
                </script>
            </form>
        </div>
    </div>
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

   <script>
       $.ajaxSetup({
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
       });

       $(document).ready(function() {
           $("#form-register").validate({
               rules: { 
                   level_id: {required: true, number: true}, 
                   username: {required: true, minlength: 4, maxlength: 20}, 
                   nama: {required: true, minlength: 3, maxlength: 100}, 
                   password: {required: true, minlength: 5, maxlength: 20} 
               }, 
               submitHandler: function(form) { // ketika valid, maka bagian yg akan dijalankan 
                   $.ajax({
                       url: form.action,
                       type: form.method,
                       data: $(form).serialize(),
                       success: function(response) {
                           if (response.status) { // jika sukses 
                               Swal.fire({
                                   icon: 'success',
                                   title: 'Berhasil',
                                   text: response.message,
                               }).then(function() {
                                   window.location = response.redirect;
                               });
                           } else { // jika error 
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
                   element.closest('.input-group').append(error);
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
</body>

</html>