@extends('mylayouts.main')

@section('content')
<div class="d-flex justify-content-between mb-3 align-items-center">
    <div class="col-md-7">
        <h4><strong>Data {{ $role }}</strong></h4>
    </div>
    @if (count($tahun_ajarans) > 0)
    <div class="col-md d-flex justify-content-end gap-2">
        @if (auth()->user()->can('export_users'))
        <x-ButtonCustom class="btn btn-primary btn-export" route="/export/users/{{ $role }}">
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
    @endif
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
                    {{-- @dd($users) --}}
                    @foreach ($users as $user)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>
                            <img src="{{ $user->profil == '/img/profil.png' ? asset($user->profil) : asset('storage/' . $user->profil) }}"
                                alt="" style="width: 4rem;height: 4rem;object-fit: cover;">
                        </td>
                        <td>{{ $role != 'siswa' ? ($user->profile_user ? $user->profile_user->name : '') :
                            ($user->profile_siswa ? $user->profile_siswa->name : '') }}</td>
                        <td class="col-2">
                            <div class="d-flex flex-wrap gap-2">
                                <form action="{{ route('users.shows', ['role' => $role, 'id' => $user->id]) }}"
                                    method="get">
                                    @include('mypartials.tahunajaran')
                                    <button class="btn btn-sm btn-primary rounded" style="width: 4rem;">Detail</button>
                                </form>
                                @if (auth()->user()->can('edit_users'))
                                <form action="{{ route('users.edit', ['role' => $role, 'id' => $user->id]) }}"
                                    method="get">
                                    @include('mypartials.tahunajaran')
                                    <button class="btn btn-sm btn-warning rounded" style="width: 4rem;">Edit</button>
                                </form>
                                @endif
                                @if ($role == 'siswa')
                                <form action="{{ route('users.down', ['id' => $user->id]) }}" method="post">
                                    @include('mypartials.tahunajaran')
                                    @csrf
                                    <button class="btn btn-sm btn-danger rounded" style="width: 4rem;"
                                        onclick="return confirm('apakah anda yakin?')">Down</button>
                                </form>
                                @endif
                                @if (auth()->user()->can('delete_users'))
                                <button type="submit" class="btn btn-sm btn-danger rounded" style="width: 4rem;"
                                    onclick="deleteData('{{ route('users.destroy', ['role' => $role, 'id' => $user->id]) }}')">Hapus</button>
                                @endif
                            </div>
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
    const search = $('.container-filter input[name="search"]');
    const kompetensi = $('.container-filter .filter-kompetensi');
    const kelas = $('.container-filter .filter-kelas');

    function filter_user(){
        let role = '{{ request("role") }}';
        let form = new FormData();
        form.set('search', search.val());
        form.set('kompetensi', kompetensi ? kompetensi.val() : '');
        form.set('kelas', kelas.val());
        form.set('tahun_awal', "{{ request('tahun_awal') }}");
        form.set('tahun_akhir', "{{ request('tahun_akhir') }}");

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
                $('.table-user tbody').empty();
                let no = 1;
                $.each(response.data, function(i,e){
                    $('.table-user tbody').append(
                        `
                        <tr>
                            <th scope="row">${no}</th>
                            <td>
                                <img src="${e.profil == '/img/profil.png' ? e.profil : '/storage/' + e.profil}"
                                alt="" style="width: 4rem;height: 4rem;object-fit: cover;">
                            </td>
                            <td>${e.name}</td>
                            <td class="col-2">
                                <div class="d-flex flex-wrap gap-2">
                                    <form action="/users/${role}/${e.id}" method="get">
                                        @include('mypartials.tahunajaran')
                                        <button class="btn btn-sm btn-primary rounded" style="width: 4rem;">Detail</button>
                                    </form>
                                    @if (auth()->user()->can('edit_users'))
                                    <form action="/users/${role}/${e.id}/edit" method="get">
                                        @include('mypartials.tahunajaran')
                                        <button class="btn btn-sm btn-warning rounded" style="width: 4rem;">Edit</button>
                                    </form>
                                    @if ($role == 'siswa')
                                    <form action="/users/siswa/${e.id}/down" method="post">
                                        @include('mypartials.tahunajaran')
                                        @csrf
                                        <button class="btn btn-sm btn-danger rounded" style="width: 4rem;"
                                    onclick="return confirm('apakah anda yakin?')">Down</button>
                                    </form>
                                    @endif
                                    @endif
                                    @if (auth()->user()->can('delete_users'))
                                    <button type="submit" class="btn btn-sm btn-danger rounded" style="width: 4rem;" onclick="deleteData('/users/${role}/${e.id}')">Hapus</button>
                                    @endif
                                </div>
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

    $('.btn-export').attr('type', 'button').on('click', function(e){
        e.preventDefault();
        $(`
            <input type="hidden" name="search" value="${search.val()}">
            <input type="hidden" name="kelas" value="${kelas.val()}">
            <input type="hidden" name="kompetensi" value="${kompetensi ? kompetensi.val() : ''}">
        `).insertBefore(this)

        $(this).parent().submit();
    })  
</script>
@endpush