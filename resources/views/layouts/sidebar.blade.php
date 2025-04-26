<aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
      <div>
        <img src="assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
      </div>
      <div>
        <h4 class="logo-text">{{config('app.name')}}</h4>
      </div>
      <div class="toggle-icon ms-auto"><i class="bi bi-chevron-double-left"></i>
      </div>
    </div>
    <ul class="metismenu" id="menu">
      <li>
        <a href="{{route('dashboard')}}">
          <div class="parent-icon"><i class="bi bi-house-door"></i>
          </div>
          <div class="menu-title">Dashboard</div>
        </a>
      </li>

      <li class="menu-label">Management Kegiatan</li>
      <li>
        <a href="{{route('backend.index.renstra')}}">
            <div class="parent-icon"><i class="bi bi-clipboard-data-fill"></i>
            </div>
            <div class="menu-title">Rensra</div>
          </a>
      </li>
      <li>
        <a href="{{route('backend.mobilitas.pegawa.index')}}">
            <div class="parent-icon"><i class="bi bi-pc-display-horizontal"></i>
            </div>
            <div class="menu-title">Mobilitas Pegawai</div>
          </a>
      </li>
      @can('admin')
      <li class="menu-label">Management User</li>
      <li>
        <a href=" {{route('admin.backend.user.index')}}">
          <div class="parent-icon"><i class="bi bi-person-check"></i>
          </div>
          <div class="menu-title">Semua User</div>
        </a>
      </li>
      @endcan
    </ul>
 </aside>