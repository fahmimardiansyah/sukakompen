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
            @foreach($mahasiswa as $data )
            <tr>
                <td>{{ $data->mahasiswa->mahasiswa_nama }}</td>
                <td>{{ $data->mahasiswa->nim }}</td>
                <td>{{ $data->tugas->tugas_nama }}</td>
                <td>{{ $data->tugas->tugas_jam_kompen }} Jam</td>
                @if($data->status === 1)
                    <td>Selesai (Tugas Diterima)</td>
                @elseif($data->status === 0)
                    <td>Tugas Ditolak</td>
                @elseif($data->status === null)
                    <td>Selesai (Menunggu persetujuan)</td>
                @endif
            </tr>
            @endforeach

            @foreach($progress as $item )
            <tr>
                @if($item->status === 0)
                    <td>{{ $item->mahasiswa->mahasiswa_nama }}</td>
                    <td>{{ $item->mahasiswa->nim }}</td>
                    <td>{{ $item->tugas->tugas_nama }}</td>
                    <td>{{ $item->tugas->tugas_jam_kompen }} Jam</td>
                    <td>Belum Selesai (Progress)</td>
                @endif
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
