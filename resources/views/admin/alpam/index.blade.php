@extends('layouts.template')

@section('content')

<div class="card card-outline card-primary">
    <!-- Hero Section -->
    <div class="hero">
        <h1>Alpa Mahasiswa</h1>
    </div>
    <div class="notif-title">
        <h2>Tabel Alpa Mahasiswa</h2>
        <div class="alpa-button">
            <button onclick="modalAction('{{ url('/alpam/import') }}')" class="btn btn-warning" id="importButton">Import</button>
            <a href="{{ url('/alpam/export_pdf') }}" class="btn btn-success"><i class="fa fa-file-pdf"></i> Export Data</a>
        </div>
    </div>

    <div class="table-alpa">
        <table>
            <thead>
                <tr>
                    <th>NIM Mahasiswa</th>
                    <th>Nama Mahasiswa</th>
                    <th>Jam Kompen</th>
                    <th>Jumlah Alpa</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mahasiswa as $data)
                <tr>
                    <td>{{ $data->mahasiswa_alpa_nim }}</td>
                    <td>{{ $data->mahasiswa_alpa_nama }}</td>
                    <td>{{ $data->jam_kompen}} Jam</td>
                    <td>{{ $data->jam_alpa }} Jam</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false" data-width="75%"></div>

@endsection

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }
    </script>
@endpush
