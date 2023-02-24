@extends('mylayouts.main')

@section('content')
<div class="d-flex justify-content-between mb-3">
  <h4><strong>Create {{ $role }}</strong></h4>
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