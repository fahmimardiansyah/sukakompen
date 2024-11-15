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
                @for ($i = 0; $i < 8; $i++)
                    <div class="task-card">
                        <div class="card-header">
                            <span class="task-category">Teknis</span>
                        </div>
                        <div class="card-body">
                            <img src="{{ asset('img/card.png') }}" alt="Tugas" class="task-image">
                            <h3>Arsip Absensi</h3>
                            <p>Mengarsip ketidakhadiran dalam satu jam untuk menghindari denda di satu jurusan.</p>
                        </div>
                        <div class="card-footer">
                            <a href="{{ url('/detail') }}" class="btn">Buka</a>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </section>
</div>
</div>
@endsection