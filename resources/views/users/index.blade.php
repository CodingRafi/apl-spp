@extends('mylayouts.main')

@section('content')
<div class="d-flex justify-content-between mb-3 align-items-center">
    <div class="col-md-7">
        <h1 class="h3"><strong>Data {{ $role }}</strong></h1>
    </div>
    <div class="col-md d-flex justify-content-end gap-2">
        @if (auth()->user()->can('export_users'))
        <x-ButtonCustom class="btn btn-primary" route="/export/users/{{ $role }}">
            Export
        </x-ButtonCustom>
        @endif
        @if (auth()->user()->can('import_users'))
        <x-ButtonCustom class="btn btn-primary" route="/import/users/{{ $role }}">
            Import
        </x-ButtonCustom>
        @endif
        @if (auth()->user()->can('add_users'))
        <x-ButtonCustom class="btn btn-primary" route="{{ route('users.create', [$role]) }}">
            Tambah
        </x-ButtonCustom>
        @endif
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="row container-filter">
            <div class="col-md-6 mb-3">
                <input type="text" class="form-control" placeholder="Search..." name="search" onkeyup="filter_user()">
            </div>
            @if ($role == 'siswa')
            @if (check_jenjang())
            <div class="col-md-3 mb-3">
                <select class="form-select filter-kompetensi" onchange="filter_user()">
                    <option value="" selected>Pilih Kompetensi</option>
                    @foreach ($kompetensis as $kompetensi)
                    <option value="{{ $kompetensi->id }}">{{ $kompetensi->kompetensi }}</option>
                    @endforeach
                </select>
            </div>
            @endif
            <div class="col-md-3 mb-3">
                <select class="form-select filter-kelas" onchange="filter_user()">
                    <option value="" selected>Pilih Kelas</option>
                    @foreach ($kelas as $row)
                    <option value="{{ $row->id }}">{{ $row->romawi }} {{ $row->nama }}</option>
                    @endforeach
                </select>
            </div>
            @endif
        </div>
        <div class="table table-responsive table-hover text-center">
            <table class="table align-middle table-user">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Profil</th>
                        <th scope="col">Name</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>
                            {{-- <img src="{{ $user->profil == '/img/profil.png' ? $user->profil : asset('storage/' . $user->profil) }}"
                                alt="" style="object-fit: cover; border-radius: 50%"> --}}
                        </td>
                        <td>{{ $role != 'siswa' ? ($user->profile_user ? $user->profile_user->name : '') :
                            ($user->profile_siswa ? $user->profile_siswa->name : '') }}</td>
                        <td>
                            <form action="{{ route('users.shows', ['role' => $role, 'id' => $user->id]) }}"
                                method="get">
                                @include('mypartials.tahunajaran')
                                <button class="btn btn-sm text-white"
                                    style="background-color: #3bae9c; width: 5rem; margin: 0.1rem;border-radius: 5px;font-weight: 500;">Show</button>
                            </form>
                            @if (auth()->user()->can('edit_users'))
                            <form action="{{ route('users.edit', ['role' => $role, 'id' => $user->id]) }}" method="get">
                                @include('mypartials.tahunajaran')
                                <button class="btn btn-sm btn-warning text-white"
                                    style="width: 5rem; margin: 0.1rem;border-radius: 5px;font-weight: 500;">Edit</button>
                            </form>
                            @if ($role == 'siswa')
                            <form action="{{ route('users.down', ['id' => $user->id]) }}" method="post">
                                @include('mypartials.tahunajaran')
                                @csrf
                                <button class="btn btn-sm btn-danger text-white"
                                    style="width: 5rem; margin: 0.1rem;border-radius: 5px;font-weight: 500;"
                                    onclick="return confirm('apakah anda yakin?')">Down</button>
                            </form>
                            @endif
                            @endif
                            @if (auth()->user()->can('delete_users'))
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="deleteData('{{ route('users.destroy', ['role' => $role, 'id' => $user->id]) }}')"
                                style="width: 5rem; margin: 0.1rem;border-radius: 5px;font-weight: 500;">Hapus</button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    function filter_user(){
            let role = '{{ request("role") }}';
            let form = new FormData();
            form.set('search', $('.container-filter input[name="search"]').val());
            form.set('kompetensi', $('.container-filter .filter-kompetensi') ? $('.container-filter .filter-kompetensi').val() : '');
            form.set('kelas', $('.container-filter .filter-kelas').val());

            $.ajax({
                type: "POST",
                url: "{{ route('users.list', request('role')) }}",
                data: form,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function (e) {
                    if (e && e.overrideMimeType) {
                        e.overrideMimeType("application/json;charset=UTF-8");
                    }
                },
                success: function (response) {
                    console.log(response)
                    $('.table-user tbody').empty();
                    let no = 1;
                    $.each(response.data, function(i,e){
                        console.log(e)
                        $('.table-user tbody').append(
                            `
                            <tr>
                                <th scope="row">${no}</th>
                                <td>
                                    {{-- <img src="{{ $user->profil == '/img/profil.png' ? $user->profil : asset('storage/' . $user->profil) }}"
                                        alt="" style="object-fit: cover; border-radius: 50%"> --}}
                                </td>
                                <td>${e.name}</td>
                                <td>
                                    <form action="/users/${role}/${e.id}" method="get">
                                        @include('mypartials.tahunajaran')
                                        <button class="btn btn-sm text-white"
                                            style="background-color: #3bae9c; width: 5rem; margin: 0.1rem;border-radius: 5px;font-weight: 500;">Show</button>
                                    </form>
                                    @if (auth()->user()->can('edit_users'))
                                    <form action="/users/${role}/${e.id}/edit" method="get">
                                        @include('mypartials.tahunajaran')
                                        <button class="btn btn-sm btn-warning text-white"
                                            style="width: 5rem; margin: 0.1rem;border-radius: 5px;font-weight: 500;">Edit</button>
                                    </form>
                                    @if ($role == 'siswa')
                                    <form action="/users/siswa/${e.id}" method="post">
                                        @include('mypartials.tahunajaran')
                                        @csrf
                                        <button class="btn btn-sm btn-danger text-white"
                                            style="width: 5rem; margin: 0.1rem;border-radius: 5px;font-weight: 500;"
                                            onclick="return confirm('apakah anda yakin?')">Down</button>
                                    </form>
                                    @endif
                                    @endif
                                    @if (auth()->user()->can('delete_users'))
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="deleteData('/users/siswa/${e.id}')"
                                        style="width: 5rem; margin: 0.1rem;border-radius: 5px;font-weight: 500;">Hapus</button>
                                    @endif
                                </td>
                            </tr>
                            `
                        );

                        no++;
                    })
                },
                error: function (response) {
                    console.log(response)
                },
            });
        }
</script>
@endpush