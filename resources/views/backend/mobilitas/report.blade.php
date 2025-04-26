@extends('layouts.app', ['title' => 'Laporan Mobilitas Mingguan'])

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-body">
                <h5>Laporan Mobilitas Pegawai</h5>

                <form method="GET" class="row g-3">
                    <div class="col-md-5">
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date', $startOfWeek->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-5">
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date', $endOfWeek->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary w-100" type="submit">Filter</button>
                    </div>
                </form>

                @if($mobilitas->count() > 0)
                <div class="mt-3">
                    <form method="GET" action="{{ route('mobilitas.report-pdf') }}" target="_blank" class="mt-3">
                        <input type="hidden" name="start_date" value="{{ request('start_date', $startOfWeek->format('Y-m-d')) }}">
                        <input type="hidden" name="end_date" value="{{ request('end_date', $endOfWeek->format('Y-m-d')) }}">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-download"></i> Download PDF
                        </button>
                    </form>
                </div>
                @endif

                <div class="table-responsive mt-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Pegawai</th>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mobilitas as $item)
                            <tr>
                                <td>{{ $item->nama_pegawai }}</td>
                                <td>{{ $item->hari }}</td>
                                <td>{{ $item->jam }}</td>
                                <td>{{ ucfirst($item->keterangan) }}</td>
                                <td>
                                    <span class="badge
                                        {{ $item->status == 'verifikasi' ? 'bg-warning text-dark' : '' }}
                                        {{ $item->status == 'ditolak' ? 'bg-danger' : '' }}
                                        {{ $item->status == 'disetujui' ? 'bg-success' : '' }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
