@extends('mylayouts.main')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4><strong>Detail {{ $role }}</strong></h4>
    <form action="{{ route('users.index', [$role]) }}" method="get">
        @include('mypartials.tahunajaran')
        <button class="btn btn-danger" type="submit">Kembali</button>
    </form>
</div>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <div class="table  table-borderless table-hover">
                    <table class="table align-middle">
                        <tr class="row">
                            <td class="col-3" style="font-weight: 600;">Nama</td>
                            <td class="col-1">:</td>
                            <td class="col-8">{{ $user->name }}</td>
                        </tr>
                        <tr class="row">
                            <td class="col-3" style="font-weight: 600;">Email</td>
                            <td class="col-1">:</td>
                            <td class="col-8">{{ $user->email }}</td>
                        </tr>
                        <tr class="row">
                            <td class="col-3" style="font-weight: 600;">Jenis Kelamin</td>
                            <td class="col-1">:</td>
                            <td class="col-8">{{ $user->jk == 'L' ? 'Laki-Laki' : 'Perempuan' }}</td>
                        </tr>
                        <tr class="row">
                            <td class="col-3" style="font-weight: 600;">Tempat Lahir</td>
                            <td class="col-1">:</td>
                            <td class="col-8">{{ $user->tempat_lahir }}</td>
                        </tr>
                        <tr class="row">
                            <td class="col-3" style="font-weight: 600;">Tanggal Lahir</td>
                            <td class="col-1">:</td>
                            <td class="col-8">{{ date('d F Y', strtotime($user->tanggal_lahir)) }}</td>
                        </tr>
                        <tr class="row">
                            <td class="col-3" style="font-weight: 600;">Agama</td>
                            <td class="col-1">:</td>
                            <td class="col-8">{{ $user->agama }}</td>
                        </tr>
                        <tr class="row">
                            <td class="col-3" style="font-weight: 600;">Provinsi</td>
                            <td class="col-1">:</td>
                            <td class="col-8">{{ $user->provinsi }}</td>
                        </tr>
                        <tr class="row">
                            <td class="col-3" style="font-weight: 600;">Kabupaten</td>
                            <td class="col-1">:</td>
                            <td class="col-8">{{ $user->kabupaten }}</td>
                        </tr>
                        <tr class="row">
                            <td class="col-3" style="font-weight: 600;">Kecamatan</td>
                            <td class="col-1">:</td>
                            <td class="col-8">{{ $user->kecamatan }}</td>
                        </tr>
                        <tr class="row">
                            <td class="col-3" style="font-weight: 600;">Kelurahan</td>
                            <td class="col-1">:</td>
                            <td class="col-8">{{ $user->kelurahan }}</td>
                        </tr>
                        <tr class="row">
                            <td class="col-3" style="font-weight: 600;">Jalan</td>
                            <td class="col-1">:</td>
                            <td class="col-8">{{ $user->jalan }}</td>
                        </tr>
                        @if ($role == 'siswa' && isset($user->kelas))
                        <tr class="row">
                            <td class="col-3" style="font-weight: 600;">Kelas</td>
                            <td class="col-1">:</td>
                            <td class="col-8">{{ $user->romawi }} {{ $user->kelas }}</td>
                        </tr>
                        @endif
                        @if ($role == 'siswa' && isset($user->kompetensi))
                        <tr class="row">
                            <td class="col-3" style="font-weight: 600;">Kompetensi Keahlian</td>
                            <td class="col-1">:</td>
                            <td class="col-8">{{ $user->kompetensi }}</td>
                        </tr>
                        @endif
                        @if ($role == 'siswa' && isset($user->spp))
                        <tr class="row">
                            <td class="col-3" style="font-weight: 600;">SPP</td>
                            <td class="col-1">:</td>
                            <td class="col-8">{{ $user->spp->nominal }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
            <div class="col-md-4">
                <img class="" src="{{ $user->profil == '/img/profil.png' ? $user->profil : asset('storage/' . $user->profil) }}" alt="profil" style="max-height: 15rem;width: 100%">
            </div>
        </div>
    </div>
</div>
@endsection