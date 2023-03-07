@extends('mylayouts.main')

@section('content')
<div class="d-flex justify-content-between mb-3 align-items-center">
  <h4><strong>Ubah Password</strong></h4>
</div>
<div class="card">
  <div class="card-body">
    <form action="{{ route('profil.reset-password') }}" method="post">
      @csrf
      @method('patch')
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="name@example.com" name="email"
          style="width: 100%; height: 7vh;" value="{{ Auth::user()->email }}">
        @error('email')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
          name="password" placeholder="Masukan password baru" style="width: 100%; height: 7vh;">
        @error('password')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div class="mb-3">
        <label for="confirm-password" class="form-label">Confirm Password</label>
        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
          id="confirm-password" name="password_confirmation" placeholder="Konfirmasi password baru"
          style="width: 100%; height: 7vh;">
        @error('password_confirmation')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div class="mt-3">
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>
@endsection