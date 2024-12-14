@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
<div class="hero">
    <h1>Pesan</h1>
</div>
<div class="notif">
    <h2>Pesan</h2>
</div>

    <section class="recommended-tasks">
        @foreach($apply as $data)
            @if(is_null($data->apply_status))
                <div class="pesan-card" style="background: linear-gradient(135deg, #ffffff, #ffea2f);">
                    <img alt="Profile picture of a person" height="50" src="img/usericon.png" width="50"/>
                    <div class="pesan-info">
                        <h3>{{ $data->mahasiswa->mahasiswa_nama }}</h3>
                        <p>Apply pekerjaan {{ $data->tugas->tugas_nama }}.</p>
                        <p>Waktu dibuat: {{ $data->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                    <button onclick="modalAction('{{ url('/notif/' . $data->apply_id . '/apply') }}')" class="btn" style="background-color: #ffffff; color:#000000; border: 2px solid #000000; border-radius: 30px; padding: 10px 20px; font-weight:bold">Cek</button>
                </div>
            @endif
        @endforeach

        @foreach($approval as $data)
            @if(is_null($data->status))
                <div class="pesan-card" style="background: linear-gradient(135deg, #ffffff, #3abf15);">
                    <img alt="Profile picture of a person" height="50" src="img/usericon.png" width="50"/>
                    <div class="pesan-info">
                        <h3>{{ $data->mahasiswa->mahasiswa_nama }}</h3>
                        <p>Mengumpulkan pekerjaan {{ $data->tugas->tugas_nama }}.</p>
                        <p>Waktu dibuat: {{ $data->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                    <button onclick="modalAction('{{ url('/notif/' . $data->approval_id . '/tugas') }}')" class="btn" style="background-color: #ffffff; color:#000000; border: 2px solid #000000; border-radius: 30px; padding: 10px 20px; font-weight:bold">Cek</button>
                </div>
            @endif
        @endforeach
        
        @foreach($progress as $data)
            @if($data->status === false || $data->status === 0)
                <div class="pesan-card" style="background: linear-gradient(135deg, #ffffff, #ca1717);">
                    <img alt="Profile picture of a person" height="50" src="img/usericon.png" width="50"/>
                    <div class="pesan-info">
                        <h3>{{ $data->mahasiswa->mahasiswa_nama }}</h3>
                        <p>Tugas melewati tenggat {{ $data->tugas->tugas_tenggat->format('d M Y, H:i') ?? 'N/A' }}.</p>
                        <p>Waktu dibuat: {{ $data->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            @endif
        @endforeach

        <div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false" data-width="75%"></div>
    </section>
</div>
@endsection

@section('styles')
<style>

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
