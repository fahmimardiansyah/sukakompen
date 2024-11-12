<div class="sidebar">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
        <img src="{{ asset('img/SK.png') }}" alt="Suka Kompen"class="brand-image img-circle elevation-3" style="opacity: 1">
        <span class="brand-text font-weight-light">Suka Kompen.</span>
    </a>
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ url('/') }}" class="nav-link {{ $activeMenu == 'welcome' ? 'active' : '' }} ">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="nav-header">Data Pengguna</li>
            <li class="nav-item">
                <a href="{{ url('/user') }}" class="nav-link {{ $activeMenu == 'user' ? 'active' : '' }}">
                    <i class="nav-icon far fa-user"></i>
                    <p>Data User</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/alpam') }}" class="nav-link {{ $activeMenu == 'alpam' ? 'active' : '' }}">
                    <i class="nav-icon far fa-user"></i>
                    <p>Alpa Mahasiswa</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/kompenma') }}" class="nav-link {{ $activeMenu == 'kompenma' ? 'active' : '' }}">
                    <i class="nav-icon far fa-user"></i>
                    <p>Kompen Mahasiswa</p>
                </a>
            </li>
            <li class="nav-header">Kompen</li>
            <li class="nav-item">
                <a href="{{ url('/tugas') }}" class="nav-link {{ $activeMenu == 'tugas' ? 'active' : '' }} ">
                    <i class="nav-icon far fa-bookmark"></i>
                    <p>Tugas Kompen</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/barang') }}" class="nav-link {{ $activeMenu == 'barang' ? 'active' : '' }} ">
                    <i class="nav-icon far fa-list-alt"></i>
                    <p>Manage Kompen</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/jenis') }}" class="nav-link {{ $activeMenu == 'jenis' ? 'active' : '' }} ">
                    <i class="nav-icon far fa-list-alt"></i>
                    <p>Jenis Tugas</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/kompetensi') }}" class="nav-link {{ $activeMenu == 'kompetensi' ? 'active' : '' }} ">
                    <i class="nav-icon far fa-list-alt"></i>
                    <p>Kompetensi Tugas</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('pesan') }}" class="nav-link {{ $activeMenu == 'pesan' ? 'active' : '' }} ">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Pesan</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('profile') }}" class="nav-link {{ $activeMenu == 'profile' ? 'active' : '' }} ">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Profile</p>
                </a>
            </li>
            <li class="nav-header">Logout</li>
            <li class="nav-item logout">
                <a href="{{ url('/logout') }}" class="nav-link">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                    <p>Logout</p>
                </a>
            </li>
        </ul>
    </nav>
</div>