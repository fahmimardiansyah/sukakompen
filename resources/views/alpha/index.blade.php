@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <!-- Hero Section -->
        <div class="hero">
            <h1>Alpa Mahasiswa</h1>
        </div>
        <div class="notif">
            <h2>Tabel Alpa Mahasiswa</h2>
            <button onclick="modalAction('{{ url('/supplier/import') }}')" class="btn btn-info btn-sm">Import Data</button>
        </div>

        <div class="table-alpa">
            <table>
                <thead>
                    <tr>
                        <th>Nama Mahasiswa</th>
                        <th>Jam Kompen</th>
                        <th>Jumlah Alpa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mahasiswa as $data)
                        <tr>
                            <td>{{ $data['nama'] }}</td>
                            <td>{{ $data['jam_kompen'] }}</td>
                            <td>{{ $data['jumlah_alpa'] }}</td>
                            <td><button type="submit" class="btn btn-primary">Cetak</button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
