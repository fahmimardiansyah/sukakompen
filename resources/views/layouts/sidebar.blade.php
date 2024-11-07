<div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img @if (file_exists(public_path(
                        'storage/uploads/profile_pictures/' .
                            auth()->user()->username .
                            '/' .
                            auth()->user()->username .
                            '_profile.png'))) src="{{ asset('storage/uploads/profile_pictures/' . auth()->user()->username . '/' . auth()->user()->username . '_profile.png') }}" @endif
                @if (file_exists(public_path(
                            'storage/uploads/profile_pictures/' .
                                auth()->user()->username .
                                '/' .
                                auth()->user()->username .
                                '_profile.jpg'))) src="{{ asset('storage/uploads/profile_pictures/' . auth()->user()->username . '/' . auth()->user()->username . '_profile.jpg') }}" @endif
                @if (file_exists(public_path(
                            'storage/uploads/profile_pictures/' .
                                auth()->user()->username .
                                '/' .
                                auth()->user()->username .
                                '_profile.jpeg'))) src="{{ asset('storage/uploads/profile_pictures/' . auth()->user()->username . '/' . auth()->user()->username . '_profile.jpeg') }}" @endif
                class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="{{ url('/profile') }}" class="d-block">{{ auth()->user()->username }}</a>
        </div>
    </div>
    <!-- SidebarSearch Form -->
    {{-- <div class="form-inline mt-2">
        <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
        </div>
    </div> --}}
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ url('/') }}" class="nav-link {{ $activeMenu == 'dashboard' ? 'active' : '' }} ">
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
                <a href="{{ url('/penjualan') }}" class="nav-link {{ $activeMenu == 'penjualan' ? 'active' : '' }}">
                    <i class="nav-icon far fa-user"></i>
                    <p>Alpa Mahasiswa</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/kompens') }}" class="nav-link {{ $activeMenu == 'kompens' ? 'active' : '' }}">
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
            <li class="nav-item">
                <a href="{{ url('/logout') }}" class="nav-link">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                    <p>Logout</p>
                </a>
            </li>
        </ul>
    </nav>
</div>