@extends('layouts.template')
@section('content')
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
    <div class="container rounded bg-white border">
        <div class="row" id="profile">
            <div class="col-md-4 border-right">
                <div class="p-3 py-5">
                    <div class="d-flex flex-column align-items-center text-center p-3 ">
                        @if ($user->image !== null)
                            <img class="rounded-circle mt-3 mb-2" width="250px" src="{{ url($user->image) }}">
                        @else
                            <i class="fa fa-user-circle" style="font-size: 120px;"></i>
                        @endif
                    </div>
                    <div onclick="modalAction('{{ url('/profilemhs/' . $user->user_id . '/edit_foto') }}')" class="mt-4 text-center">
                        <button class="btn btn-primary profile-button" type="button">Edit Foto</button>
                    </div>
                </div>
            </div>
            <div class="col-md-8 border-right">
                <div class="p-3 py-4">
                    <div class="d-flex align-items-center">
                        <h4 class="text-right">Profile Settings</h4>
                    </div>
                    <div class="row mt-3">
                        <table class="table table-bordered table-striped table-hover table-sm">
                            <tr>
                                <th style="width: 20%">NIM</th>
                                <td>{{ $mahasiswa->nim ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Nama</th>
                                <td>{{ $mahasiswa->mahasiswa_nama ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Jumlah Alpa</th>
                                <td>{{ $mahasiswa->jumlah_alpa ?? '0' }} Jam</td>
                            </tr>
                            <tr>
                                <th>Prodi</th>
                                <td>{{ $mahasiswa->prodi->prodi_nama ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Kompetensi</th>
                                <td>
                                    @foreach ($kompetensi as $data)
                                        <li>{{ $data->kompetensi->kompetensi_nama }}</li>
                                    @endforeach    
                                </td>
                            </tr>
                            <tr>
                                <th>Semester</th>
                                <td>{{ $mahasiswa->semester ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="mt-3 text-center">
                        <button onclick="modalAction('{{ url('/profilemhs/' . $user->user_id . '/edit_username') }}')" class="btn btn-primary profile-button">Edit Username</button>
                        <button onclick="modalAction('{{ url('/profilemhs/' . $user->user_id . '/edit_profile') }}')" class="btn btn-primary profile-button">Edit Profile</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">

            </div>
        </div>
    </div>
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
    </script>
@endpush