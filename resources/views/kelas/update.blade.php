@extends('mylayouts.main')

@section('content')
<div class="d-flex justify-content-between mb-3 align-items-center">
    <h1 class="h3"><strong>Edit Kelas</strong></h1>
</div>
<div class="card">
    <div class="card-body">
        @include('kelas.form')
    </div>
</div>
@endsection