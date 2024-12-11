<div class="sidebar">
    <!-- Brand Logo -->
    <a class="brand-link">
        <img src="{{ asset('img/SK.png') }}" alt="Suka Kompen" class="brand-image img-circle elevation-3"
            style="opacity: 1">
        <span class="brand-text font-weight-light">Suka Kompen.</span>
    </a>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            
            <!-- ADM (Admin) -->
            @if(Auth::check() && Auth::user()->getRole() === 'ADM')
                <li class="nav-item">
                    <a href="{{ url('welcome') }}" class="nav-link {{ $activeMenu == 'welcome' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-header">Data Pengguna</li>
                <li class="nav-item">
                    <a href="{{ url('user') }}" class="nav-link {{ $activeMenu == 'user' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Data User</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('alpam') }}" class="nav-link {{ $activeMenu == 'alpam' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-clock"></i>
                        <p>Alpa Mahasiswa</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('kompenma') }}" class="nav-link {{ $activeMenu == 'kompenma' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-check"></i>
                        <p>Kompen Mahasiswa</p>
                    </a>
                </li>
                <li class="nav-header">Kompen</li>
                <li class="nav-item">
                    <a href="{{ url('tugas') }}" class="nav-link {{ $activeMenu == 'tugas' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>Tugas Kompen</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('jenis') }}" class="nav-link {{ $activeMenu == 'jenis' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>Jenis Tugas</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('kompetensi') }}" class="nav-link {{ $activeMenu == 'kompetensi' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tools"></i>
                        <p>Kompetensi Tugas</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('pesan') }}" class="nav-link {{ $activeMenu == 'pesan' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-envelope"></i>
                        <p>Inbox</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('profil') }}" class="nav-link {{ $activeMenu == 'profil' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Profile</p>
                    </a>
                </li>
            @endif
            
            <!-- DOSEN -->
            @if((Auth::check() && Auth::user()->getRole() === 'DSN') || (Auth::check() && Auth::user()->getRole() === 'TDK'))
                <li class="nav-header">Dosen/Tendik</li>
                <li class="nav-item">
                    <a href="{{ url('landing') }}" class="nav-link {{ $activeMenu == 'landing' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('kompen') }}" class="nav-link {{ $activeMenu == 'kompen' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>Tugas Kompen</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('alpha') }}" class="nav-link {{ $activeMenu == 'alpha' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-clock"></i>
                        <p>Alpa Mahasiswa</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('kompenmhs') }}" class="nav-link {{ $activeMenu == 'kompenmhs' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-check"></i>
                        <p>Kompen Mahasiswa</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/notifikasi') }}" class="nav-link {{ $activeMenu == 'notifikasi' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-envelope"></i>
                        <p>Inbox</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('profile') }}" class="nav-link {{ $activeMenu == 'profil' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Profile</p>
                    </a>
                </li>
            @endif

            <!-- MAHASISWA -->
            @if(Auth::check() && Auth::user()->getRole() === 'MHS')
                <li class="nav-header">Mahasiswa</li>
                <li class="nav-item">
                    <a href="{{ url('dashboardmhs') }}" class="nav-link {{ $activeMenu == 'dashboardmhs' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('akumulasi') }}" class="nav-link {{ $activeMenu == 'akumulasi' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>Akumulasi</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('task') }}" class="nav-link {{ $activeMenu == 'task' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>Tugas</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('history') }}" class="nav-link {{ $activeMenu == 'history' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-clock"></i>
                        <p>Histori</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('inbox') }}" class="nav-link {{ $activeMenu == 'inbox' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-envelope"></i>
                        <p>Inbox</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('profilemhs') }}" class="nav-link {{ $activeMenu == 'profilemhs' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Profile</p>
                    </a>
                </li>
            @endif

            <!-- Logout -->
            <li class="nav-header">Logout</li>
            <li class="nav-item logout">
                <a href="{{ url('/logout') }}" class="nav-link">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                    <p>Logout</p>
                </a>
            </li>
        </ul>
    </nav>

    <div class="about-us-section mt-auto">
        <a href="{{ url('/about') }}" class="nav-link text-center">
            <i class="fas fa-info-circle"></i>
            <p>About Us</p>
        </a>
    </div>
</div>
