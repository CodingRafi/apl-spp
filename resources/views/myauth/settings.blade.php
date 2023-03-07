@extends('mylayouts.main')

@push('css')
    <style>
        .pp-preview{
            height: 9rem;
            object-fit: cover;
        }
    </style>
@endpush

@section('content')
<div class="d-flex justify-content-between mb-3 align-items-center">
    <h4><strong>Profil</strong></h4>
    <a href="{{ route('profil.ubah-password') }}" class="btn btn-primary">Ubah Password</a>
</div>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-2">
                <div class="d-flex justify-content-center">
                    <img src="{{ Auth::user()->profil != '/img/profil.png' ? asset('storage/' . Auth::user()->profil) : asset('/img/profil.png') }}"
                        alt="user-avatar" class="d-block rounded w-100 pp-preview" id="uploadedAvatar" />
                </div>
            </div>
            <div class="col-md">
                <form method="POST" enctype="multipart/form-data" action="{{ route('profil.update') }}">
                    @csrf
                    @method('patch')
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input class="form-control" type="text" id="name" name="name"
                                value="{{ Auth::user()->hasRole('siswa') ? Auth::user()->profile_siswa->name : Auth::user()->profile_user->name }}"
                                autofocus />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input class="form-control" type="text" name="email" id="email"
                                value="{{ Auth::user()->email }}" />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="foto" class="form-label">Foto Profil</label>
                            <input class="form-control input-pp" type="file" name="profil" id="foto"
                                accept="image/*" onchange="previewImageUpdate();" />
                        </div>
                        <div class="col-md-6 d-flex justify-content-end gap-2 align-items-center">
                            <button type="submit" class="btn btn-primary" style="height: fit-content;">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    function previewImageUpdate() {
        const pp_preview = document.querySelector('.pp-preview');
        const input = document.querySelector('.input-pp');

        pp_preview.style.display = 'block';

        var oFReader = new FileReader();
        oFReader.readAsDataURL(input.files[0]);

        oFReader.onload = function(oFREvent) {
            pp_preview.src = oFREvent.target.result;
        };
    };
</script>
@endpush