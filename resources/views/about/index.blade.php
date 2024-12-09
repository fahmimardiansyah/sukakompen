@extends('layouts.template')

@section('content')

<div class="card card-outline card-primary">
    <!-- Hero Section -->
    <div class="hero-about">
        <h1>SUKA KOMPEN</h1>
        <p>Suka Kompen adalah platform web inovatif yang dirancang untuk membantu mahasiswa Politeknik Negeri Malang mengelola jam kompensasi secara efisien dan transparan. Melalui sistem ini, mahasiswa dapat dengan mudah mengerjakan tugas kompensasi yang diberikan untuk mengurangi jam alpa. 
            Kami berkomitmen untuk menciptakan solusi praktis yang mendukung kelancaran administrasi akademik dan mendorong mahasiswa dalam memenuhi tanggung jawabnya dengan lebih efektif.</p>
    </div>

    <!-- Team Section -->
    <div class="team">
        <h2>Our Team</h2>
        <div class="row">
            <!-- Member 1 -->
            <div class="col-md-6 text-center mb-4">
                <img src="/images/member1.jpg" alt="M. Hasan Basri" class="img-fluid rounded-circle" style="width: 150px; height: 150px;">
                <h4>Naswya Syafinka Widyamara</h4>
                <p>System Analyst | Quality Assurance</p>
            </div>
            <!-- Member 2 -->
            <div class="col-md-6 text-center mb-4">
                <img src="/images/member2.jpg" alt="Fahmi Mardiansyah" class="img-fluid rounded-circle" style="width: 150px; height: 150px;">
                <h4>Fahmi Mardiansyah</h4>
                <p>Front-End Developer</p>
            </div>
            <!-- Member 3 -->
            <div class="col-md-6 text-center mb-4">
                <img src="/images/member3.jpg" alt="Faiz Abiyu Atha Fawas" class="img-fluid rounded-circle" style="width: 150px; height: 150px;">
                <h4>Faiz Abiyu Atha Fawas</h4>
                <p>Back-End Developer | API Developer</p>
            </div>
            <!-- Member 4 -->
            <div class="col-md-6 text-center mb-4">
                <img src="/images/member4.jpg" alt="Naswya Syafinka Widyamara" class="img-fluid rounded-circle" style="width: 150px; height: 150px;">
                <h4>M. Hasan Basri</h4>
                <p>Mobile Developer</p>
            </div>
        </div>
    </div>
</div>

@endsection
