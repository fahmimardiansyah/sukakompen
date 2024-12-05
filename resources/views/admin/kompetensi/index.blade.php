@extends('layouts.template')

@section('content')

<div class="card card-outline card-primary">
<div class="hero">
    <h1>Kompetensi Tugas</h1>
</div>
<div class="notif">
    <h2>Manage Kompetensi Tugas</h2>
</div>
<div class="recommended-task">
    <a class="add-task"  onclick="modalAction('{{ url('/kompetensi/create_ajax') }}')">
        + Tambah Kompetensi Tugas
    </a>

    <section class="recommended-tasks">
    @foreach ($kompetensi as $item)
    <div class="kompeten-card">
        <i class="fas fa-user-circle" style="font-size: 50px;"></i>
        <div class="kompeten-info">
            <h3>{{ $item->kompetensi_nama }}</h3>
            <p>{{ $item->kompetensi_deskripsi }}</p>
        </div>
        <div class="kompeten-actions">
            <button class="edit-btn" onclick="modalAction('{{ url('/kompetensi/' . $item->kompetensi_id . '/edit_ajax') }}')">Edit</button>
            <button class="delete-btn" onclick="modalAction('{{ url('/kompetensi/' . $item->kompetensi_id . '/delete_ajax') }}')">Delete</button>
        </div>
    </div>
    @endforeach
    </section>
</div>
</div>

<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" databackdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>

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