@extends('mylayouts.main')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4><strong>Tahun Ajaran</strong></h4>
    <a href="{{ route('tahun-ajaran.create') }}" 
    class="btn btn-primary text-white float-right">Tambah</a>
</div>
<div class="card">
    <div class="card-body">
        <div class="table table-responsive table-hover text-center mt-2">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Tahun Awal</th>
                        <th scope="col">Tahun Akhir</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tahun_ajarans as $tahun_ajaran)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $tahun_ajaran->tahun_awal }}</td>
                        <td>{{ $tahun_ajaran->tahun_akhir }}</td>
                        <td>{{ $tahun_ajaran->status }}</td>
                        <td>
                            <a href="{{ route('tahun-ajaran.edit', [$tahun_ajaran->id]) }}" 
                                class="btn btn-sm btn-warning text-white px-3">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection