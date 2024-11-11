@extends('layouts.template')

@section('content')

<!-- Hero Section -->
<div class="hero">
    <h1>Alpa Mahasiswa</h1>
</div>

<div class="table-alpa">
    <h2>Tabel Alpa Mahasiswa</h2>
    <table>
        <thead>
            <tr>
                <th>Nama Mahasiswa</th>
                <th>Jam Kompen</th>
                <th>Jumlah Alpa</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mahasiswa as $data)
            <tr>
                <td>{{ $data['nama'] }}</td>
                <td>{{ $data['jam_kompen'] }}</td>
                <td>{{ $data['jumlah_alpa'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
