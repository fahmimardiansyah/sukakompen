<div class="col-md-8 border-right">
    <div class="p-3 py-4">
        <div class="d-flex align-items-center">
            <h4 class="text-right">Validasi</h4>
        </div>
        <div class="row mt-3">
            <table class="table table-bordered table-striped table-hover table-sm">
                <tr>
                    <th style="width: 20%">NIM</th>
                    <td>{{ $mahasiswa->nim ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Nama</th>
                    <td>{{ $mahasiswa->mahasiswa_nama ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Jumlah Alpa</th>
                    <td>{{ $mahasiswa->jumlah_alpa ?? '0' }} Jam</td>
                </tr>
                <tr>
                    <th>Prodi</th>
                    <td>{{ $mahasiswa->prodi->prodi_nama ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Semester</th>
                    <td>{{ $mahasiswa->semester ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Foto KTM</th>
                    <td><img src="/img/ktm.png" alt="Faiz Abiyu Atha Fawas" style="width: 150px; height: 250px;"></td>
                </tr>
            </table>
        </div>
        <div class="modal-footer"> 
            <button type="button" data-dismiss="modal" class="btn btn-primary">Tutup</button>
            <button type="button" data-dismiss="modal" class="btn btn-success">Terima</button>
        </div> 
    </div>
</div>