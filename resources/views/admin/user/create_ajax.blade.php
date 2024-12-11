<form action="{{ url('/user/ajax') }}" method="POST" id="form-tambah"> 
    @csrf 
    <div id="modal-master" class="modal-dialog modal-lg" role="document"> 
        <div class="modal-content"> 
            <div class="modal-header"> 
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data User</h5> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span 
                aria-hidden="true">&times;</span></button> 
            </div> 
            <div class="modal-body"> 
                <div class="form-group"> 
                    <label>Level Pengguna</label> 
                    <p class="form-control">Admin</p>
                    <small id="error-level_id" class="error-text form-text text-danger"></small> 
                </div> 
                <div class="form-group"> 
                    <label>Username</label> 
                    <input value="" type="text" name="username" id="username" class="form-control" 
                    required> 
                    <small id="error-username" class="error-text form-text text-danger"></small> 
                </div>
                <div class="form-group"> 
                    <label>Password</label> 
                    <input value="" type="password" name="password" id="password" class="form-control" required> 
                    <small id="error-password" class="error-text form-text text-danger"></small> 
                </div>
                <div class="form-group">
                    <label>NIP</label>
                    <input type="text" name="nip" class="form-control" required>
                    <div class="input-group-append">
                    </div>
                </div>
                <div class="form-group">
                    <label>Nama</label> 
                    <input type="text" name="admin_nama" class="form-control" required>
                    <div class="input-group-append">
                    </div>
                </div>
                <div class="form-group">
                    <label>No.Telepon</label> 
                    <input type="text" name="admin_no_telp" class="form-control" required>
                    <div class="input-group-append">
                    </div>
                </div>
                <div class="form-group">
                    <label>Email SSO</label>
                    <input type="text" name="admin_email" class="form-control" required>
                    <div class="input-group-append">
                    </div>
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
        $("#form-tambah").validate({ 
            rules: { 
                level_id: {required: true, number: true}, 
                username: {required: true, minlength: 3, maxlength: 20}, 
                password: {required: true, minlength: 5, maxlength: 20}
                nip: { required: true, maxlength: 20 },
                admin_nama: { required: true, maxlength: 100 },
                admin_no_telp: { required: true, maxlength: 15 }
            }, 
            submitHandler: function(form) { 
                $.ajax({ 
                    url: form.action, 
                    type: form.method, 
                    data: $(form).serialize(), 
                    success: function(response) { 
                        if(response.status){ 
                            $('#myModal').modal('hide'); 
                            Swal.fire({ 
                                icon: 'success', 
                                title: 'Berhasil', 
                                text: response.message 
                            }); 
                            dataUser.ajax.reload(); 
                        }else{ 
                            $('.error-text').text(''); 
                            $.each(response.msgField, function(prefix, val) { 
                                $('#error-'+prefix).text(val[0]); 
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
            errorPlacement: function (error, element) { 
                error.addClass('invalid-feedback'); 
                element.closest('.form-group').append(error); 
            }, 
            highlight: function (element, errorClass, validClass) { 
                $(element).addClass('is-invalid'); 
            }, 
            unhighlight: function (element, errorClass, validClass) { 
                $(element).removeClass('is-invalid'); 
            } 
        }); 
    }); 
</script>