<nav class="navbar navbar-expand navbar-light navbar-bg">
  <a class="sidebar-toggle js-sidebar-toggle">
    <i class="hamburger align-self-center"></i>
  </a>

  <div class="navbar-collapse collapse">
    <ul class="navbar-nav navbar-align">
      <li class="nav-item dropdown">
        <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
          <i class="align-middle" data-feather="settings"></i>
        </a>

        <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
          <img src="{{ asset('/img/avatars/avatar.jpg') }}" class="avatar img-fluid rounded me-1" alt="Charles Hall" /> <span
            class="text-dark">{{ Auth::user()->hasRole('siswa') ? Auth::user()->profile_siswa->name :
            Auth::user()->profile_user->name }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-end">
          <a class="dropdown-item" href="pages-profile.html"><i class="align-middle me-1" data-feather="user"></i>
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