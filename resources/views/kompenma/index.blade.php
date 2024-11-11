@extends('layouts.template')

@section('content')

<div class="card card-outline card-primary">
<!-- Hero Section -->
<div class="hero">
    <h1>Kompen Mahasiswa</h1>
</div>

<div class="table-alpa">
    <h2>Tabel Kompen Mahasiswa</h2>
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
                <td>{{ $data['nama'] }}</td>
                <td>{{ $data['NIM'] }}</td>
                <td>{{ $data['tugas_kompen'] }}</td>
                <td>{{ $data['bobot_kompen'] }}</td>
                <td>{{ $data['status'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
@endsection
