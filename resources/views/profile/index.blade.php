@extends('kompen.template')

@section('content')
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
    
    <div class="container rounded bg-white profile-container">
        <div class="row" id="profile">
            <div class="col-md-4">
                <div class="p-3 py-5">
                    <div class="d-flex flex-column justify-content-between align-items-center">
                        <div>
                            @if(session('profile_img_path') || $user->foto)
                                <img class="rounded mt-3 mb-2" width="200px" height="200px" style="object-fit: cover;" 
                                     src="{{ asset(session('profile_img_path') ?? 'image/profile/' . $user->foto) }}">
                            @else
                                <p class="text-muted mt-3 mb-2">Foto tidak tersedia</p>
                            @endif
                            <p class="photo-date">Foto diganti pada: {{ optional($user->updated_at)->format('d-m-Y') }}</p>
                        </div>
                        <div class="mt-3 text-center">
                            <button onclick="modalAction('{{ url('/profile/' . session('user_id') . '/edit_foto') }}')"
                                class="btn btn-primary profile-button">Edit Foto</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-8">
                <div class="p-3 py-4">
                    <div class="d-flex justify-content-center align-items-center">
                        <h4 class="profile-header">Pengaturan Profile</h4>
                    </div>
                    <div class="row mt-3">
                        <table class="table table-bordered table-striped table-hover table-sm">
                            <tr>
                                <th>ID</th>
                                <td>{{ $user->user_id }}</td>
                            </tr>
                            <tr>
                                <th>Level</th>
                                <td>{{ $user->level->level_nama }}</td>
                            </tr>
                            <tr>
                                <th>Username</th>
                                <td>{{ $user->username }}</td>
                            </tr>
                            <tr>
                                <th>Nama</th>
                                <td>{{ $user->nama }}</td>
                            </tr>
                            <tr>
                                <th>Password</th>
                                <td>********</td>
                            </tr>
                        </table>
                    </div>
                    <div class="mt-3 text-center">
                        <button onclick="modalAction('{{ url('/profile/' . session('user_id') . '/edit_ajax') }}')"
                            class="btn btn-primary profile-button">Ubah Profil dan Password</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        :root {
            --primary-color: #5a90f3;
            --secondary-color: #f0f0f0;
            --text-color: #333;
            --hover-color: #ff6347;
            --header-bg-color: linear-gradient(135deg, #5a90f3, #445688);
        }

        body {
            background-color: var(--secondary-color);
            font-family: , sans-serif;
            color: var(--text-color);
        }

        .profile-container {
            border: 2px solid var(--primary-color);
            border-radius: 15px;
            padding: 30px;
            background-color: #fff;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .photo-date {
            color: #6b6b6b;
            font-size: 0.85em;
        }

        .table th {
            background-color: var(--primary-color);
            color: white;
            text-align: center;
        }

        .table td {
            text-align: center;
        }

        .profile-button {
            background-color: var(--primary-color);
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
        }

        .profile-header {
            background: var(--header-bg-color);
            color: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
        }
    </style>
@endpush


@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        var profile;
        $(document).ready(function() {
            profile = $('#profile').on({
                autoWidth: false,
                serverSide: true,
                ajax: {
                    "url": "{{ url('penjualan/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        d.user_id = $('#user_id').val();
                    }
                },
            });
            $('#profile').on('change', function() {
                profile.ajax.reload();
            });
        });
    </script>
@endpush