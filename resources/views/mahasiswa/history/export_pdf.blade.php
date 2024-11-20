<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            margin: 20px;
            line-height: 1.5;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            height: 80px;
        }

        .header .title {
            font-size: 14pt;
            font-weight: bold;
        }

        .header .subtitle {
            font-size: 10pt;
        }

        .content {
            margin-top: 20px;
            font-size: 12pt;
        }

        .content p {
            margin: 5px 0;
        }

        .signature {
            margin-top: 40px;
            text-align: right;
        }

        .qr-code {
            margin-top: 20px;
            text-align: left;
        }

        .qr-code img {
            height: 100px;
            width: 100px;
        }

        .note {
            margin-top: 20px;
            font-size: 10pt;
            color: red;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ asset('polinema.jpg') }}" alt="Logo Polinema">
        <p class="title">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</p>
        <p class="title">POLITEKNIK NEGERI MALANG</p>
        <p class="subtitle">Jl. Soekarno-Hatta No. 9 Malang 65141</p>
        <p class="subtitle">Telepon (0341) 404424 Pes. 101-105, 0341-404420, Fax. (0341) 404420</p>
        <p class="subtitle">Laman: www.polinema.ac.id</p>
    </div>

    <h3 class="content">BERITA ACARA KOMPENSASI PRESENSI</h3>

    <div class="content">
        <p><strong>Nama Pemberi Pekerjaan:</strong> {{ $dosen->dosen_nama }}</p>
        <p><strong>NIDN:</strong> {{ $dosen->nidn }}</p>
        <p><strong>Memberikan rekomendasi kompensasi kepada:</strong></p>
        <p><strong>Nama Mahasiswa:</strong> {{ $mahasiswa->mahasiswa_nama }}</p>
        <p><strong>NIM:</strong> {{ $mahasiswa->nim }}</p>
        <p><strong>Semester:</strong> {{ $mahasiswa->semester }}</p>
        <p><strong>Pekerjaan:</strong> {{ $tugas->tugas_nama }}</p>
        <p><strong>Jumlah Jam:</strong> {{ $tugas->tugas_jam_kompen }}</p>
    </div>

    <div class="signature">
        <p>Malang, {{ now()->format('d F Y') }}</p>
        <p>Yang memberikan rekomendasi,</p>
        <br><br><br>
        <p>_________________________</p>
        <p>NIP:</p>
    </div>

    <div class="qr-code">
        <p><strong>Scan QR Code untuk validasi:</strong></p>
        <img src="{{ asset('qr.jpeg') }}" alt="QR Code">
    </div>

    <div class="note">
        <p><strong>NB:</strong> Form ini wajib disimpan untuk kepentingan bebas tanggungan.</p>
    </div>
</body>

</html>
