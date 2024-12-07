@extends('layouts.template')

@section('content')

<div class="card card-outline card-primary">
<!-- Hero Section -->
<div class="hero">
    <h1>Kompen Mahasiswa</h1>
</div>

<div class="table-alpa">
    <div class="card-header">
        <h2>Tabel Kompen Mahasiswa</h2>
    </div>
    <table>
        <thead>
            <tr>
                <th>Nama Mahasiswa</th>
                <th>NIM</th>
                <th>Tugas Kompen</th>
                <th>Bobot Kompen</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mahasiswa as $data)
            <tr>
                <td>{{ $data->mahasiswa->mahasiswa_nama }}</td>
                <td>{{ $data->mahasiswa->nim }}</td>
                <td>{{ $data->tugas->tugas_nama }}</td>
                <td>{{ $data->tugas->tugas_jam_kompen }}</td>
                <td>{{ $data->status ? 'Selesai' : 'Belum Selesai' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <!-- <div class="card-tools">
        <button onclick="modalAction('{{ url('/supplier/import') }}')" class="btn btn-info btn-sm">Import supplier</button>
    </div> -->
</div>
</div>
@endsection
