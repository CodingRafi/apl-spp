@extends('mylayouts.main')

@section('content')
<div class="d-flex justify-content-between mb-3 align-items-center">
    <h4><strong>Roles</strong></h4>
    @can('add_roles')
    <button type="button" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#modalRole">
        Buat Role
    </button>
    @endcan
</div>

<div class="card">
    <div class="card-body">
        <div class="container-fluid p-0 mt-2">
            <ul class="nav nav-pills card-header-pills border-0 m-0 pb-0 gap-3" id="tab-main"
                style="flex-wrap: nowrap;">
                @foreach ($roles as $key => $role)
                <li class="nav-item" style="white-space: nowrap;">
                    <a class="nav-link a-tab {{ $key == 0 ? 'active' : '' }} text-capitalize" href="#{{ $role->name }}"
                        role="tab" aria-controls="{{ $role->name }}">{{ $role->name }}</a>
                </li>
                @endforeach
            </ul>
            <div class="tab-content mt-3 border-0 pt-0">
                @foreach ($roles as $key => $role)
                <div class="tab-pane {{ $key == 0 ? 'active' : '' }}" id="{{ $role->name }}" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Hak akses {{ $role->name }}</h5>
                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning text-white mb-3">Edit</a>
                    </div>
                    <div class="row">
                        @forelse ($rolePermissions[$key] as $rolePermission)
                        <div class="col-md-3 my-2 text-capitalize">{{ str_replace("_", " ", $rolePermission->name) }}</div>
                        @empty
                            <span class="text-center my-3">-- Tidak ada hak akses --</span>
                        @endforelse
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@can('add_roles')
<div class="modalkey modal fade" id="modalRole" tabindex="-1" aria-labelledby="role" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('roles.store') }}" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="role">Buat Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="name" class="form-label">Nama Role</label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" id="nama"
                                placeholder="Masukan nama Role" name="name" value="{{ old('name') }}" />
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="permission" class="form-label">Hak Akses</label>
                            <select class="fstdropdown-select @error('permission') is-invalid @enderror"
                                name="permission[]" id="permission" multiple>
                                @foreach ($permissions as $permission)
                                <option value="{{ $permission->id }}">{{ str_replace('_', ' ', $permission->name) }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @error('permission')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Buat Role</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endcan
@endsection

@push('js')
@if($errors->any())
<script>
    $(document).ready(function(){
        $('#modalRole').modal('show');
    })
</script>
@endif
<script>
    $('#tab-main .a-tab').on('click', function (e) {
        console.log('oke')
        e.preventDefault()
        $('#tab-main a').removeClass('active');
        $('.tab-pane').removeClass('active');
        if ($(this).parent()[0].closest('.dropdown-menu')) {
            $(this).parent().parent().addClass('active')
        }
        $(this).addClass('active');
        $(`.tab-pane${$(this).attr('href')}`).addClass('active');
    })
</script>
@endpush