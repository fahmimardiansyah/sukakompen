@extends('layouts.template')

@section('content')

<div class="card card-outline card-primary">
<div class="hero">
    <h1>
     Inbox
    </h1>
   </div>
   <div class="notif">
    <h2>
     Inbox
    </h2>
   </div>

    <section class="recommended-tasks">
        @foreach($apply as $data)
            @if($data->apply_status === true && $data->pengguna)
                <div class="notification" style="background: linear-gradient(135deg, #ffffff, #ffea2f);">
                    <img alt="Profile picture of {{ $data->pengguna->dosen_nama ?? $data->pengguna->tendik_nama ?? $data->pengguna->admin_nama }}" height="50" src="https://storage.googleapis.com/a1aa/image/dVqQymORCvozEpawKsIaEH2CXnmO8Ucevf3CYZJtz1ujHsrTA.jpg" width="50"/>
                    <div class="text">
                        <h3>{{ $data->pengguna->dosen_nama ?? $data->pengguna->tendik_nama ?? $data->pengguna->admin_nama ?? 'N/A'}}</h3>
                        <p>Apply {{ $data->tugas->tugas_nama }} diterima.</p>
                    </div>
                </div>
            @elseif($data->apply_status === false && $data->pengguna)
                <div class="notification" style="background: linear-gradient(135deg, #ffffff, #ec3939);">
                    <img alt="Profile picture of Eka Larasati" height="50" src="https://storage.googleapis.com/a1aa/image/XjWoTn7E7GpbIdRrxfNChRTrrBZmGhhqjx7yABH5yqnyD21JA.jpg" width="50"/>
                    <div class="text">
                        <h3>{{ $data->pengguna->dosen_nama ?? $data->pengguna->tendik_nama ?? $data->pengguna->admin_nama ?? 'N/A'}}</h3>
                        <p>Apply {{ $data->tugas->tugas_nama }} ditolak.</p>
                    </div>
                </div>
            @endif
        @endforeach

        @foreach($approval as $data)
            @if($data->status === 1 && $data->pengguna)
                <div class="notification" style="background: linear-gradient(135deg, #ffffff, #3abf15);">
                    <img alt="Profile picture of {{ $data->pengguna->dosen_nama ?? $data->pengguna->tendik_nama ?? $data->pengguna->admin_nama }}" height="50" src="https://storage.googleapis.com/a1aa/image/dVqQymORCvozEpawKsIaEH2CXnmO8Ucevf3CYZJtz1ujHsrTA.jpg" width="50"/>
                    <div class="text">
                        <h3>{{ $data->pengguna->dosen_nama ?? $data->pengguna->tendik_nama ?? $data->pengguna->admin_nama ?? 'N/A'}}</h3>
                        <p>Pekerjaan {{ $data->tugas->tugas_nama }} selesai, diterima.</p>
                    </div>
                </div>
            @elseif($data->status === 0 && $data->pengguna)
                <div class="notification" style="background: linear-gradient(135deg, #ffffff, #ec3939);">
                    <img alt="Profile picture of {{ $data->pengguna->dosen_nama ?? $data->pengguna->tendik_nama ?? $data->pengguna->admin_nama }}" height="50" src="https://storage.googleapis.com/a1aa/image/dVqQymORCvozEpawKsIaEH2CXnmO8Ucevf3CYZJtz1ujHsrTA.jpg" width="50"/>
                    <div class="text">
                        <h3>{{ $data->pengguna->dosen_nama ?? $data->pengguna->tendik_nama ?? $data->pengguna->admin_nama ?? 'N/A'}}</h3>
                        <p>Pekerjaan {{ $data->tugas->tugas_nama }} selesai, ditolak.</p>
                    </div>
                </div>
            @endif
        @endforeach
    </section>

</div>
</div>
@endsection
