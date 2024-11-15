@extends('layouts.template')

@section('content')

<div class="hero">
    <h1>Alpa Mahasiswa</h1>
</div>

<div class="table-alpa">
    <h2>Tabel Alpa Mahasiswa</h2>
    <table>
        <thead>
            <tr>
                <th>Nim Mahasiswa</th>
                <th>Nama Mahasiswa</th>
                <th>Jam Kompen</th>
                <th>Jumlah Alpa</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mahasiswa as $data)
            <tr>
                <td>{{ $data['mahasiswa_alpa_nim'] }}</td>
                <td>{{ $data['mahasiswa_alpa_nama'] }}</td>
                <td>{{ $data['progress_id'] }}</td>
                <td>{{ $data['jam_alpa'] }} Jam</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
