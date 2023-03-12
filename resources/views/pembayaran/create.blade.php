@extends('mylayouts.main')

@section('content')
<div class="d-flex justify-content-between mb-3">
  <h4><strong>Tambah Pembayaran</strong></h4>
  <x-ButtonCustom class="btn btn-danger rounded" route="{{ route('pembayaran.show', ['user_id' => request('user_id')]) }}">
    Kembali
  </x-ButtonCustom>
</div>
<div class="card">
  <div class="card-body">
    <form class="mt-3" action="{{ route('pembayaran.store', ['user_id' => request('user_id')]) }}" method="POST"
      enctype="multipart/form-data">
      @csrf
      @include('mypartials.tahunajaran')
      <div class="mb-3">
        <label for="nama" class="form-label">Nama</label>
        <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama"
          value="{{ $user->name }}" id="nama" disabled>
      </div>
      <div class="mb-3">
        <label for="nominal" class="form-label">Nominal</label>
        <input type="number" class="form-control @error('nominal') is-invalid @enderror" name="nominal"
          value="{{ $user->nominal }}" id="nominal" readonly>
      </div>
      <div class="mb-3">
        <label for="bulan" class="form-label">Bulan</label>
        <select class="fstdropdown-select form-select @error('bulan') is-invalid @enderror" multiple name="bulan[]" value="{{ old('bulan') }}"
          id="bulan">
          {{-- <option value="">Pilih bulan</option> --}}
          @foreach ($bulans as $key => $bulan)
          @if (old('bulan') == $key)
          <option value="{{ $key }}" selected>{{ $bulan }}</option>
          @else
          <option value="{{ $key }}">{{ $bulan }}</option>
          @endif
          @endforeach
        </select>
        @error('bulan')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div class="mb-3">
        <label for="penerima" class="form-label">Penerima</label>
        <input type="text" class="form-control @error('penerima') is-invalid @enderror" name="penerima"
          value="{{ Auth::user()->profile_user ? Auth::user()->profile_user->name : '' }}" id="penerima" disabled>
      </div>
      <button type="submit" class="btn btn-primary mt-3">Simpan</button>
    </form>
  </div>
</div>
@endsection