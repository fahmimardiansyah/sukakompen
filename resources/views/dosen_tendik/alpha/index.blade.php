@extends('layouts.template')

@section('content')

<div class="card card-outline card-primary">
    <!-- Hero Section -->
    <div class="hero">
        <h1>Alpa Mahasiswa</h1>
    </div>
    <div class="notif">
        <h2>Tabel Alpa Mahasiswa</h2>
    </div>

    <div class="table-alpa">
        <table>
            <thead>
                <tr>
                    <th>NIM Mahasiswa</th>
                    <th>Nama Mahasiswa</th>
                    <th>Jam Kompen</th>
                    <th>Jumlah Alpa</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mahasiswa as $data)
                <tr>
                    <td>{{ $data->mahasiswa_alpa_nim }}</td>
                    <td>{{ $data->mahasiswa_alpa_nama }}</td>
                    <td>{{ $data->jam_kompen }} Jam</td>
                    <td>{{ $data->jam_alpa }} Jam</td>
                    {{-- <td>
                        <form action="{{ route('cetak.alpa', ['nim' => $data['mahasiswa_alpa_nim']]) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm">Cetak</button>
                        </form>
                    </td> --}}
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
