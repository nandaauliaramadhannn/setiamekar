@extends('layouts.app', ['title' => 'Edit Profile Puskesmas'])

@section('content')
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Profile Puskesmas</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="#"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col mx-auto">
        <h6 class="mb-0 text-uppercase">Edit Profile Puskesmas</h6>
        <hr/>
        <div class="card">
            <div class="card-body">
                <div class="p-4 border rounded">
                    <form action="{{ route('admin.backend.about.update', $data->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Judul Section</label>
                                <input type="text" name="title" class="form-control" value="{{ old('title', $data->title) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Urutan</label>
                                <input type="number" name="order" class="form-control" value="{{ old('order', $data->order) }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Isi Konten</label>
                                <textarea name="content" class="form-control" rows="5" required>{{ old('content', $data->content) }}</textarea>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">Update</button>
                                <a href="{{ route('admin.backend.about.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
