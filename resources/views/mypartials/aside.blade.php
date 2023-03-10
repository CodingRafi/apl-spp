<nav id="sidebar" class="sidebar js-sidebar">
  <div class="sidebar-content js-simplebar">
    <a class="sidebar-brand" href="{{ route('dashboard') }}">
      <span class="align-middle">Schoolio</span>
    </a>

    <ul class="sidebar-nav">
      <li class="sidebar-item {{ Request::is('dashboard') ? 'active' : '' }}">
        <x-ButtonCustom class="sidebar-link btn-sidebar-self" route="{{ route('dashboard') }}">
          <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
        </x-ButtonCustom>
      </li>

      {{-- @can('view_sekolah')
      <li class="sidebar-item {{ Request::is('sekolah*') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ route('sekolah.index') }}">
          <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Sekolah</span>
        </a>
      </li>
      @endcan --}}

      @can('view_pembayaran')
      <li class="sidebar-item {{ Request::is('pembayaran*') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ route('pembayaran.index') }}">
          <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Pembayaran</span>
        </a>
      </li>
      @endcan

      @if (auth()->user()->can('view_tahun_ajaran') || auth()->user()->can('view_agama') ||
      auth()->user()->can('view_kompetensi') || auth()->user()->can('view_kelas') || auth()->user()->can('view_spp'))
      <li class="sidebar-header">
        Data Master
      </li>
      @can('view_tahun_ajaran')
      <li class="sidebar-item {{ Request::is('data-master/tahun-ajaran*') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ route('tahun-ajaran.index') }}">
          <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Tahun Ajaran</span>
        </a>
      </li>
      @endcan
      @can('view_agama')
      <li class="sidebar-item {{ Request::is('data-master/agama*') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ route('agama.index') }}">
          <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Agama</span>
        </a>
      </li>
      @endcan
      @can('view_kompetensi')
      <li class="sidebar-item {{ Request::is('data-master/kompetensi*') ? 'active' : '' }}">
        <x-ButtonCustom class="sidebar-link btn-sidebar-self" route="{{ route('kompetensi.index') }}">
          <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Kompetensi</span>
        </x-ButtonCustom>
      </li>
      @endcan
      @can('view_kelas')
      <li class="sidebar-item {{ Request::is('data-master/kelas*') ? 'active' : '' }}">
        <x-ButtonCustom class="sidebar-link btn-sidebar-self" route="{{ route('kelas.index') }}">
          <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Kelas</span>
        </x-ButtonCustom>
      </li>
      @endcan
      @can('view_spp')
      <li class="sidebar-item {{ Request::is('data-master/spp*') ? 'active' : '' }}">
        <x-ButtonCustom class="sidebar-link btn-sidebar-self" route="{{ route('spp.index') }}">
          <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">SPP</span>
        </x-ButtonCustom>
      </li>
      @endcan
      @endif

      @can('view_users')
      <li class="sidebar-header">
        Data User
      </li>
      @foreach ($roles as $role)
      @if ($role->name != 'admin' && $role->name != 'super_admin')
        <li class="sidebar-item {{ Request::is('users/'.$role->name.'*') ? 'active' : '' }}">
          <x-ButtonCustom class="sidebar-link btn-sidebar-self" route="/users/{{ $role->name }}">
            <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Data {{ str_replace("_", " ", $role->name) }}</span>
          </x-ButtonCustom>
        </li>
        @endif
      @endforeach
      @endcan

      @can(['view_roles'])
      <li class="sidebar-header">
        Hak Akses
      </li>
      @can('view_roles')
      <li class="sidebar-item {{ Request::is('roles*') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ route('roles.index') }}">
          <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Roles</span>
        </a>
      </li>
      @endcan
      @endcan

    </ul>

  </div>
</nav>