<header class="header">
    <div class="logo">
        <a href="{{ url('/') }}">
            <img src="{{ asset('img/logo.png') }}" alt="Logo">
        </a>
    </div>
    <nav class="navbar">
        <ul>
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ url('/akumulasi') }}">Akumulasi</a></li>
            <li><a href="{{ url('/tugas') }}">Tugas</a></li>
            <li><a href="{{ url('history') }}">History</a></li>
            <li><a href="{{ url('/notif') }}">Message</a></li>
  
            <!-- Periksa apakah pengguna sudah login -->
            @if (Auth::check())
                <li>
                    <a href="{{ url('profile') }}">
                      <img src="{{ asset('img/profilepict.jpg') }}" alt="Profile" class="profile-picture">
                    </a>
                </li>
            @else
                <!-- Tampilkan tombol login jika belum login -->
                <li><a href="{{ url('login') }}" class="btn">Login</a></li>
            @endif
        </ul>
    </nav>
  </header>
   