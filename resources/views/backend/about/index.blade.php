@extends('layouts.app', ['title' => 'Profile Puskesmas'])
@section('content')
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Profile Puskesmas</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Index Profile Puskesmas</li>
            </ol>
        </nav>
    </div>
    <div class="ms-auto">
        <div class="btn-group">
            <a href="{{route('admin.backend.about.create')}}" class="btn btn-primary">Tambah Profile Puskesmas</a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col mx-auto">
        <h6 class="mb-0 text-uppercase">Data Profile Puskesmas</h6>
        <hr />
        <div class="card" >
            <div class="card-body" >
                 <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Title</th>
                                <th>Content</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($about as $item)
                            <tr>
                                <td>{{$item->order}}</td>
                                <td>{{$item->title}}</td>
                                <td>{{$item->content}}</td>
                                <td>
                                    <a href="{{ route('admin.backend.about.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.backend.about.destroy', $item->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
