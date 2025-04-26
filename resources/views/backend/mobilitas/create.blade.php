@extends('layouts.app', ['title' => 'Tambah Mobilitas Pegawai'])
@section('content')
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Mobilitas</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('backend.mobilitas.pegawa.index') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Mobilitas</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col mx-auto">
        <h6 class="mb-0 text-uppercase">Tambah Data Mobilitas</h6>
        <hr/>
        <div class="card">
            <div class="card-body">
                <div class="p-4 border rounded">
                    <form class="row g-3 needs-validation" action="{{ route('mobilitas.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="col-md-6">
                            <label for="nama_pegawai" class="form-label">Nama Pegawai</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
                        </div>

                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                        <div class="col-md-4">
                            <label for="hari" class="form-label">Hari</label>
                            <input type="text" class="form-control @error('hari') is-invalid @enderror" name="hari" value="{{ \Carbon\Carbon::now()->translatedFormat('l') }}" readonly>
                            @error('hari')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="jam" class="form-label">Jam</label>
                            <!-- Format jam menggunakan input time -->
                            <input type="time" class="form-control @error('jam') is-invalid @enderror" name="jam" value="{{ old('jam', \Carbon\Carbon::now()->format('H:i')) }}">
                            @error('jam')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <select class="form-select @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" required>
                                <option value="">Pilih</option>
                                <option value="hadir">Hadir</option>
                                <option value="izin">Izin</option>
                            </select>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Input khusus hadir --}}
                        <div id="hadirFields" class="col-md-9" style="display: none;">
                            <div class="mb-3">
                                <label for="file_eviden" class="form-label">Upload File Eviden (PDF/JPG/PNG)</label>
                                <input type="file" class="form-control" name="file_eviden" accept=".pdf,.jpg,.jpeg,.png">
                            </div>
                        </div>

                        {{-- Input khusus izin --}}
                        <div id="izinFields" class="col-md-9" style="display: none;">
                            <div class="mb-3">
                                <label for="alasan" class="form-label">Alasan Izin</label>
                                <textarea class="form-control" name="alasan">{{ old('alasan') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="jam_izin" class="form-label">Jam Izin</label>
                                <input type="time" class="form-control" name="jam_izin" value="{{ old('jam_izin') }}">
                            </div>

                            <div class="mb-3">
                                <label for="file_izin" class="form-label">Upload File Izin</label>
                                <input type="file" class="form-control" name="file_izin" accept=".pdf,.jpg,.jpeg,.png">
                            </div>
                        </div>

                        <div class="col-12">
                            <button class="btn btn-primary px-4">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT toggle keterangan --}}

@endsection
