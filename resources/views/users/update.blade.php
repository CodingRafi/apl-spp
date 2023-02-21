@extends('mylayouts.main')

@section('content')
<div class="d-flex justify-content-between mb-3">
  <h1 class="h3"><strong>Edit {{ $role }}</strong></h1>
  <x-ButtonCustom class="btn btn-danger rounded" route="{{ route('users.index', [$role]) }}">
    Kembali
  </x-ButtonCustom>
</div>
<div class="card">
  <div class="card-body">
    @include('users.form')
  </div>
</div>
@endsection