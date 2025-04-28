@extends('layouts.app', ['title' => 'Detail Mobilitas'])

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-body">
                <h5>Detail Mobilitas</h5>

                <table class="table">
                    <tr>
                        <th>Nama Pegawai</th>
                        <td>{{ $mobilitas->nama_pegawai }}</td>
                    </tr>
                    <tr>
                        <th>Nama Kegiatan</th>
                        <td>{{$mobilitas->nama_kegiatan}}</td>
                    </tr>
                    <tr>
                        <th>Lokasi</th>
                        <td>{{$mobilitas->lokasi}}</td>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <td>{{ $mobilitas->hari }}</td>
                    </tr>
                    <tr>
                        <th>Jam</th>
                        <td>{{ $mobilitas->jam }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge
                                {{ $mobilitas->status == 'verifikasi' ? 'bg-warning text-dark' : '' }}
                                {{ $mobilitas->status == 'ditolak' ? 'bg-danger' : '' }}
                                {{ $mobilitas->status == 'disetujui' ? 'bg-success' : '' }}">
                                {{ ucfirst($mobilitas->status) }}
                            </span>
                        </td>
                    </tr>
                </table>

                <hr>

                <h5>History Penunjukan Pegawai</h5>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Waktu Update</th>
                                <th>Pegawai Awal</th>
                                <th>Pegawai Pengganti</th>
                                <th>Admin Yang Menunjuk</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mobilitas->histories as $history)
                            <tr>
                                <td>{{ $history->created_at->format('d M Y H:i') }}</td>
                                <td>{{ $history->pegawaiAwal->name }}</td>
                                <td>{{ $history->pegawaiPengganti ? $history->pegawaiPengganti->name : '-' }}</td>
                                <td>{{ $history->updater->name }}</td>
                                <td>{{ $history->keterangan ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada history perubahan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <a href="{{ route('backend.mobilitas.pegawa.index') }}" class="btn btn-secondary mt-3">Kembali</a>

            </div>
        </div>
    </div>
</div>
@endsection
