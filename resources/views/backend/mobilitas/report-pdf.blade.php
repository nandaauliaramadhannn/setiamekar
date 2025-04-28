<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Mobilitas Pegawai</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; }
        .badge { padding: 3px 6px; border-radius: 4px; font-size: 10px; }
        .bg-warning { background-color: #ffc107; color: #212529; }
        .bg-danger { background-color: #dc3545; color: #fff; }
        .bg-success { background-color: #28a745; color: #fff; }
    </style>
</head>
<body>

    <h2 style="text-align: center;">Laporan Mobilitas Pegawai</h2>
    <p>Periode: {{ $startOfWeek->format('d M Y') }} - {{ $endOfWeek->format('d M Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>Nama Pegawai</th>
                <th>Nama Kegiatan</th>
                <th>Lokasi</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Keterangan</th>
                <th>Status</th>
                <th>History Penunjukan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($mobilitas as $item)
            <tr>
                <td>{{ $item->nama_pegawai }}</td>
                <td>{{$item->nama_kegiatan}}</td>
                <td>{{$item->lokasi}}</td>
                <td>{{ $item->hari }}</td>
                <td>{{ $item->jam }}</td>
                <td>{{ ucfirst($item->keterangan) }}</td>
                <td>
                    <span class="badge
                        {{ $item->status == 'verifikasi' ? 'bg-warning' : '' }}
                        {{ $item->status == 'ditolak' ? 'bg-danger' : '' }}
                        {{ $item->status == 'disetujui' ? 'bg-success' : '' }}">
                        {{ ucfirst($item->status) }}
                    </span>
                </td>
                <td>
                    @if($item->histories->count())
                        @foreach($item->histories as $history)
                            <div style="margin-bottom: 5px;">
                                <strong>Awal:</strong> {{ $history->pegawaiAwal->name ?? '-' }}<br>
                                <strong>Pengganti:</strong> {{ $history->pegawaiPengganti->name ?? '-' }}<br>
                                <strong>Oleh:</strong> {{ $history->updater->name ?? '-' }}<br>
                                <strong>Keterangan:</strong> {{ $history->keterangan ?? '-' }}
                            </div>
                        @endforeach
                    @else
                        Tidak ada penunjukan
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
