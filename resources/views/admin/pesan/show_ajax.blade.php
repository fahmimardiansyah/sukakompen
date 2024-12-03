<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="border-radius: 20px; padding: 20px;">
                <!-- Tombol Silang -->
                <button type="button" class="close" aria-label="Close" onclick="kembali()"
                style="position: absolute; top: 10px; right: 15px; font-size: 24px; border: none; background: none; cursor: pointer;">
                &times;
            </button>
        <div class="modal-body text-center">
            <h4>Request Tugas!!</h4>
            <hr>
            <h2>Membuat PPT</h2>

            <div class="mt-4">
                <button id="btn-tolak" class="btn btn-danger" onclick="handleTolak()">Tolak</button>
                <button id="btn-terima" class="btn btn-success" onclick="handleTerima()">Terima</button>
            </div>
        </div>
    </div>
</div>


<script>
    // Fungsi untuk kembali ke halaman sebelumnya
    function kembali() {
        window.location.href = "/pesan"; // Mengembalikan ke halaman sebelumnya
    }

    // Fungsi untuk aksi tombol Tolak
    function handleTolak() {
        alert("Tugas ditolak!");
        kembaliKeHalaman(); // Kembali ke halaman setelah menolak
    }

    // Fungsi untuk aksi tombol Terima
    function handleTerima() {
        alert("Tugas diterima!");
        kembaliKeHalaman(); // Kembali ke halaman setelah menerima
    }
</script>
