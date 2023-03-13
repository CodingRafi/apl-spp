<table>
    <thead>
        <tr>
            <th align="center" style="border: 1px solid black;">No</th>
            <th align="center" style="border: 1px solid black;">Nama Lengkap</th>
            <th align="center" style="border: 1px solid black;">Kelas</th>
            <th align="center" style="border: 1px solid black;">Kompetensi</th>
            @foreach (config('services.bulan') as $bulan)
            <th align="center" style="border: 1px solid black;">{{ $bulan }}</th>
            @endforeach
            <th align="center" style="border: 1px solid black;">Total sudah dibayar</th>
            <th align="center" style="border: 1px solid black;">Total belum dibayar</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr>
            <td align="center" style="border: 1px solid black;">{{ $loop->iteration }}</td>
            <td align="center" style="border: 1px solid black;">{{ $user->name }}</td>
            <td align="center" style="border: 1px solid black;">{{ $user->romawi }} {{ $user->kelas }}</td>
            <td align="center" style="border: 1px solid black;">{{ $user->kompetensi }}</td>
            @foreach ($user['pembayarans']['response'] as $pembayaran)
            <th align="center" style="border: 1px solid black;">{{ $pembayaran['id'] ? 'v' : '' }}</th>
            @endforeach
            <td align="center" style="border: 1px solid black;">{{ $user['pembayarans']['status_pembayaran'][0]->sudah_dibayar }}</td>
            <td align="center" style="border: 1px solid black;">{{ $user['pembayarans']['status_pembayaran'][0]->sisa_pembayaran }}</td>
        </tr>
        @endforeach
    </tbody>
</table>