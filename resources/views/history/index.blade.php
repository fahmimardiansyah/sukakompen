@extends('kompen.template')

@section('content')
<section class="welcome-section">

    <div class="hero">
        <h1>
         History
        </h1>
       </div>
</section>
<div class="akumulasi-container">
    <h1>History Tugas</h1>
    <table class="akumulasi-table">
        <thead>
            <tr>
                <th class="col-tugas">Tugas</th>
                <th class="col-status">Status</th>
                <th class="col-cetak">Form Kompen</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>UI/UX Website</td>
                <td>Selesai</td>
                <td><button class="print-btn">Cetak</button></td>
            </tr>
            <tr>
                <td>Membuat PPT</td>
                <td>Selesai</td>
                <td><button class="print-btn">Cetak</button></td>
            </tr>
            <tr>
                <td>Arsip Nilai</td>
                <td>Selesai</td>
                <td><button class="print-btn">Cetak</button></td>
            </tr>
            <tr>
                <td>Arsip Absensi</td>
                <td>Selesai</td>
                <td><button class="print-btn">Cetak</button></td>
            </tr>
        </tbody>
    </table>
</div>