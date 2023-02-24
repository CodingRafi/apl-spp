@extends('mylayouts.main')

@section('content')
<div class="d-flex justify-content-between mb-3 align-items-center">
    <div class="col-md-7">
        <h4><strong>Pembayaran</strong></h4>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="row container-filter">
            <div class="col-md-6 mb-3">
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
                        <td>{{ $user->profile_siswa ? $user->profile_siswa->name : '' }}</td>
                        <td>
                            <x-ButtonCustom class="btn btn-sm btn-primary rounded" route="{{ route('pembayaran.show', ['user_id' => $user->id]) }}">
                                Detail
                            </x-ButtonCustom>
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
                                    {{-- <img src="{{ $user->profil == '/img/profil.png' ? $user->profil : asset('storage/' . $user->profil) }}"
                                        alt="" style="object-fit: cover; border-radius: 50%"> --}}
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