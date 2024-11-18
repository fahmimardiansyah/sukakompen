@extends('layouts.template')

@section('content')


<div class="card card-outline card-primary">
<!-- Hero Section -->
<div class="hero">
    <h1>Alpa Mahasiswa</h1>
</div>
<div class="notif">
    <h2>Tabel Akumulasi</h2>
</div>

<div class="table-alpa">
    <table>
        <thead>
            <tr>
                <th>Semester</th>
                <th>Jumlah Alpa</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mahasiswa as $data)
            <tr>
                <td>{{ $data['semester'] }}</td>
                <td>{{ $data['jumlah_alpa'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>

@endsection
