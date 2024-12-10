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
                <option value="">- Pilih Jenis -</option>
            </select>
        </div>
    </div>

        <!-- Recommended Tasks Section -->
        <section class="recommended-tasks">

            <!-- Tombol "Tambah Tugas" -->
            <button onclick="modalAction('{{ url('/kompen/create_ajax') }}')" class="add-task">+ Tambah Tugas</button>
                <div class="task-grid">
                @foreach ($tugas as $item)
                    <div class="task-card">
                        <div class="card-header">
                            <span class="task-category">Dosen Task</span>
                        </div>
                        <div class="card-body">
                            <img src="{{ asset('img/card.png') }}" alt="Tugas" class="task-image">
                            <h3>{{ $item->tugas_nama }}</h3>
                            <p>{{ $item->tugas_deskripsi }}</p>
                        </div>
                        <div class="card-footer">
                            <button onclick="modalAction('{{ url('/kompen/' . $item->tugas_id . '/edit_ajax') }}')" class="btn btn-edit">Edit</button>
                            <a href="{{ url('/kompen/' . $item->tugas_id . '/detail') }}" class="btn">Buka</a>
                            <button onclick="modalAction('{{ url('/kompen/' . $item->tugas_id . '/delete_ajax') }}')" class="btn btn-delete">Delete</button>
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
    </script>
@endpush
