@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="welcome-banner">
            <div class="welcome-content">
                <h1>SELAMAT DATANG DI SUKA KOMPEN</h1>
                <p>Butuh bantuan pekerja? Cari mahasiswa kompen disini</p>
                <a href="{{ url('/kompen') }}" class="start-button">Start Now</a>
            </div>
        </div>

        <div class="stats">
            <div>
                <i class="fas fa-user-clock">
                </i>
                <h5>
                    Mahasiswa Alpa
                </h5>
                <h2>
                    {{ $alpa }} Orang
                </h2>
                <a href="{{ url('/alpha') }}">
                    Lihat Selengkapnya
                </a>
            </div>
            <div>
                <i class="fas fa-user-check">
                </i>
                <h5>
                    Mahasiswa Kompen
                </h5>
                <h2>
                    {{ $progress }} Orang
                </h2>
                <a href="{{ url('/kompenmhs') }}">
                    Lihat Selengkapnya
                </a>
            </div>
        </div>

        <section class="recommended-tasks">
            <h2>Tugas Kompen</h2>
            <div class="task-grid">
                @foreach($tugas as $data)
                    <div class="task-card">
                        <div class="card-header">
                            <span class="task-category">{{ $data->jenis->jenis_nama }}</span>
                        </div>
                        <div class="card-body">
                            <img src="{{ asset('img/card.png') }}" alt="Tugas" class="task-image">
                            <h3>{{ $data->tugas_nama }}</h3>
                            <p>{{ $data->tugas_deskripsi }}</p>
                        </div>
                        <div class="card-footer">
                            <button onclick="modalAction('{{ url('/kompen/' . $data->tugas_id . '/edit_ajax') }}')" class="btn btn-edit">Edit</button>
                            <a href="{{ url('/kompen/' . $data->tugas_id . '/detail') }}" class="btn">Buka</a>
                            <button onclick="modalAction('{{ url('/kompen/' . $data->tugas_id . '/delete_ajax') }}')" class="btn btn-delete">Delete</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
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
    </script>
@endpush