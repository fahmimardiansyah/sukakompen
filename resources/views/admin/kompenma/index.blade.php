@extends('layouts.template')

@section('content')

<div class="card card-outline card-primary">
    <!-- Hero Section -->
    <div class="hero">
        <h1>Kompen Mahasiswa</h1>
    </div>

    <div class="search-bars">
        <div class="filter">
            <i class="fas fa-filter"></i>
            <select>
                <option value="">- Periode Tahun -</option>
            </select>
        </div>
    </div>

    <div class="table-alpa">
        <div class="notif">
            <h2>Tabel Kompen Mahasiswa</h2>
        </div>
        <div class="tabs">
            <button class="tab active" onclick="showTab('user')">User</button>
            <button class="tab" onclick="showTab('all')">All User</button>
        </div>

        <div id="user" class="tab-content active">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Nama Mahasiswa</th>
                            <th>NIM</th>
                            <th>Tugas Kompen</th>
                            <th>Bobot Kompen</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mahasiswa as $data)
                            <tr>
                                <td data-label="Nama Mahasiswa">{{ $data->mahasiswa->mahasiswa_nama }}</td>
                                <td data-label="NIM">{{ $data->mahasiswa->nim }}</td>
                                <td data-label="Tugas Kompen">{{ $data->tugas->tugas_nama }}</td>
                                <td data-label="Bobot Kompen">{{ $data->tugas->tugas_jam_kompen }} Jam</td>
                                <td data-label="Status">
                                    @if($data->status === 1)
                                        Selesai (Tugas Diterima)
                                    @elseif($data->status === 0)
                                        Tugas Ditolak
                                    @elseif($data->status === null)
                                        Selesai (Menunggu persetujuan)
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        @foreach($progress as $item)
                            @if($item->status === 0)
                                <tr>
                                    <td data-label="Nama Mahasiswa">{{ $item->mahasiswa->mahasiswa_nama }}</td>
                                    <td data-label="NIM">{{ $item->mahasiswa->nim }}</td>
                                    <td data-label="Tugas Kompen">{{ $item->tugas->tugas_nama }}</td>
                                    <td data-label="Bobot Kompen">{{ $item->tugas->tugas_jam_kompen }} Jam</td>
                                    <td data-label="Status">Belum Selesai (Progress)</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div id="all" class="tab-content">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Nama Mahasiswa</th>
                            <th>NIM</th>
                            <th>Tugas Kompen</th>
                            <th>Bobot Kompen</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($approvalAll as $data)
                            <tr>
                                <td data-label="Nama Mahasiswa">{{ $data->mahasiswa->mahasiswa_nama }}</td>
                                <td data-label="NIM">{{ $data->mahasiswa->nim }}</td>
                                <td data-label="Tugas Kompen">{{ $data->tugas->tugas_nama }}</td>
                                <td data-label="Bobot Kompen">{{ $data->tugas->tugas_jam_kompen }} Jam</td>
                                <td data-label="Status">
                                    @if($data->status === 1)
                                        Selesai (Tugas Diterima)
                                    @elseif($data->status === 0)
                                        Tugas Ditolak
                                    @elseif($data->status === null)
                                        Selesai (Menunggu persetujuan)
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        @foreach($progressAll as $item)
                            @if($item->status === 0)
                                <tr>
                                    <td data-label="Nama Mahasiswa">{{ $item->mahasiswa->mahasiswa_nama }}</td>
                                    <td data-label="NIM">{{ $item->mahasiswa->nim }}</td>
                                    <td data-label="Tugas Kompen">{{ $item->tugas->tugas_nama }}</td>
                                    <td data-label="Bobot Kompen">{{ $item->tugas->tugas_jam_kompen }} Jam</td>
                                    <td data-label="Status">Belum Selesai (Progress)</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<script>
    function showTab(tabName) {
        // Remove 'active' class from all tabs and tab contents
        $('.tab').removeClass('active');
        $('.tab-content').removeClass('active');

        // Add 'active' class to the clicked tab and corresponding tab content
        $('[onclick="showTab(\'' + tabName + '\')"]').addClass('active');
        $('#' + tabName).addClass('active');
    }
</script>
@endpush
