  
  
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
      @if (Auth::check() && Auth::user()->getRole() === 'ADM')
        <li>
            @if(Auth::user()->image)
              <a href="{{ url('profil') }}">
                <img src="{{ url( Auth::user()->image ) }}" alt="Profile" class="profile-picture">
              </a>
            @else
              <a href="{{ url('profil') }}">
                <i class="fa fa-user-circle" style="font-size: 50px; color: black"></i>
              </a>
            @endif
        </li>
      @endif

      @if((Auth::check() && Auth::user()->getRole() === 'DSN') || (Auth::check() && Auth::user()->getRole() === 'TDK'))
        <li>
            @if(Auth::user()->image)
              <a href="{{ url('profile') }}">
                <img src="{{ url( Auth::user()->image ) }}" alt="Profile" class="profile-picture">
              </a>
            @else
              <a href="{{ url('profile') }}">
                <i class="fa fa-user-circle" style="font-size: 50px; color: black"></i>
              </a>
            @endif
        </li>
      @endif

      @if (Auth::check() && Auth::user()->getRole() === 'MHS')
        <li>
          @if(Auth::user()->image)
            <a href="{{ url('profilemhs') }}">
              <img src="{{ url( Auth::user()->image ) }}" alt="Profile" class="profile-picture">
            </a>
          @else
            <a href="{{ url('profilemhs') }}">
              <i class="fa fa-user-circle" style="font-size: 50px; color: black"></i>
            </a>
          @endif
        </li>
      @endif
  </nav>
  <!-- /.navbar -->