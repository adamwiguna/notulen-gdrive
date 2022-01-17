<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link {{$sidebar == 'dashboard' ? 'active' :''}}" aria-current="page" href="{{ route('operator.dashboard') }}">
            <i class="bi bi-house-door"></i>
            Dashboard
          </a>
        </li>
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          <span>Operator</span>
        </h6>
        <hr class="my-0">
  
        {{-- <li class="nav-item">
          <a class="nav-link  {{$sidebar == 'division' ? 'active' :''}}" href="{{ route('operator.division.index') }}">
            <i class="bi bi-diagram-3"></i>
            Kelola Bidang/Bagian
          </a>
        </li> --}}
        <li class="nav-item">
          <a class="nav-link  {{$sidebar == 'position' ? 'active' :''}}" href="{{ route('operator.position.index') }}">
            <i class="bi bi-person-workspace"></i>
            Kelola Jabatan
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link  {{$sidebar == 'user' ? 'active' :''}}" href="{{ route('operator.user.index') }}">
            <i class="bi bi-person-fill"></i>
            Kelola User
          </a>
        </li>
        {{-- <li class="nav-item">
          <a class="nav-link  {{$sidebar == 'mutasi' ? 'active' :''}}" href="{{ route('operator.user.mutasi') }}">
            <i class="bi bi-person-fill"></i>
            Mutasi User
          </a>
        </li> --}}

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          <span>Account Settings</span>
        </h6>
        <hr class="my-0">
        <li class="nav-item">
          <a class="nav-link  {{$sidebar == 'user' ? 'active' :''}}s" href="#">
            <i class="bi bi-key-fill"></i>
            Ganti Password
          </a>
        </li>
      </ul>

      
    </div>
    
  </nav>