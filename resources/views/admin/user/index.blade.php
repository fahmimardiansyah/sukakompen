@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/user/importDosen') }}')" class="btn btn-sm mt-1" id="importButton" style="background-color: #1d1f96; color: white;">Import Dosen</button>
                <button onclick="modalAction('{{ url('/user/importTendik') }}')" class="btn btn-sm mt-1" id="importButton" style="background-color: #2795d4; color: white;">Import Tendik</button>
                <button onclick="modalAction('{{ url('/user/importMahasiswa') }}')" class="btn btn-sm mt-1" id="importButton" style="background-color: #ffd000; color: white;">Import Mahasiswa</button>
                
                <button onclick="modalAction('{{ url('user/create_ajax') }}')" class="btn btn-success btn-sm mt-1">Tambah User Admin</button>              
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <!-- Filter Dropdown Removed -->
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="tabs">
                <button class="tab active" onclick="showTab('admin')">Admin</button>
                <button class="tab" onclick="showTab('dosen')">Dosen</button>
                <button class="tab" onclick="showTab('tendik')">Tendik</button>
                <button class="tab" onclick="showTab('mahasiswa')">Mahasiswa</button>
            </div>
            <table class="table table-bordered table-striped table-hover table-sm" id="table_user">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Level Pengguna</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('css')
@endpush

@push('js')
<script>
    function modalAction(url = '') {
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
        });
    }
        
    function showTab(tabName) {
        $('.tab').removeClass('active');
        $('[onclick="showTab(\'' + tabName + '\')"]').addClass('active');

        let levelId = '';
        if (tabName === 'admin') levelId = 1;
        else if (tabName === 'dosen') levelId = 2;
        else if (tabName === 'tendik') levelId = 3;
        else if (tabName === 'mahasiswa') levelId = 4;

        dataUser.ajax.url("{{ url('user/list') }}?level_id=" + levelId).load();
    }

    $(document).ready(function() {
        dataUser = $('#table_user').DataTable({
            serverSide: true,
            ajax: {
                "url": "{{ url('user/list') }}",
                "dataType": "json",
                "type": "POST",
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "username",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "level.level_nama",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "aksi",
                    orderable: false,
                    searchable: false
                },
            ],
            language: {
                search: "Search by username:",
            }
        });

        showTab('admin');
    });
</script>

@endpush