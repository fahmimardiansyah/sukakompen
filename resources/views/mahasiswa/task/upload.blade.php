@extends('layouts.template')

@section('content')
<div class="deskripsi-container">
    <div class="deskripsi-cont">
        <div class="deskripsi-image">
            <img src="{{ asset($description->image ?? 'img/penelitian.jpeg') }}" alt="Deskripsi Image">
        </div>
        <div class="deskripsi-content">
            <h2>{{ $description->tugas->tugas_nama }}</h2>
            <div class="deskripsi-tags">
                <div class="tag">
                    <span class="tipe {{ $description->tugas->tugas_tipe }}">{{ ucfirst($description->tugas->tugas_tipe) }}</span>
                    <span class="jenis {{ $description->tugas->jenis_id }}">{{ ucfirst($description->tugas->jenis->jenis_nama) }}</span>
                    @foreach ($kompetensi as $data)
                        <span class="kompetensi {{ $data->kompetensi->kompetensi_id }}">{{ ucfirst($data->kompetensi->kompetensi_nama) }}</span>
                    @endforeach
                </div>
            </div>
            <p class="deskripsi-description">
                {{ $description->tugas->tugas_deskripsi }}
            </p>
            <div class="deskripsi-info-container">
                <div class="deskripsi-details">
                    <div class="deskripsi-time">
                        <span><i class="fas fa-clock"></i> {{ $description->tugas->tugas_tenggat->format('H:i A') }}</span>
                        <span><i class="fas fa-calendar-alt"></i> {{ $description->tugas->tugas_tenggat->format('m/d/Y') }}</span>
                    </div>
                    <div class="deskripsi-duration">
                        <span><i class="fas fa-arrow-down"></i> Kuota: {{ $description->tugas->tugas_kuota }}</span>
                        <span>Jam Kompen: {{ $description->tugas->tugas_jam_kompen }}</span>
                    </div>
                </div>
            </div>
            <br>
            <div class="deskripsi-download">
                @if($fileData)
                    <a href="{{ $fileData['path'] }}" class="btn btn-info" download>
                        <i class="{{ $fileData['icon'] }}"></i> {{ $fileData['name'] }}
                    </a>
                @else
                    <span>No file available for download.</span>
                @endif
            </div>
            <br>
            <div class="form-group">
                <button onclick="modalAction('{{ url('/task/' . $description->progress_id . '/upload_tugas') }}')" class="btn btn-info" style="background: transparent; color: black;"><i class="fas fa-upload"></i> Upload File</button>
                @if($fileTugas)
                    <a href="{{ $fileTugas['path'] }}" download>
                        <i class="{{ $fileTugas['icon'] }}"></i> {{ $fileTugas['name'] }}
                    </a>
                @else
                    <span>No file available for download.</span>
                @endif
                <small id="error-file_barang" class="error-text form-text text-danger"></small>
            </div>
            <div class="deskripsi-download">
                <div class="req-button">
                    <a href="{{ url('/dashboardmhs') }}" class="back-button">Back to Tugas List</a>
                    <button onclick="modalAction('{{ url('/task/' . $description->progress_id . '/kirim') }}')" class="request-button">Kirim</button>
                </div>
            </div>
        </div>
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