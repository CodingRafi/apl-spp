@extends('mylayouts.main')

@section('content')
<div class="d-flex justify-content-between mb-3 align-items-center">
    <h1 class="h3 d-flex align-items-center gap-2"><a href="{{ route('roles.index') }}"><i class="text-dark" data-feather="arrow-left" style="stroke-width: 3px;"></i></a> <strong>Edit Roles</strong></h1>
</div>

<div class="row">
    <form action="{{ route('roles.update', $data->id) }}" method="POST">
        @csrf
        @method('patch')
        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="mb-3 row">
                        <div class="col-md-12">
                            <label for="namaRole" class="form-label">Nama Role</label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text"
                                value="{{ isset($data) ? $data->name : old('name') }}" id="namaRole"
                                placeholder="Name Role" name="name" />
                            @error('name')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="permission" class="form-label">Hak Akses</label>
                            <select class="fstdropdown-select @error('permission') is-invalid @enderror" name="permission[]" id="permission" multiple>
                                @foreach ($permissions as $permission)
                                @if (old('permission'))
                                    @if (in_array($permission->id, old('permission')))
                                        <option value="{{ $permission->id }}" selected>{{ $permission->name }}</option>
                                    @else
                                        <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                    @endif       
                                @else
                                    @if (in_array($permission->id, $rolePermissions))
                                        <option value="{{ $permission->id }}" selected>{{ $permission->name }}</option>
                                    @else
                                        <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                    @endif       
                                @endif
                                @endforeach
                              </select>
                              @error('permission')
                              <div class="invalid-feedback">
                                {{ $message }}
                              </div>
                              @enderror
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn text-white btn-primary" type="submit">Simpan Perubahan</button>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection
