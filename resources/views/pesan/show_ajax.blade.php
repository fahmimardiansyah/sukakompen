<!-- Kondisi jika stok kosong -->
<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                Data yang anda cari tidak ditemukan
            </div>
            <a href="/stok/" class="btn btn-warning">Kembali</a>
        </div>
    </div>
</div>

<!-- Kondisi jika stok ada -->
<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail Data Stok</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-info">
                <h5><i class="icon fas fa-info-circle"></i> Informasi !!!</h5>
                Berikut adalah detail data stok
            </div>
            <table class="table table-sm table-bordered table-striped">
                <tr>
                    <th class="text-right col-3">Nama Supplier :</th>
                    <td class="col-9">Supplier ABC</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Nama Barang :</th>
                    <td class="col-9">Barang XYZ</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Nama User :</th>
                    <td class="col-9">Nama User</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Stok Tanggal :</th>
                    <td class="col-9">2024-11-12</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Stok Jumlah :</th>
                    <td class="col-9">50</td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-primary">Tutup</button>
        </div>
    </div>
</div>
