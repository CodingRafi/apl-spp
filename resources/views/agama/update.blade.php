@extends('mylayouts.main')

@section('content')
<div class="d-flex justify-content-between mb-3 align-items-center">
    <h4><strong>Edit Agama</strong></h4>
</div>
<div class="row">
    <form action="{{ route('agama.update', $ref_agama->id) }}" method="POST">
        @csrf
        @method('patch')
        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ $ref_agama->nama, old('nama') }}">
                        @error('nama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn text-white" type="submit" style="background-color: #3bae9c;">Simpan</button>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection
