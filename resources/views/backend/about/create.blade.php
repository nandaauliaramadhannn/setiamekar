@extends('layouts.app', ['title' => 'Create Profile Puskesmas'])

@section('content')
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Profile Puskesmas</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Profile Puskesmas</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col mx-auto">
        <h6 class="mb-0 text-uppercase">Add Profile Puskesmas</h6>
        <hr/>
        <div class="card">
            <div class="card-body">
                <div class="p-4 border rounded">
                    <form class="row g-3 needs-validation" action="{{ route('admin.backend.about.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                        @csrf

                        <!-- Section Title -->
                        <div class="col-md-12">
                            <label for="title" class="form-label">Section Title</label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" required value="{{ old('title') }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Section Content -->
                        <div class="col-md-12">
                            <label for="content" class="form-label">Section Content</label>
                            <textarea name="content" id="content" rows="5" class="form-control @error('content') is-invalid @enderror" required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Order -->
                        <div class="col-md-4">
                            <label for="order" class="form-label">Display Order</label>
                            <input type="number" name="order" id="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', 0) }}">
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit -->
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">Save Section</button>
                            <a href="{{ route('admin.backend.about.index') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
