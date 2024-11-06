@extends('layouts.template')

@section('content')
<div class="welcome-banner">
    <div class="welcome-content">
        <h1>SELAMAT DATANG DI SUKA KOMPEN</h1>
        <p>Mau ngurangin jam alpa kamu? yuk kompenin aja</p>
        <a href="/tugas" class="start-button">Start Now</a>
    </div>
</div>


    <section class="recommended-tasks">
        <h2>Tugas Kompen</h2>
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
                        <a class="btn">Kerjakan</a>
                    </div>
                </div>
            @endfor
        </div>
    </section>
@endsection