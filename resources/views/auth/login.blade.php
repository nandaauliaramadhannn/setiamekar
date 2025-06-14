<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{asset('template')}}/images/favicon-32x32.png" type="image/png" />
    <link href="{{asset('template')}}/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{{asset('template')}}/css/bootstrap-extended.css" rel="stylesheet" />
    <link href="{{asset('template')}}/css/style.css" rel="stylesheet" />
    <link href="{{asset('template')}}/css/icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../../../../cdn.jsdelivr.net/npm/bootstrap-icons%401.5.0/font/bootstrap-icons.css">
      <link href="{{asset('template')}}/css/pace.min.css" rel="stylesheet" />
    <title>{{config('app.name')}}</title>
  </head>
  <body>
    <div class="wrapper">
        @include('sweetalert::alert')
         <main class="authentication-content">
          <div class="container-fluid">
            <div class="authentication-card">
              <div class="card shadow rounded-0 overflow-hidden">
                <div class="row g-0">
                  <div class="col-lg-6 bg-login d-flex align-items-center justify-content-center">
                    <img src="{{asset('template')}}/images/error/login-img.jpg" class="img-fluid" alt="">
                  </div>
                  <div class="col-lg-6">
                    <div class="card-body p-4 p-sm-5">
                      <h5 class="card-title">Login Puskesmas Setia Mekar</h5>
                      <p class="card-text mb-5">Kab Bekasi</p>
                      <form class="form-body" action="{{ route('login.post') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="inputEmailAddress" class="form-label">Email Address</label>
                                <div class="ms-auto position-relative">
                                    <div class="position-absolute top-50 translate-middle-y search-icon px-3">
                                        <i class="bi bi-envelope-fill"></i>
                                    </div>
                                    <input type="email" name="email" class="form-control radius-30 ps-5" id="inputEmailAddress" placeholder="Email Address" required value="{{ old('email') }}">
                                </div>
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="inputChoosePassword" class="form-label">Enter Password</label>
                                <div class="ms-auto position-relative">
                                    <div class="position-absolute top-50 translate-middle-y search-icon px-3">
                                        <i class="bi bi-lock-fill"></i>
                                    </div>
                                    <input type="password" name="password" class="form-control radius-30 ps-5" id="inputChoosePassword" placeholder="Enter Password" required>
                                </div>
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                    <label class="form-check-label" for="remember">Remember Me</label>
                                </div>
                            </div>
                            <div class="col-6 text-end">
                                <a href="#">Forgot Password?</a>
                            </div>

                            <div class="col-12">
                                <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                                @error('g-recaptcha-response')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-12">
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary radius-30">Sign In</button>
                                </div>
                            </div>
                        </div>
                    </form>

                   </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
         </main>
    </div>
    <script src="{{asset('template')}}/js/jquery.min.js"></script>
    <script src="{{asset('template')}}/js/pace.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  </body>
  </html>
