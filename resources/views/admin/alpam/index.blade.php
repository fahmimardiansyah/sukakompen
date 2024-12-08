@extends('layouts.template')

@section('content')

<div class="card card-outline card-primary">
    <!-- Hero Section -->
    <div class="hero">
        <h1>Alpa Mahasiswa</h1>
    </div>
    <div class="notif-title">
        <h2>Tabel Alpa Mahasiswa</h2>
        <button class="btn btn-success" id="importButton">Import</button>
    </div>

    <div class="table-alpa">
        <table>
            <thead>
                <tr>
                    <th>NIM Mahasiswa</th>
                    <th>Nama Mahasiswa</th>
                    <th>Jam Kompen</th>
                    <th>Jumlah Alpa</th>
                    <!-- <th>Aksi</th> -->
                </tr>
            </thead>
            <tbody>
                @foreach($mahasiswa as $data)
                <tr>
                    <td>{{ $data->mahasiswa_alpa_nim }}</td>
                    <td>{{ $data->mahasiswa_alpa_nama }}</td>
                    @if($data->approval->status === 1)
                        <td>{{ $data->approval->tugas->tugas_jam_kompen ?? '0' }} Jam</td>
                    @else
                        <td>0 Jam</td>
                    @endif
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
