@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="welcome-banner">
            <div class="welcome-content">
                <h1>SELAMAT DATANG DI SUKA KOMPEN</h1>
                <p>Mau ngurangin jam alpa kamu? Yuk kompenin aja!</p>
                <a href="{{ url('/task') }}" class="start-button">Start Now</a>
            </div>
        </div>

        <div class="stats">
            <div>
                <i class="fas fa-user-clock">
                </i>
                <h5>
                    Alpha Saat ini
                </h5>
                <h2>
                    {{ $alpa->jumlah_alpa }} Jam
                </h2>
                <a href="{{ url('/akumulasi') }}">
                    Lihat Selengkapnya
                </a>
            </div>
            <div>
                <i class="fas fa-chart-bar">
                </i>
                <h5>
                   Total Alpha
                </h5>
                <h2>
                   {{ $total->jam_alpa ?? '0' }} Jam
                </h2>
                <a href="{{ url('/akumulasi') }}">
                    Lihat Selengkapnya
                </a>
            </div>
        </div>

        <section class="recommended-tasks">
            @if(!is_null($progress))
            <div class="center-text">
                <h2>✦ Progress ✦</h2>
            </div>
                <div class="task-grid">
                    @foreach ($progress as $item)
                        <div class="task-card">
                            <div class="card-header">
                                <span class="task-category">Task</span>
                            </div>
                            <div class="card-body">
                                <img src="{{ asset('img/card.png') }}" alt="Tugas" class="task-image">
                                <h3>{{ $item->tugas->tugas_nama }}</h3>
                                <p>{{ $item->tugas->tugas_deskripsi }}</p>
                            </div>
                            <div class="card-footer">
                                <a href="{{ url('/task/' . $item->progress_id . '/upload') }}" class="btn">Upload</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        
            <hr>
            <div class="center-text">
                <h2>✦ Tugas Kompen ✦</h2>
            </div>
            <div class="task-grid">
                @foreach ($tugas as $item)
                    <div class="task-card">
                        <div class="card-header">
                            <span class="task-category">Task</span>
                        </div>
                        <div class="card-body">
                            <img src="{{ asset('img/card.png') }}" alt="Tugas" class="task-image">
                            <h3>{{ $item->tugas_nama }}</h3>
                            <p>{{ $item->tugas_deskripsi }}</p>
                        </div>
                        <div class="card-footer">
                            <a href="{{ url('/task/' . $item->tugas_id . '/detail') }}" class="btn">Buka</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
</div>
</div>
<div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false" data-width="75%"></div>



@endsection

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        function showTab(tabName) {
            $('.tab').removeClass('active');
            $('[onclick="showTab(\'' + tabName + '\')"]').addClass('active');

            $('.tab-content').removeClass('active');
            $('#' + tabName).addClass('active');
        }
    </script>
@endpush