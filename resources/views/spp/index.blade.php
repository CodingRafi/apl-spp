@extends('mylayouts.main')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4><strong>SPP</strong></h4>
    @can('add_spp')
    @if (count($tahun_ajarans) > 0)
    <x-ButtonCustom class="btn btn-primary" route="{{ route('spp.create') }}">
        Tambah
    </x-ButtonCustom>
    @endif
    @endcan
</div>
<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr class="text-center">
                    <th scope="col">No</th>
                    <th scope="col">Tahun Ajaran</th>
                    <th scope="col">Nominal</th>
                    @if (auth()->user()->can('edit_spp') || auth()->user()->can('delete_spp'))
                    <th scope="col">Action</th>
                    @endif
                </tr>
            </thead>
            <tbody class="text-center">
                @foreach (Auth::user()->sekolah->spp as $spp)
                {{-- @dd($spp->pivot) --}}
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $spp->tahun_awal }} - {{ $spp->tahun_akhir }}</td>
                    <td>{{ $spp->pivot->nominal }}</td>
                    <td>
                        <a href="{{ route('spp.edit', $spp->pivot->id) }}" class="btn btn-sm btn-warning rounded">Edit</a>
                        <button type="button" class="btn btn-sm btn-danger rounded" onclick="deleteData('{{ route('spp.destroy', $spp->pivot->id) }}')">Hapus</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="upgradeKelas" tabindex="-1" aria-labelledby="upgradeKelasLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('kelas.upgrade') }}" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="upgradeKelasLabel">Upgrade Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="mb-3">
                        <label for="tahun_ajaran_id" class="form-label">Tahun Ajaran</label>
                        <select class="form-select" name="tahun_ajaran_id">
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kelas_id" class="form-label">Kelas</label>
                        <select class="form-select" name="kelas_id">
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="to_spp_id" class="form-label">Naik kelas ke</label>
                        <select class="form-select" name="to_spp_id">
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection