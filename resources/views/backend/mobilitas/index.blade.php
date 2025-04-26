@extends('layouts.app',['title' => 'Data Mobilitas Pegawai'])

@section('content')

<div class="row">
    <div class="col-12 col-lg-12">
        <div class="card radius-10">
            <div class="card-body">
                <div class="row row-cols-1 row-cols-lg-2 g-3 align-items-center">
                    <div class="col">
                        <h5 class="mb-0">Mobilitas Pegawai</h5>
                    </div>
                    <div class="col d-flex justify-content-end">
                        @if(Auth::user()->role !== 'admin' && Auth::user()->role !== 'superadmin')
                            <a href="{{ route('mobilitas.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Tambah Mobilitas
                            </a>
                        @endif
                    </div>
                    <div class="col">
                        <form method="GET" action="" class="d-flex align-items-center justify-content-end gap-2">
                            <input type="date" name="date" value="{{ request('date') }}" class="form-control" onchange="this.form.submit()">
                            <select name="keterangan" class="form-control" onchange="this.form.submit()">
                                <option value="">Semua</option>
                                <option value="hadir" {{ request('keterangan') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                <option value="izin" {{ request('keterangan') == 'izin' ? 'selected' : '' }}>Izin</option>
                            </select>
                        </form>
                    </div>
                </div>

                <form class="mt-3">
                    <div class="position-relative">
                        <div class="position-absolute top-50 translate-middle-y search-icon px-3">
                            <i class="bi bi-search"></i>
                        </div>
                        <input class="form-control ps-5" type="text" id="search" placeholder="Cari pegawai...">
                    </div>
                </form>

                <div id="mobilitas-list" class="row mt-3 g-3">
                    @foreach($mobilitas as $item)
                    <div class="col-md-6">
                        <div class="card border">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1">{{ $item->nama_pegawai }}</h6>
                                        <small class="text-muted">{{ $item->hari }}, {{ $item->jam }}</small>
                                    </div>
                                    <div>
                                        <span class="badge
                                            {{ $item->status == 'verifikasi' ? 'bg-warning text-dark' : '' }}
                                            {{ $item->status == 'ditolak' ? 'bg-danger' : '' }}
                                            {{ $item->status == 'disetujui' ? 'bg-success' : '' }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="mt-2">
                                    <p class="mb-1"><strong>Keterangan:</strong> {{ ucfirst($item->keterangan) }}</p>

                                    @if($item->keterangan == 'izin')
                                        <p class="mb-1"><strong>Alasan:</strong> {{ $item->alasan }}</p>
                                        @if($item->file_izin)
                                            <p><a href="{{ asset('storage/' . $item->file_izin) }}" target="_blank">📎 Lihat File Izin</a></p>
                                        @endif
                                        @if($item->jam_izin)
                                            <p class="mb-0"><strong>Jam Izin:</strong> {{ $item->jam_izin }}</p>
                                        @endif
                                    @elseif($item->keterangan == 'hadir' && $item->file_eviden)
                                        <p><a href="{{ asset('storage/' . $item->file_eviden) }}" target="_blank">📎 Lihat File Eviden</a></p>
                                    @endif
                                </div>

                                @if(Auth::user()->role === 'admin' || Auth::user()->role === 'superadmin')
                                    @if($item->status == 'verifikasi')
                                        <div class="mt-3 d-flex gap-2">
                                            <form action="{{ route('mobilitas.verifikasi', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button class="btn btn-sm btn-success" onclick="return confirm('Verifikasi mobilitas ini?')">disetujui</button>
                                            </form>
                                            <form action="{{ route('mobilitas.tolak', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button class="btn btn-sm btn-danger" onclick="return confirm('Tolak mobilitas ini?')">Tolak</button>
                                            </form>
                                            <a href="#" class="btn btn-primary">detail</a>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>

                    @endforeach
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('search').addEventListener('keyup', function () {
        let keyword = this.value;
        fetch(`{{ url()->current() }}?search=` + keyword)
            .then(response => response.text())
            .then(data => {
                let parser = new DOMParser();
                let html = parser.parseFromString(data, 'text/html');
                let result = html.getElementById('mobilitas-list');
                document.getElementById('mobilitas-list').innerHTML = result.innerHTML;
            });
    });
</script>
@endsection
