 @extends('layouts.app', ['title' => 'User'])
 @section('content')
 <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">User</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Index User</li>
            </ol>
        </nav>
    </div>
    <div class="ms-auto">
        <div class="btn-group">
           <a href="{{ route('admin.backend.user.create') }}" class="btn btn-primary" >  Tambah User</a>
        </div>
    </div>
</div>
<h6 class="mb-0 text-uppercase"> User Tabel</h6>
				<hr/>
                 <div class="card" >
                     <div class="card-body" >
                          <div class="table-responsive">
                             <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Departemen</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->role }}</td>
                                        <td>{{ $item->departemen->name ?? '-' }}</td>
                                        <td>
                                            <!-- Tombol Edit -->
                                            <a href="{{ route('admin.backend.user.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>

                                            <!-- Tombol Delete -->
                                            <button onclick="confirmDelete({{ $item->id }})" class="btn btn-danger btn-sm">Delete</button>

                                            <!-- Form Delete (hidden) -->
                                            <form id="delete-form-{{ $item->id }}" action="{{ route('admin.backend.user.destroy', $item->id) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
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
     </div>
 @endsection
