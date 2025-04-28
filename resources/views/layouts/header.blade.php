<header class="top-header">
    <nav class="navbar navbar-expand">
      <div class="mobile-toggle-icon d-xl-none">
        <i class="bi bi-list"></i>
      </div>

      <!-- TAMPILKAN TANGGAL & WAKTU DI SEMUA LAYAR -->
      <div class="top-navbar">
        <p id="datetime-jakarta" class="mb-0 fw-bold"></p>
      </div>

      <!-- HAPUS ICON SEARCH DI MOBILE -->
      <!-- <div class="search-toggle-icon d-xl-none ms-auto">
        <i class="bi bi-search"></i>
      </div> -->

      <!-- FORM SEARCH DIHILANGKAN (JIKA TIDAK DIGUNAKAN) -->
      <!-- <form class="searchbar d-none d-xl-flex ms-auto"></form> -->

      <div class="top-navbar-right ms-auto">
        <ul class="navbar-nav align-items-center">
          <li class="nav-item dropdown dropdown-large">
            <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
              <div class="user-setting d-flex align-items-center gap-1">
                <img src="{{asset('template')}}/images/avatars/avatar-1.png" class="user-img" alt="">
                <div class="user-name d-none d-sm-block">{{Auth::user()->name}}</div>
              </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <a class="dropdown-item" href="#">
                  <div class="d-flex align-items-center">
                    <img src="{{asset('template')}}/images/avatars/avatar-1.png" alt="" class="rounded-circle" width="60" height="60">
                    <div class="ms-3">
                      <h6 class="mb-0 dropdown-user-name">{{Auth::user()->name}}</h6>
                      <small class="mb-0 dropdown-user-designation text-secondary">{{Auth::user()->role}}</small>
                    </div>
                  </div>
                </a>
              </li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <a class="dropdown-item" href="{{route('profile.edit')}}">
                  <div class="d-flex align-items-center">
                    <div class="setting-icon"><i class="bi bi-person-fill"></i></div>
                    <div class="setting-text ms-3"><span>Profile</span></div>
                  </div>
                </a>
              </li>
              <li>
                <form action="{{ route('logout') }}" method="POST">
                  @csrf
                  <button type="submit" class="dropdown-item">
                    <div class="d-flex align-items-center">
                      <div class="setting-icon"><i class="bi bi-box-arrow-right"></i></div>
                      <div class="setting-text ms-3"><span>Logout</span></div>
                    </div>
                  </button>
                </form>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
