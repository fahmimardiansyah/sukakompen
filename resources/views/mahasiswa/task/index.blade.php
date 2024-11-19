@extends('layouts.template')

@section('content')

<div class="card card-outline card-primary">
    <!-- Hero Section -->
    <div class="hero">
        <h1>Tugas</h1>
    </div>

    <!-- Search Bar -->
    <div class="search-bars">
        <div class="filter">
            <i class="fas fa-filter"></i>
            <select>
                <option>Search by Jenis</option>
            </select>
        </div>
        <div class="search-input">
            <input type="text" placeholder="Search by Name" />
        </div>
    </div>

    <div class="notif">
        <h2>Tugas</h2>
    </div>

    <!-- Recommended Tasks Section -->
    <div class="task-grid">
        @foreach ($tugas as $item)
            <div class="task-card">
                <div class="card-header">
                    <span class="task-category">{{ $item->jenis->jenis_nama }}</span>
                </div>
                <div class="card-body">
                    <img src="{{ asset('img/card.png') }}" alt="Tugas" class="task-image">
                    <h3>{{ $item->tugas_nama }}</h3>
                    <p>{{ $item->tugas_deskripsi }}</p>
                </div>
                <div class="card-footer">
                    <a href="{{ url('/tugas/detail/' . $item->id) }}" class="btn">Buka</a>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
