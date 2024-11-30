<!-- Kondisi jika stok ada -->
<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Penerimaan Tugas</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-success">
                <h5><i class="icon fas fa-info-circle"></i> Informasi !!!</h5>
                Tugas telah dikumpulkan
            </div>
            <table class="table table-sm table-bordered table-striped">
                <tr>
                    <th class="text-right col-3">Nama Mahasiswa :</th>
                    <td class="col-9">Fahmi Mardiansyah</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Nama Tugas :</th>
                    <td class="col-9">Artikel</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Deskripsi Tugas :</th>
                    <td class="col-9">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quibusdam explicabo, delectus cum obcaecati ex quidem exercitationem necessitatibus. Excepturi, quae, nulla recusandae incidunt quaerat suscipit obcaecati dolorum magni quos, facilis hic?
                    </td>
                </tr>
                <tr>
                    <th class="text-right col-3">Bobot Tugas :</th>
                    <td class="col-9">10 Jam</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Download :</th>
                    <td class="col-9">
                        <a href="{{ asset('uploads/tugas/filename.pdf') }}" class="btn btn-success" download>
                            <i class="fas fa-download"></i> Download File
                        </a>
                    </td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-primary">Tutup</button>
        </div>
    </div>
</div>
