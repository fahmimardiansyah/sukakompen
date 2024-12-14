{{-- <!DOCTYPE html>
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
            font-size: 15pt;
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

</html> --}}

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Acara Kompensasi Presensi</title>
    <style>
        @page {
            size: A4;
            margin: 20mm;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            margin: 0;
            padding: 0;
            line-height: 1.3;
        }

        .container {
            width: 100%;
            padding: 20px;
            box-sizing: border-box;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
            position: relative;
        }

        .header img {
            height: 80px;
            position: absolute;
            top: 0;
        }

        .header .logo-left {
            left: 0;
        }

        .header .logo-right {
            right: 0;
        }

        .header .title {
            font-size: 10pt;
            font-weight: bold;
            margin-top: 10px;
            line-height: 1.2;
        }

        .header .subtitle {
            font-size: 8pt;
            margin: 2px 0;
        }

        hr {
            border: 0;
            border-top: 1px solid black;
            margin: 10px 0;
        }

        .content {
            font-size: 10pt;
            margin-bottom: 10px;
        }

        .content .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .content .label {
            width: 35%;
        }

        .content .value {
            width: 60%;
            /* border-bottom: 1px solid black; */
            padding-left: 5px;
        }

        .signature {
            margin-top: 20px;
            font-size: 10pt;
            display: flex;
            justify-content: space-between; /* Agar elemen dalam .signature tersebar */
            align-items: center; /* Agar elemen sejajar secara vertikal */
        }

        .signature .left-sign,
        .signature .right-sign {
            width: 45%;
            display: inline-block;
            vertical-align: top;
            text-align: center;
        }

        .qr-code {
            text-align: center;
            font-size: 8pt;
            align-self: flex-start;
        }

        .qr-code img {
            height: 100px;
            width: 100px;
        }

        .note {
            margin-top: 10px;
            font-size: 9pt;
            color: red;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img class="logo-left" src="{{ asset('img/polinema.jpg') }}" alt="Logo Polinema">
            <p class="title">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</p>
            <p class="title">POLITEKNIK NEGERI MALANG</p>
            <p class="subtitle">Jl. Soekarno-Hatta No. 9 Malang 65141</p>
            <p class="subtitle">Telepon (0341) 404424 Pes. 101-105, 0341-404420, Fax. (0341) 404420</p>
            <p class="subtitle">Laman: www.polinema.ac.id</p>
        </div>

        <hr>

        <h3 style="text-align: center; text-decoration: underline; margin: 10px 0;">BERITA ACARA KOMPENSASI PRESENSI</h3>

        <div class="content">
            <div class="row">
                <div class="label">Nama Pemberi Pekerjaan:  {{ $pemberi_tugas ?? '-' }}</div>
                <div class="value"></div>
            </div>
            <div class="row">
                <div class="label">NIP:  {{ $nomor_induk ?? '-' }}</div>
                <div class="value"></div>
            </div>
            <div class="row">
                <div class="label">Nama Mahasiswa:  {{ $mahasiswa_nama ?? '-' }}</div>
                <div class="value"></div>
            </div>
            <div class="row">
                <div class="label">NIM:  {{ $nim ?? '-' }}</div>
                <div class="value"></div>
            </div>
            <div class="row">
                <div class="label">Semester:  {{ $semester ?? '-' }}</div>
                <div class="value"></div>
            </div>
            <div class="row">
                <div class="label">Pekerjaan:  {{ $tugas_nama ?? '-' }}</div>
                <div class="value"></div>
            </div>
            <div class="row">
                <div class="label">Jumlah Jam:  {{ $tugas_jam_kompen ?? '-' }}</div>
                <div class="value"></div>
            </div>
        </div>

        <div class="signature">
            <div class="left-sign">
                <p>Mengetahui,</p>
                <p>Ka Program Studi</p>
                <br><br>
                <p>(..............................................)</p>
                <p>NIP: ............................................</p>
            </div>

            <div class="right-sign">
                <p>Malang, {{ now()->format('d F Y') }}</p>
                <p>Yang memberikan rekomendasi,</p>
                <br><br>
                <p>(..............................................)</p>
                <p>NIP: ............................................</p>
            </div>
        </div>
        <div class="qr-code">
            <p><strong>Scan QR Code untuk validasi:</strong></p>
            <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Code">
        </div>
        <div class="note">
            <p><strong>NB:</strong> Form ini wajib disimpan untuk kepentingan bebas tanggungan.</p>
        </div>
    </div>
</body>

</html>

