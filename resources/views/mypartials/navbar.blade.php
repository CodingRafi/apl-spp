<nav class="navbar navbar-expand navbar-light navbar-bg">
  <a class="sidebar-toggle js-sidebar-toggle">
    <i class="hamburger align-self-center"></i>
  </a>
  @if (!Auth::user()->hasRole('super_admin'))
  <div class="dropdown">
    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
      aria-expanded="false">
      Tahun Ajaran
    </button>
    {{-- @dd($tahun_ajarans) --}}
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
      @foreach ($tahun_ajarans as $tahun_ajaran)
      <form action="" method="get">
        <input type="hidden" name="tahun_awal" value="{{ $tahun_ajaran->tahun_awal }}">
        <input type="hidden" name="tahun_akhir" value="{{ $tahun_ajaran->tahun_akhir }}">
        <button type="submit" class="dropdown-item text-dark">{{ $tahun_ajaran->tahun_awal }} - {{
          $tahun_ajaran->tahun_akhir }}</button>
      </form>
      @endforeach
    </ul>
  </div>
  @endif

  <div class="navbar-collapse collapse">
    <ul class="navbar-nav navbar-align">
      <li class="nav-item dropdown">
        <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
          <i class="align-middle" data-feather="settings"></i>
        </a>

        <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
          <img src="{{ Auth::user()->profil != '/img/profil.png' ? asset('storage/' . Auth::user()->profil) : asset('/img/profil.png') }}" class="avatar img-fluid rounded me-1" alt="Charles Hall" />
          <span class="text-dark">{{ Auth::user()->hasRole('siswa') ? Auth::user()->profile_siswa->name :
            Auth::user()->profile_user->name }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-end">
          <a class="dropdown-item" href="{{ route('profil.index') }}"><i class="align-middle me-1" data-feather="user"></i>
            Profile</a>
          <div class="dropdown-divider"></div>
          <form action="/logout" method="post" class="logout">
            @csrf
            <button class="dropdown-item text-danger" tabindex="-1" type="submit"
              style="border: none; background: none; color: grey;">
              <i class="ti-power-off text-primary"></i>
              <i class="align-middle me-1" data-feather="log-out"></i> Logout
            </button>
          </form>
        </div>
      </li>
    </ul>
  </div>
</nav>