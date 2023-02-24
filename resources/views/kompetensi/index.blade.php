@extends('mylayouts.main')

@section('content')
<div class="d-flex justify-content-between mb-2">
    <h4><strong>Kompetensi</strong></h4>
    @can('add_kompetensi')
        @if (count($tahun_ajarans) > 0)  
        <form action="{{ route('kompetensi.create') }}" method="get">
            @include('mypartials.tahunajaran')
            <button class="btn btn-primary">Tambah</button>
        </form>
        @endif
    @endcan
</div>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr class="text-center">
                        <th scope="col">No</th>
                        <th scope="col">Kompetensi Keahlian</th>
                        <th scope="col">Program Keahlian</th>
                        <th scope="col">Bidang Keahlian</th>
                        @if (auth()->user()->can('edit_kompetensi') || auth()->user()->can('delete_kompetensi'))
                        <th scope="col">Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kompetensis as $kompetensi)
                    <tr class="text-center">
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $kompetensi->kompetensi }}</td>
                        <td>{{ $kompetensi->program }}</td>
                        <td>{{ $kompetensi->bidang }}</td>
                        @if (auth()->user()->can('edit_kompetensi') || auth()->user()->can('delete_kompetensi'))   
                        <td>
                            @if (auth()->user()->can('edit_kompetensi'))   
                            <form action="{{ route('kompetensi.edit', [$kompetensi->id]) }}" method="get">
                                @include('mypartials.tahunajaran')
                                <button type="submit" class="btn btn-sm btn-warning text-white" style="width: 5rem; margin: 0.1rem;border-radius: 5px;font-weight: 500;">Edit</button>
                            </form>
                            @endif
                            @if (auth()->user()->can('delete_kompetensi'))
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="deleteData('{{ route('kompetensi.destroy', [$kompetensi->id]) }}')" style="width: 5rem; margin: 0.1rem;border-radius: 5px;font-weight: 500;">Hapus</button>
                            @endif
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection