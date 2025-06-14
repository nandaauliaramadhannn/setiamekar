@extends('layouts.frontend.app', ['judul' => 'Layanan Puskesmas'])

@section('content')
<!-- Breadcrumb -->
<section class="inner-page-banner bg-common inner-page-top-margin" data-bg-image="img/figure/figure2.jpg">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumbs-area">
                    <h1>Semua Layanan</h1>
                    <ul>
                        <li>
                            <a href="{{ url('/') }}">Home</a>
                        </li>
                        <li>Layanan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- All Layanan -->
<section class="departments-wrap-layout5 bg-light-accent100">
    <div class="container">
        <div class="row gutters-20">
            @foreach ($layanans as $layanan)
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="departments-box-layout4">
                    <div class="box-content">
                        <i class="{{ $layanan->ikon }}"></i>
                        <h3 class="item-title"><a href="single-departments.html">{{$layanan->nama}}</a></h3>
                        <p>{{$layanan->deskripsi}}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $layanans->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
</section>
@endsection
