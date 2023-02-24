@extends('mylayouts.main')

@section('content')
<div class="d-flex justify-content-between mb-3 align-items-center">
    <h4><strong>Edit Kompetensi</strong></h4>
</div>
<div class="card">
    <div class="card-body">
        @include('kompetensi.form')
    </div>
</div>
@endsection