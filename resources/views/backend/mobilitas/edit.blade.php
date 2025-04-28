@extends('layouts.app', ['title' => 'Edit Mobilitas'])

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-body">
                <h5>Edit Mobilitas</h5>

                <form action="{{ route('mobilitas.update', $mobilitas->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nama Pegawai</label>
                        <input type="text" class="form-control" value="{{ $mobilitas->nama_pegawai }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="text" class="form-control" value="{{ $mobilitas->hari }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jam</label>
                        <input type="text" class="form-control" value="{{ $mobilitas->jam }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control" required>
                            <option value="verifikasi" {{ $mobilitas->status == 'verifikasi' ? 'selected' : '' }}>Verifikasi</option>
                            <option value="disetujui" {{ $mobilitas->status == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="ditolak" {{ $mobilitas->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pegawai Pengganti (Jika Ada)</label>
                        <select name="pegawai_pengganti_id" class="form-control">
                            <option value="">-- Pilih Pegawai Pengganti --</option>
                            @foreach($pegawai as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Biarkan kosong jika tidak ada pengganti</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan Perubahan (Opsional)</label>
                        <textarea name="keterangan_history" class="form-control" rows="3" placeholder="Tulis alasan atau catatan penunjukan..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('backend.mobilitas.pegawa.index') }}" class="btn btn-secondary">Kembali</a>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
