@extends('layouts.frontend.app', ['judul' => 'Puskesmas Setiamekar'])

@section('content')

{{-- Hero Slider --}}
<div class="slider-area slider-layout1 bg-light-primary slider-top-margin">
    <div class="bend niceties preview-1">
        <div id="ensign-nivoslider-1" class="slides">
            @foreach ($sliders as $slider)
                @if($slider->is_active && $slider->image)
                    <img src="{{ asset('slider_images/' . $slider->image) }}"
                         alt="{{ $slider->title }}"
                         title="#slider-direction-{{ $loop->iteration }}"
                         style="width: 100%; height: 700px; object-fit: cover;">
                @endif
            @endforeach
        </div>

        @foreach ($sliders as $slider)
            @if($slider->is_active)
                <div id="slider-direction-{{ $loop->iteration }}" class="t-cn slider-direction">
                    <div class="slider-content s-tb slide-{{ $loop->iteration }}">
                        <div class="text-left title-container s-tb-c">
                            <div class="container">
                                <div class="slider-big-text padding-right">{{ $slider->title }}</div>
                                <p class="slider-paragraph padding-right">{{ $slider->description }}</p>
                                <div class="slider-btn-area">
                                    <a href="#" class="item-btn">Read More<i class="fas fa-chevron-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>

{{-- Layanan Section --}}
<section class="departments-wrap-layout2 bg-light-secondary100">
    <img class="left-img img-fluid" src="{{ asset('frontend/img/figure/figure8.png') }}" alt="figure">

    <div class="container">
        <div class="section-heading heading-dark text-left heading-layout1">
            <h2>Layanan</h2>
            <p>Layanan yang tersedia di Puskesmas Setiamekar</p>
            <div id="owl-nav1" class="owl-nav-layout1">
                <span class="rt-prev"><i class="fas fa-chevron-left"></i></span>
                <span class="rt-next"><i class="fas fa-chevron-right"></i></span>
            </div>
        </div>

        <div class="rc-carousel nav-control-layout2"
            data-loop="true"
            data-items="4"
            data-margin="20"
            data-autoplay="false"
            data-autoplay-timeout="5000"
            data-custom-nav="#owl-nav1"
            data-smart-speed="2000"
            data-dots="false"
            data-nav="false"
            data-r-x-small="1"
            data-r-x-medium="2"
            data-r-small="2"
            data-r-medium="3"
            data-r-large="4"
            data-r-extra-large="4">

            @foreach ($layanans as $layanan)
                <div class="departments-box-layout2">
                    <span class="departments-sl">{{ $layanan->urutan }}.</span>
                    <div class="item-icon"><i class="{{ $layanan->ikon }}"></i></div>
                    <h3 class="item-title"><a href="#">{{ $layanan->nama }}</a></h3>
                    <p>{{ $layanan->deskripsi }}</p>
                </div>
            @endforeach

        </div>
    </div>
</section>

@endsection
