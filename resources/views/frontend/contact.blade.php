@extends('layouts.frontend.app', ['judul' => 'Contact Us'])

@section('content')
<section class="contact-wrap-layout">
    <div class="container">
        <div class="contact-map-area mb-4">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.0789218859118!2d107.04309537407916!3d-6.253332161224466!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e698ef42ff223ff%3A0xd5fb023e54e6ba13!2sPUSKESMAS%20SETIAMEKAR!5e0!3m2!1sid!2sid!4v1747437643582!5m2!1sid!2sid"
                width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="contact-box-layout1">
                    <h3 class="title title-bar-primary4">Leave Us Message</h3>
                    <form class="contact-form-box" id="contact-form" method="POST" action="{{ route('contact.send') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <input type="text" placeholder="First Name *" class="form-control" name="first_name" required>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="col-md-6 form-group">
                                <input type="text" placeholder="Last Name *" class="form-control" name="last_name" required>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="col-md-6 form-group">
                                <input type="email" placeholder="E-mail *" class="form-control" name="email" required>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="col-md-6 form-group">
                                <input type="text" placeholder="Phone *" class="form-control" name="phone" required>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="col-12 form-group">
                                <textarea placeholder="Message*" class="textarea form-control" name="message" rows="7" required></textarea>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="col-12 form-group margin-b-none">
                                <button type="submit" class="item-btn">Submit Message</button>
                            </div>
                        </div>
                        <div class="form-response"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
