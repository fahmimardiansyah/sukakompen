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
            @foreach($history as $data)
                @if($data->status === 1)
                    <tr>
                        <td>{{ optional($data->tugas)->tugas_nama }}</td>
                        <td>{{ $data->status ? 'Selesai' : 'Gagal dikerjakan' }}</td>
                        <td> <button class="btn-cetak" onclick="window.location.href='{{ url('/' . $data->approval_id . '/export_pdf') }}'">Cetak</button></td>               
                    </tr>
                @elseif($data->status === 0)
                    <tr>
                        <td>{{ optional($data->tugas)->tugas_nama }}</td>
                        <td>{{ $data->status ? 'Selesai' : 'Gagal dikerjakan' }}</td>             
                    </tr>
                @endif 
            @endforeach
        </tbody>
    </table>
</div>
</div>

@endsection
