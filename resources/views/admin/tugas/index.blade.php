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
<div class="notif">
    <h2>Tugas</h2>
</div>

    <!-- Recommended Tasks Section -->
    {{-- <section class="recommended-tasks">
        <h2>Tugas Kompen</h2> --}}

<!-- Tabs and Add Task Button -->
<div class="content">
    <div class="tabs">
        <button class="tab active" onclick="showTab('admin')">Admin</button>
        <button class="tab" onclick="showTab('dosen')">Dosen</button>
        <button class="tab" onclick="showTab('tendik')">Tendik</button>
    </div>
    
        <!-- Admin Tab Content -->
        <div id="admin" class="tab-content active">
                <!-- Tombol "Tambah Tugas" -->
            <button onclick="modalAction('{{ url('/tugas/create_ajax') }}')" class="add-task">+ Tambah Tugas</button>
            <div class="task-grid">
                @foreach ($tugasAdmin as $item)
                    <div class="task-card">
                        <div class="card-header">
                            <span class="task-category">Admin Task</span>
                        </div>
                        <div class="card-body">
                            <img src="{{ asset('img/card.png') }}" alt="Tugas" class="task-image">
                            <h3>{{ $item->tugas_nama }}</h3>
                            <p>{{ $item->tugas_deskripsi }}</p>
                        </div>
                        <div class="card-footer">
                            <button onclick="modalAction('{{ url('/tugas/' . $item->tugas_id . '/edit_ajax') }}')" class="btn btn-edit">Edit</button>
                            <a href="{{ url('/tugas/' . $item->tugas_id . '/detail') }}" class="btn">Buka</a>
                            <button onclick="modalAction('{{ url('/tugas/' . $item->tugas_id . '/delete_ajax') }}')" class="btn btn-delete">Delete</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Dosen Tab Content -->
        <div id="dosen" class="tab-content">
            <div class="task-grid">
                @foreach ($tugasDosen as $item)
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
                            <a href="{{ url('/tugas/' . $item->tugas_id . '/detail') }}" class="btn">Buka</a>
                            <button onclick="modalAction('{{ url('/tugas/' . $item->tugas_id . '/delete_ajax') }}')" class="btn btn-delete">Delete</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Tendik Tab Content -->
        <div id="tendik" class="tab-content">
            <div class="task-grid">
                @foreach ($tugasTendik as $item)
                    <div class="task-card">
                        <div class="card-header">
                            <span class="task-category">Tendik Task</span>
                        </div>
                        <div class="card-body">
                            <img src="{{ asset('img/card.png') }}" alt="Tugas" class="task-image">
                            <h3>{{ $item->tugas_nama }}</h3>
                            <p>{{ $item->tugas_deskripsi }}</p>
                        </div>
                        <div class="card-footer">
                            <a href="{{ url('/tugas/' . $item->tugas_id . '/detail') }}" class="btn">Buka</a>
                            <button onclick="modalAction('{{ url('/tugas/' . $item->tugas_id . '/delete_ajax') }}')" class="btn btn-delete">Delete</button>
                        </div>
                    </div>
                @endforeach
            </div>
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

        function showTab(tabName) {
            $('.tab').removeClass('active');
            $('[onclick="showTab(\'' + tabName + '\')"]').addClass('active');

            $('.tab-content').removeClass('active');
            $('#' + tabName).addClass('active');
        }
    </script>
@endpush