@extends('layouts.template')

@section('content')
<div class="deskripsi-container">
    <div class="deskripsi-cont">
        <div class="deskripsi-image">
            <img src="{{ asset($description->image ?? 'img/penelitian.jpeg') }}" alt="Deskripsi Image">
        </div>
        <div class="deskripsi-content">
            <h2>{{ $description->tugas_nama }}</h2>
            <div class="deskripsi-tags">
                <div class="tag">
                    <span class="tipe {{ $description->tugas_tipe }}">{{ ucfirst($description->tugas_tipe) }}</span>
                    <span class="jenis {{ $description->jenis->jenis_id }}">{{ ucfirst($description->jenis->jenis_nama) }}</span>
                    @foreach ($kompetensi as $data)
                        <span class="kompetensi {{ $data->kompetensi->kompetensi_id }}">{{ ucfirst($data->kompetensi->kompetensi_nama) }}</span>
                    @endforeach
                </div>
            </div>
            <p class="deskripsi-description">
                {{ $description->tugas_deskripsi }}
            </p>
            <div class="deskripsi-info-container">
                <div class="deskripsi-details">
                    <div class="deskripsi-time">
                        <span><i class="fas fa-clock"></i> {{ $description->tugas_tenggat->format('H:i A') }}</span>
                        <span><i class="fas fa-calendar-alt"></i> {{ $description->tugas_tenggat->format('m/d/Y') }}</span>
                    </div>
                    <div class="deskripsi-duration">
                        <span><i class="fas fa-arrow-down"></i> Kuota: {{ $description->tugas_kuota }}</span>
                        <span>Jam Kompen: {{ $description->tugas_jam_kompen }}</span>
                    </div>
                </div>
            </div>

            <div class="deskripsi-download">
                <div class="req-button">
                    <a href="{{ url('task') }}" class="back-button">Back to Tugas List</a>
                    <button onclick="modalAction('{{ url('/task/' . $description->tugas_id . '/apply') }}')" class="request-button">Apply</button>
                </div>
            </div>
        </div>
    </div>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false" data-width="75%"></div>
</div>
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

