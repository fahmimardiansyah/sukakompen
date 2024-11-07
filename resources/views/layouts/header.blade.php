  
  
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      @if (Auth::check())
      <li>
          <a href="{{ url('profile') }}">
            <img src="{{ asset('img/ian.jpg') }}" alt="Profile" class="profile-picture">
          </a>
      </li>
  @else
      <!-- Tampilkan tombol login jika belum login -->
      <li><a href="{{ url('login') }}" class="btn">Login</a></li>
  @endif
  </nav>
  <!-- /.navbar -->