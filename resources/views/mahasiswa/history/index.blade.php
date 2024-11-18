@extends('layouts.template')

@section('content')


<div class="card card-outline card-primary">
<!-- Hero Section -->
<div class="hero">
    <h2>Alpa Mahasiswa</h2>
</div>
<div class="notif">
    <h2>Tabel History</h2>
</div>

<div class="table-alpa">
    <table>
        <thead>
            <tr>
                <th>Tugas</th>
                <th>Status</th>
                <th>Cetak</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mahasiswa as $data)
            <tr>
                <td>{{ $data['tugas'] }}</td>
                <td>{{ $data['status'] }}</td>
                <td>
                    <button class="btn-cetak" onclick="window.location.href='/cetak/{{ $data['tugas'] }}'">Cetak</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>

@endsection
