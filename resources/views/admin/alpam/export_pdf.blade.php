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
            height: 70px;
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

        .content table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .content table th,
        .content table td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            font-size: 10pt;
        }

        .content table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .signature {
            margin-top: 20px;
            font-size: 10pt;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .signature .left-sign,
        .signature .right-sign {
            width: 45%;
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
            <img class="logo-left" src="{{ asset('polinema.jpg') }}" alt="Logo Polinema">
            <p class="title">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</p>
            <p class="title">POLITEKNIK NEGERI MALANG</p>
            <p class="subtitle">Jl. Soekarno-Hatta No. 9 Malang 65141</p>
            <p class="subtitle">Telepon (0341) 404424 Pes. 101-105, 0341-404420, Fax. (0341) 404420</p>
            <p class="subtitle">Laman: www.polinema.ac.id</p>
        </div>

        <hr>

        <h3 style="text-align: center; text-decoration: underline; margin: 10px 0;">BERITA ACARA KOMPENSASI PRESENSI</h3>

        <div class="content">
            <table>
                <thead>
                    <tr>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Jam Kompen</th>
                        <th>Jam Alpa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mahasiswa as $data)
                    <tr>
                        <td>{{ $data->mahasiswa_alpa_nim }}</td>
                        <td>{{ $data->mahasiswa_alpa_nama }}</td>
                        <td>{{ $data->jam_kompen}} Jam</td>
                        <td>{{ $data->jam_alpa }} Jam</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
