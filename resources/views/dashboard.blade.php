@extends('mylayouts.main')

@push('css')
<style>
    .title {
        font-weight: 500;
    }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between mb-3 align-items-center">
    <h4><strong>Dashboard</strong></h4>
</div>
@if (Auth::user()->hasRole('super_admin'))
<div class="card">
    <div class="card-body">

    </div>
</div>
@else
<div class="card mb-3" style="min-height: 17rem;overflow: auto;">
    <div class="card-body">
        <div class="title" style="display: flex; justify-content: space-between">
            <h4 class="card-title">Profile Sekolah</h4>
            @if (auth()->user()->can('edit_sekolah'))
            <x-ButtonCustom class="btn btn-warning btn-sm rounded" route="{{ route('sekolah.edit.own') }}">
                Edit
            </x-ButtonCustom>
            @endif
        </div>
        <div class="row">
            <div class="col-lg-9">
                <table class="table table-responsive table-borderless">
                    <tr>
                        <td class="title">Nama Sekolah</td>
                        <td>:</td>
                        <td>{{ Auth::user()->sekolah->nama }}</td>
                    </tr>
                    <tr>
                        <td class="title">NPSN</td>
                        <td>:</td>
                        <td>{{ Auth::user()->sekolah->npsn }}</td>
                    </tr>
                    <tr>
                        <td class="title">Kepala Sekolah</td>
                        <td>:</td>
                        <td>{{ Auth::user()->sekolah->kepala_sekolah }}</td>
                    </tr>
                    <tr>
                        <td class="title">Alamat</td>
                        <td>:</td>
                        <td>{{ Auth::user()->sekolah->jalan }},{{ Auth::user()->sekolah->kelurahan->nama }},{{
                            Auth::user()->sekolah->kecamatan->nama }}, {{ Auth::user()->sekolah->kabupaten->nama }}, {{
                            Auth::user()->sekolah->provinsi->nama }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-lg-3">
                <img src="{{ Auth::user()->sekolah->logo != '/img/tutwuri.png' ? asset('storage/' . Auth::user()->sekolah->logo) : Auth::user()->sekolah->logo }}"
                    alt="" scale="1/1" style="width: 10rem; object-fit: cover; border-radius: 5px; display: block;">
            </div>
        </div>
    </div>
</div>
@if (auth()->user()->can('view_users') || auth()->user()->can('view_kompetensi'))
<div class="container-fluid p-0">
    <div class="row">
        @if (auth()->user()->can('view_users'))
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Data User</h4>
                    <canvas id="user"></canvas>
                </div>
            </div>
        </div>
        @endif
        @if (auth()->user()->can('view_kompetensi'))
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-body">
                    <h4 class="card-title">Kompetensi</h4>
                    <canvas id="kompetensi"></canvas>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endif

@if (auth()->user()->can('view_kelas'))
<div class="container-fluid p-0 mb-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="min-height: 15rem;">
                <div class="card-body">
                    <h4 class="card-title">Kelas</h4>
                    <canvas id="kelas"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endif
@endsection

@push('js')
<script src="{{ asset('js/Chart.min.js') }}"></script>
@if (auth()->user()->can('view_users'))
{{-- !Data User --}}
<script>
    const data = {
        labels: {!! json_encode($users['key']) !!},
        datasets: [{
        label: 'Total',
        data: {!! json_encode($users['data']) !!},
        backgroundColor: [
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.5)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
        borderWidth: 1,
        fill: false
        }]
    };

    const options = {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        },
        legend: {
            display: false
        },
        elements: {
            point: {
                radius: 0
            }
        }
    };

    const barChartCanvas = $("#user").get(0).getContext("2d");
    const barChart = new Chart(barChartCanvas, {
      type: 'bar',
      data: data,
      options: options
    });
</script>
@endif

@if (auth()->user()->can('view_kompetensi'))
{{-- !Kompetensi --}}
<script>
    const dataKompetensi = {
        datasets: [{
            data: {!! json_encode($kompetensis['data']) !!},
            backgroundColor: [
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.5)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
        }],

        labels: {!! json_encode($kompetensis['key']) !!}
    };
    const optionKompetensi = {
        responsive: true,
        animation: {
            animateScale: true,
            animateRotate: true
        }
    };

    const pieChartCanvas = $("#kompetensi").get(0).getContext("2d");
    const pieChart = new Chart(pieChartCanvas, {
      type: 'pie',
      data: dataKompetensi,
      options: optionKompetensi
    });
</script>
@endif

@if (auth()->user()->can('view_kelas'))
{{-- !Data Kelas --}}
<script>
    const data_kelas = {
        labels: {!! json_encode($kelas['key']) !!},
        datasets: [{
        label: 'Total siswa',
        data: {!! json_encode($kelas['data']) !!},
        backgroundColor: [
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.5)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
        borderWidth: 1,
        fill: false
        }]
    };

    const options_kelas = {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        },
        legend: {
            display: false
        },
        elements: {
            point: {
                radius: 0
            }
        }
    };

    const kelasChartCanvas = $("#kelas").get(0).getContext("2d");
    new Chart(kelasChartCanvas, {
      type: 'bar',
      data: data_kelas,
      options: options_kelas
    });
</script>
@endif
@endpush