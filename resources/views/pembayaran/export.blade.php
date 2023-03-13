<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pembayaran</title>
    <style>
        @font-face {
            font-family: 'Roboto';
            font-weight: bold;
            src: url({{ storage_path('/fonts/Roboto-Bold.ttf')}}) format("truetype");
        }

        * {
            font-family: 'Roboto';
        }

        .table {
            table-layout: auto;
            width: 100%;
            font-family: 'arial';
            text-align: center;
        }

        .table, .table th, .table td {
            border: 1px solid rgb(119, 119, 119);
            border-collapse: collapse;
            padding: 5px auto
        }

    </style>
</head>

<body>
    <h2 style="text-align: center;">Laporan Pembayaran SPP</h2>
    <table>
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>{{ $user->name }}</td>
        </tr>
        <tr>
            <td>Kelas</td>
            <td>:</td>
            <td>{{ $user->romawi }} {{ $user->kelas }}</td>
        </tr>
    </table>

    <table class="table">
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Nominal</th>
                <th>Status</th>
                <th>Diterima Oleh</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pembayarans['response'] as $pembayaran)
            <tr>
                <td>{{ $pembayaran['bulan'] }}</td>
                <td>Rp.{{ $user->nominal }}</td>
                <td>{!! $pembayaran['status'] !!}</td>
                <td>{{ $pembayaran['diterima_oleh'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="display: flex;justify-content: space-between;">
        <div>Sudah dibayar: <strong>{{ $pembayarans['status_pembayaran'][0]->sudah_dibayar }}</strong></div>
        <div>Sisa Pembayaran: <strong>{{ $pembayarans['status_pembayaran'][0]->sisa_pembayaran }}</strong></div>
    </div>
</body>

</html>