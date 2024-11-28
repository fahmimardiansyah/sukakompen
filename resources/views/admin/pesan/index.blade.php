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

    {{-- Pesan Cards --}}
    <div class="pesan-card" style="background: linear-gradient(135deg, #ffffff, #ffea2f);">
        <img alt="Profile picture of a person" height="50" src="https://storage.googleapis.com/a1aa/image/kTvDbmpMRv4cNFHDbuO8uVSwPlaijrMcHQzg7g4BiwmKzp7E.jpg" width="50"/>
        <div class="pesan-info">
            <h3>Hasan Basyri</h3>
            <p>Request pekerjaan membuat PPT.</p>
        </div>
        <button onclick="modalAction('{{ url('/pesan/apply') }}')" class="cek">Cek</button>
    </div>

    <div class="pesan-card" style="background: linear-gradient(135deg, #ffffff, #3abf15);">
        <img alt="Profile picture of a person" height="50" src="https://storage.googleapis.com/a1aa/image/kTvDbmpMRv4cNFHDbuO8uVSwPlaijrMcHQzg7g4BiwmKzp7E.jpg" width="50"/>
        <div class="pesan-info">
            <h3>Fahmi Mardiansyah</h3>
            <p>Mengumpulkan pekerjaan.</p>
        </div>
        <button class="cek-button" onclick="openModal('Fahmi Mardiansyah', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.')">Cek</button>
    </div>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false" data-width="75%"></div>
</section>
</div>
@endsection

@section('styles')
<style>
    
    .cek-button {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
    }
    
    .cek-button:hover {
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
        border-radius: 5px;
        width: 300px;
        position: relative;
    }

    .close {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 20px;
        cursor: pointer;
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
