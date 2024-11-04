@extends('kompen.template')

@section('content')
<div class="welcome-banner">
    <div class="welcome-content">
        <h1>SELAMAT DATANG DI SUKA KOMPEN</h1>
        <p>Mau ngurangin jam alpa kamu? yuk kompenin aja</p>
        <a href="/tugas" class="start-button">Start Now</a>
    </div>
</div>

<div class="background-kat">
    <div class="container-kat">
        <div class="slide">
            <div class="item item1">
                <div class="content">
                    <div class="name">Teknis</div>
                    <div class="desc">Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae, quae sequi eaque incidunt odio aut.</div>
                </div>
            </div>
            <div class="item item2">
                <div class="content">
                    <div class="name">Pengabdian</div>
                    <div class="desc">Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae, quae sequi eaque incidunt odio aut..</div>
                </div>
            </div>
            <div class="item item3">
                <div class="content">
                    <div class="name">Penelitian</div>
                    <div class="desc">Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae, quae sequi eaque incidunt odio aut.</div>
                </div>
            </div>
            <div class="item item4">
                <div class="content">
                    <div class="name">Teknis</div>
                    <div class="desc">Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae, quae sequi eaque incidunt odio aut.</div>
                </div>
            </div>
            <div class="item item5">
                <div class="content">
                    <div class="name">Pengabdian</div>
                    <div class="desc">Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae, quae sequi eaque incidunt odio aut..</div>
                </div>
            </div>
            <div class="item item6">
                <div class="content">
                    <div class="name">Penelitian</div>
                    <div class="desc">Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae, quae sequi eaque incidunt odio aut.</div>
                </div>
            </div>   
    
        </div>
    
        <div class="button">
            <button class="prev"><i class="fas fa-angle-double-left"></i></button>
            <button class="next"><i class="fas fa-angle-double-right"></i></button>
        </div>
    
    </div>
    
    <script src="{{ asset('js/kat.js') }}"></script>
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
                        <a href="{{ route('descriptions.index', ['id' => $i]) }}" class="btn">Kerjakan</a>
                    </div>
                </div>
            @endfor
        </div>
    </section>