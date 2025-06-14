@extends('layouts.frontend.app', ['judul' => 'About Us'])

@section('content')
<section class="inner-page-banner bg-common inner-page-top-margin" data-bg-image="img/figure/figure2.jpg">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumbs-area">
                    <h1>About Us</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li>About</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="about-wrap-layout3">
    <div class="container">
        <div class="row" id="no-equal-gallery">
            <div class="sidebar-widget-area sidebar-break-md col-xl-3 col-lg-4 col-12 no-equal-item">
                <div class="widget widget-about-info">
                    <ul class="nav nav-tabs tab-nav-list">
                        @foreach($aboutSections as $index => $section)
                        <li class="nav-item">
                            <a href="#tab-{{ $section->id }}" data-toggle="tab"
                               class="nav-link {{ $index === 0 ? 'active' : '' }}"
                               aria-expanded="{{ $index === 0 ? 'true' : 'false' }}">
                                {{ $section->title }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8 no-equal-item">
                <div class="tab-content">
                    @foreach($aboutSections as $index => $section)
                    <div class="tab-pane fade {{ $index === 0 ? 'active show' : '' }}" id="tab-{{ $section->id }}">
                        <div class="about-box-layout5">
                            <h2 class="item-title">{{ $section->title }}</h2>
                            <p>{!! nl2br(e($section->content)) !!}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
