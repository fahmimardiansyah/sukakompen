@extends('kompen.template')

@section('content')

<div class="hero">
    <h1>
     Tugas
    </h1>
   </div>
    <section class="recommended-tasks">
        <h2>Rekomendasi Tugas</h2>
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
                        <button class="btn">Kerjakan</button>
                    </div>
                </div>
            @endfor
        </div>
    </section>