@extends('layouts.app', ['title' => 'Dashboard'])
@section('content')
<div class="row">
    <div class="col">
        <div class="row row-cols-1 row-cols-sm-3 row-cols-md-3 row-cols-xl-3 row-cols-xxl-6">
        <div class="card radius-10">
          <div class="card-body text-center">
            <div class="widget-icon mx-auto mb-3 bg-light-success text-success">
          <i class="bi bi-people-fill"></i>
        </div>
        <p class="mb-0">New Members</p>
         <h3 class="mt-4 mb-0">{{$usertotal}}</h3>
      </div>
    </div>
  </div>
</div>
</div>
  @endsection