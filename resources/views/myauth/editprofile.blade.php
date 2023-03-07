@extends('mylayouts.main')

@section('content')
<div class="d-flex justify-content-between mb-3 align-items-center">
  <h4><strong>Edit Profil</strong></h4>
  <x-ButtonCustom class="btn btn-danger rounded" route="{{ route('profil.index') }}">
    Kembali
  </x-ButtonCustom>
</div>
<div class="card">
  <div class="card-body">
    <form action="{{ route('profil.update') }}" method="post" style=" width: 100%;" enctype="multipart/form-data">
      @csrf
      <div class="form-group">
        <label for="avatar" class="form-label">Avatar</label>
        <input class="form-control form-control-lg" type="file" id="formFile" name="profil"
          style="border-radius: 5px; height: 3vh; font-size: 15px;">
      </div>
      <div class="form-group">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror"
          placeholder="Masukan username" name="name" style="border-radius: 5px; font-size: 15px; height: 6.5vh;"
          value="{{ Auth::user()->name }}" value="{{ old('name') }}" required>
        @error('name')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control input-email @error('email') is-invalid @enderror" id="email"
          placeholder="name@example.com" name="email" style="width: 100%; height: 6.5vh; font-size: 15px;"
          value="{{ Auth::user()->email }}" value="{{ old('email') }}" required>
        @error('email')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div class="mt-3">
        <button type="submit" class="btn text-white auth-form-btn p-1"
          style="background-color: #3bae9c; font-size: 15px; height: 6.5vh; min-width: 8vw;">Simpan</button>
      </div>
    </form>
  </div>
</div>
@endsection