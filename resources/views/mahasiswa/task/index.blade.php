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

<div class="content">
        <div id="admin" class="tab-content active">
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
                            <a href="{{ url('/task/' . $item->tugas_id . '/detail') }}" class="btn">Buka</a>
                        </div>
                    </div>
                @endforeach
            </div>
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