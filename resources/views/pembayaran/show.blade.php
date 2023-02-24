@extends('mylayouts.main')

@section('content')
<div class="d-flex justify-content-between mb-3 align-items-center">
    <div class="col-md-7">
        <h4><strong>Detail Pembayaran</strong></h4>
    </div>
    <div class="d-flex justify-content-end gap-2">
        @if (count($tahun_ajarans) > 0)
        <div class="col-md d-flex justify-content-end gap-2">
            @if (auth()->user()->can('export_pembayaran'))
            <x-ButtonCustom class="btn btn-primary" route="/export/pembayaran">
                Export
            </x-ButtonCustom>
            @endif
        </div>
        @can('add_pembayaran')
        <x-ButtonCustom class="btn btn-primary" route="{{ route('pembayaran.create', ['user_id' => request('user_id')]) }}">
            Tambah
        </x-ButtonCustom>
        @endcan
        <x-ButtonCustom class="btn btn-success" route="{{ route('pembayaran.export', ['user_id' => request('user_id')]) }}">
            Export
        </x-ButtonCustom>
        @can('export_pembayaran')
        @endcan
        <x-ButtonCustom class="btn btn-danger" route="{{ route('pembayaran.index') }}">
            Kembali
        </x-ButtonCustom>
        @endif
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="table table-responsive table-borderless table-hover d-flex" style="overflow-x: hidden;">
            <table class="table table-hover text-center">
                <thead>
                    <tr>
                        <th>Bulan</th>
                        <th>Status</th>
                        <th>Diterima Oleh</th>
                        @can('delete_pembayaran')
                        <th>Action</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pembayarans as $pembayaran)
                    <tr>
                        <td>{{ $pembayaran['bulan'] }}</td>
                        <td>{!! $pembayaran['status'] !!}</td>
                        <td>{{ $pembayaran['diterima_oleh'] }}</td>
                        @can('delete_pembayaran')
                        <td>
                            @if ($pembayaran['id'])
                            <button type="button" class="btn btn-sm btn-danger rounded" onclick="deleteData('{{ route('pembayaran.destroy', ['pembayaran_id' => $pembayaran['id'], 'user_id' => request('user_id')]) }}')">Hapus</button>
                            @endif
                        </td>
                        @endcan
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection