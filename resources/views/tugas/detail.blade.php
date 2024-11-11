@extends('layouts.template')

@section('content')
<div class="deskripsi-container">
    <div class="deskripsi-cont">
        <div class="deskripsi-image">
            <img src="{{ asset($description->image ?? 'img/penelitian.jpeg') }}" alt="Deskripsi Image">
        </div>
        <div class="deskripsi-content">
            <h2>{{ $description->tugas_nama }}</h2>
            <div class="deskripsi-tags">
                <div class="tag">
                    <span class="tag {{ $description->tugas_tipe }}">{{ ucfirst($description->tugas_tipe) }}</span>
                    <span class="tag {{ $description->jenis_id }}">{{ ucfirst($description->jenis_nama) }}</span>
                    <span class="tag {{ $description->kompetensi_id }}">{{ ucfirst($description->kompetensi_kode) }}</span>
                </div>
            </div>
            <p class="deskripsi-description">
                {{ $description->tugas_deskripsi }}
            </p>
            <div class="deskripsi-details">
                <div class="deskripsi-time">
                    <span><i class="fas fa-clock"></i> {{ $description->created_at->format('H:i A') }}</span>
                    <span><i class="fas fa-calendar-alt"></i> {{ $description->created_at->format('m/d/Y') }}</span>
                </div>
                <div class="deskripsi-duration">
                    <span><i class="fas fa-arrow-down"></i> Kuota: {{ $description->tugas_kuota }}</span>
                    <span>Jam Kompen: {{ $description->tugas_jam_kompen }}</span>
                    <span>Kompetensi ID: {{ $description->kompetensi_id }}</span>
                </div>
                
            </div>
            <a href="{{ url('tugas') }}" class="request-button">Back to Tugas List</a>
        </div>
    </div>
</div>
@endsection
