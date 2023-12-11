@extends('mylayouts.main')

@section('content')
<div class="d-flex justify-content-between mb-3 align-items-center">
    <h4><strong>Pembayaran</strong></h4> 
    <form action="{{ route('pembayaran.export_all') }}" method="POST" class="form-export">
        @include('mypartials.tahunajaran')
        @csrf
        <button type="submit" class="btn btn-primary">Export</button>
    </form>
</div>
<div class="card">
    <div class="card-body">
        @if (!Auth::user()->hasRole('siswa'))
        <div class="row container-filter">
            <div class="col-md-4 mb-3">
                <input type="text" class="form-control" placeholder="Search..." name="search" onkeyup="filter_user()">
            </div>
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
            <div class="col-md-3 mb-3">
                <select class="form-select filter-bulan" onchange="filter_user()">
                    <option value="" selected>Pilih Bulan</option>
                    @foreach (config('services.bulan') as $id => $bulan)
                    <option value="{{ $id + 1 }}">{{ $bulan }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @endif
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
                    @if ( Auth::user()->hasRole('siswa') )
                    <tr>
                        <th scope="row">#</th>
                        <td>
                            <img src="{{ $users->profil == '/img/profil.png' ? $users->profil : asset('storage/' . $users->profil) }}"
                                alt="" style="width: 4rem;height: 4rem;object-fit: cover;">
                        </td>
                        <td>{{ $users->name }}</td>
                        <td>
                            <x-ButtonCustom class="btn btn-sm btn-primary rounded"
                                route="{{ route('pembayaran.show', ['user_id' => $users->user_id]) }}">
                                Detail
                            </x-ButtonCustom>
                        </td>
                    </tr>
                    @else
                    @foreach ($users as $user)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>
                            <img src="{{ $user->profil == '/img/profil.png' ? $user->profil : asset('storage/' . $user->profil) }}"
                                alt="" style="width: 4rem;height: 4rem;object-fit: cover;">
                        </td>
                        <td>{{ $user->profile_siswa ? $user->profile_siswa->name : '' }}</td>
                        <td>
                            <x-ButtonCustom class="btn btn-sm btn-primary rounded"
                                route="{{ route('pembayaran.show', ['user_id' => $user->id]) }}">
                                Detail
                            </x-ButtonCustom>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            @if (!Auth::user()->hasRole('siswa'))
            {{ $users->links() }}
            @endif
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $('.form-export button').on('click', function(e){
        e.preventDefault();
        $('.form-export').append(`<input type="hidden" name="kelas_id" value="${$('.filter-kelas').val()}">`).append(`<input type="hidden" name="bulan" value="${$('.filter-bulan').val()}">`).submit();
    })

    function filter_user(){
            let role = '{{ request("role") }}';
            let form = new FormData();
            form.set('search', $('.container-filter input[name="search"]').val());
            form.set('kompetensi', $('.container-filter .filter-kompetensi') ? $('.container-filter .filter-kompetensi').val() : '');
            form.set('kelas', $('.container-filter .filter-kelas').val());

            $.ajax({
                type: "POST",
                url: "{{ route('users.list', 'siswa') }}",
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
                                <td>
                                    <form action="/pembayaran/${e.id}" method="get">
                                        @include('mypartials.tahunajaran')
                                        <button class="btn btn-sm btn-primary rounded">Detail</button>
                                    </form>
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