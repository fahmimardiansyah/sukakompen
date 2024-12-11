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
                    <i class="fas fa-user-circle" style="font-size: 50px;"></i>
                    <div class="text">
                        <h3>{{ $data->pengguna->dosen_nama ?? $data->pengguna->tendik_nama ?? $data->pengguna->admin_nama ?? 'N/A'}}</h3>
                        <p>Apply {{ $data->tugas->tugas_nama }} diterima.</p>
                        <p>Waktu dibuat: {{ $data->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            @elseif($data->apply_status === false && $data->pengguna)
                <div class="notification" style="background: linear-gradient(135deg, #ffffff, #ec3939);">
                    <i class="fas fa-user-circle" style="font-size: 50px;"></i>
                    <div class="text">
                        <h3>{{ $data->pengguna->dosen_nama ?? $data->pengguna->tendik_nama ?? $data->pengguna->admin_nama ?? 'N/A'}}</h3>
                        <p>Apply {{ $data->tugas->tugas_nama }} ditolak.</p>
                        <p>Waktu dibuat: {{ $data->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            @endif
        @endforeach

        @foreach($approval as $data)
            @if($data->status === 1 && $data->pengguna)
                <div class="notification" style="background: linear-gradient(135deg, #ffffff, #3abf15);">
                    <img alt="Profile picture of {{ $data->pengguna->dosen_nama ?? $data->pengguna->tendik_nama ?? $data->pengguna->admin_nama }}" height="50" src="img/usericon.png" width="50"/>
                    <div class="text">
                        <h3>{{ $data->pengguna->dosen_nama ?? $data->pengguna->tendik_nama ?? $data->pengguna->admin_nama ?? 'N/A'}}</h3>
                        <p>Pekerjaan {{ $data->tugas->tugas_nama }} selesai, diterima.</p>
                        <p>Waktu dibuat: {{ $data->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            @elseif($data->status === 0 && $data->pengguna)
                <div class="notification" style="background: linear-gradient(135deg, #ffffff, #ec3939);">
                    <img alt="Profile picture of {{ $data->pengguna->dosen_nama ?? $data->pengguna->tendik_nama ?? $data->pengguna->admin_nama }}" height="50" src="img/usericon.png" width="50"/>
                    <div class="text">
                        <h3>{{ $data->pengguna->dosen_nama ?? $data->pengguna->tendik_nama ?? $data->pengguna->admin_nama ?? 'N/A'}}</h3>
                        <p>Pekerjaan {{ $data->tugas->tugas_nama }} selesai, ditolak.</p>
                        <p>Waktu dibuat: {{ $data->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            @endif
        @endforeach

        @foreach($progress as $item)
            @if($item->status === false && $item->pengguna)
                <div class="notification" style="background: linear-gradient(135deg, #ffffff, #ec3939);">
                    <i class="fas fa-user-circle" style="font-size: 50px;"></i>
                    <div class="text">
                        <h3>{{ $item->pengguna->dosen_nama ?? $item->pengguna->tendik_nama ?? $item->pengguna->admin_nama ?? 'N/A'}}</h3>
                        <p>Tugas Melewati tenggat ( {{ $item->tugas->tugas_tenggat->format('d M Y, H:i') ?? 'error' }} ).</p>
                        <p>Waktu dibuat: {{ $item->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            @endif
        @endforeach
    </section>
</div>
</div>
@endsection

@section('styles')
<style>

Button Cek */
.cek {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 15px;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.cek:hover {
    background-color: #0056b3;
}

/* Modal Styles */
.modal {
    display: flex;
    justify-content: center;
    align-items: center;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1000;
}

.modal-content {
    background-color: white;
    padding: 20px; 
    border-radius: 20px; 
    width: 250px; 
    text-align: center;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); 
}

.modal-body h4 {
    font-size: 18px;
    font-weight: bold;
}

.modal-body h2 {
    font-size: 24px;
    margin: 10px 0;
}

button {
    width: 90px;
    border-radius: 15px;
    margin: 10px 5px;
}

#btn-tolak {
    background-color: #d32f2f;
    color: white;
    border: none;
}

#btn-tolak:hover {
    background-color: #b71c1c;
}

#btn-terima {
    background-color: #388e3c;
    color: white;
    border: none;
}

#btn-terima:hover {
    background-color: #2e7d32;
}

</style>
@endsection

@push('js')
<script>
    function modalAction(url = '') {
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
        });
    }
</script>
@endpush
