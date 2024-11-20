<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Acara Kompensasi Presensi</title>
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
            margin: 2px 0;
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
        <p><strong>No Tugas:</strong> {{ $tugas_No ?? '-' }}</p>
        <p><strong>Nama Pemberi Pekerjaan:</strong> {{ $pemberi_tugas ?? '-' }}</p>
        <p><strong>NIDN:</strong> {{ $nidn ?? '-' }}</p>
        <p><strong>Nama Mahasiswa:</strong> {{ $mahasiswa_nama ?? '-' }}</p>
        <p><strong>NIM:</strong> {{ $nim ?? '-' }}</p>
        <p><strong>Semester:</strong> {{ $semester ?? '-' }}</p>
        <p><strong>Pekerjaan:</strong> {{ $tugas_nama ?? '-' }}</p>
        <p><strong>Jumlah Jam:</strong> {{ $tugas_jam_kompen ?? '0' }} jam</p>
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
        <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Code">
    </div>



    <div class="note">
        <p><strong>NB:</strong> Form ini wajib disimpan untuk kepentingan bebas tanggungan.</p>
    </div>
</body>

</html>
