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
            @foreach (config('services.bulan') as $key => $bulan)
            <th align="center" style="border: 1px solid black;">{{ $user['pembayarans'][$key+1] ? 'v' : '' }}</th>
            @endforeach
            <td align="center" style="border: 1px solid black;">{{ count(array_keys($user['pembayarans'], true)) * $user->nominal }}</td>
            <td align="center" style="border: 1px solid black;">{{ count(array_keys($user['pembayarans'], false)) * $user->nominal }}</td>
        </tr>
        @endforeach
    </tbody>
</table>