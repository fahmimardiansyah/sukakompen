@extends('layouts.template')

@section('content')

<style>
    .card {
        margin: 20px;
        padding: 20px;
        background-color: #fff;
        text-align: center;
    }
    .center {
        display: flex; /* Menggunakan Flexbox */
        justify-content: center; /* Teks/elemen berada di tengah horizontal */
        align-items: center; /* Teks/elemen berada di tengah vertikal */
        width: 100%; /* Lebar elemen mengikuti container */
    }
    .total-alpa {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 20px;
        margin-bottom: 20px;
        padding: 15px;
        border: 2px solid #141450; /* Border dengan warna biru */
        border-radius: 50px; /* Membuat sudut kotak menjadi melengkung */
        font-size: 1.5rem;
        font-weight: bold;
        color: #da0000;
    }
    .total-alpa i {
        margin-right: 10px;
        font-size: 2rem;
        color: #da0000;
    }
</style>

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
                @foreach($akumulasi as $data)
                <tr>
                    <td>Semester {{ $data->semester }}</td>
                    <td>{{ $data->jumlah_alpa }} Jam</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="center">
        <div class="total-alpa">
            <i class="fas fa-clock"></i>
            <span>Total Jumlah Alpa: XYZ Jam</span> <!-- Ganti XYZ dengan jumlah total alpa -->
        </div>
    </div>

</div>

@endsection
