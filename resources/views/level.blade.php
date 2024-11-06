@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-header">Level User</div>
    <div class="card-body">
        <table id="table_level" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Level</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#table_level').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ url('level/list') }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'nama', name: 'nama' },
                { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endpush
