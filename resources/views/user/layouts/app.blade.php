<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Notulen</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/offcanvas-navbar/">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
  
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="/css/trix.css">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
   

    @livewireStyles

    <style>

      .btn-outline-success:hover {
        text-decoration: none;
        color: green;
        background-color: transparent;
      }
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      ol,  ul {
        padding-left: 0.8rem;
      }

      trix-toolbar [data-trix-button-group="file-tools"]{
        display: none;
      }
      
      .trix-button--icon-attach{display: none;}
      .trix-button--icon-quote{display: none;}
      .trix-button--icon-heading-1{display: none;}
      .trix-button--icon-code{display: none;}

    </style>

    
    <!-- Custom styles for this template -->
    <link href="/css/offcanvas.css" rel="stylesheet">
  </head>
  <body class="bg-light">
    
<div class="">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" aria-label="Main navigation">
  <div class="container-fluid col-lg-6">
    <a class="navbar-brand" href="{{ route('user.dashboard') }}">Notulen </a>
    <button class="navbar-toggler p-0 border-0" type="button" id="navbarSideCollapse" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        {{-- <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="{{ route('user.dashboard') }}">{{ auth()->user()->name }}</a>
        </li> --}}
        <li class="nav-item">
          <a class="nav-link {{ Route::is(['user.dashboard']) ? 'active' : '' }}" aria-current="page" href="{{ route('user.dashboard') }}"><i class="bi bi-house-door"></i> Beranda</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Route::is(['user.password']) ? 'active' : '' }}" aria-current="page" href="{{ route('user.password') }}"><i class="bi bi-key"></i> Password</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Route::is(['user.setting']) ? 'active' : '' }}" aria-current="page" href="{{ route('user.setting') }}"><i class="bi bi-gear"></i> Profile</a>
        </li>
        
      </ul>
      <form class="d-flex" action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="btn btn-outline-danger" type="submit">Log Out</button>
      </form>
    </div>
  </div>
</nav>
{{-- <div class="nav-scroller bg-body shadow-sm ">
  <nav class="nav nav-underline col-lg-6 col-md-10 container-fluid" aria-label="Secondary navigation">
    <a class="nav-link {{ Route::is(['user.dashboard']) ? 'active' : '' }}" aria-current="page" href="{{ route('user.dashboard') }}"><i class="bi bi-house-door"></i> Beranda</a>
    <a class="nav-link {{ Route::is(['user.password']) ? 'active' : '' }}" aria-current="page" href="{{ route('user.password') }}"><i class="bi bi-key"></i> Password</a>
    <a class="nav-link {{ Route::is(['user.setting']) ? 'active' : '' }}" aria-current="page" href="{{ route('user.setting') }}"><i class="bi bi-gear"></i> Setting</a>
    <a class="nav-link" href="#">
      Friends
      <span class="badge bg-light text-dark rounded-pill align-text-bottom">27</span>
    </a>
  </nav>
</div> --}}

</div>

<main class="container px-0 col-lg-6">
 


  @yield('content')

  
</main>

{{-- <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

{{-- <script src="/js/bootstrap.bundle.min.js"></script> --}}
<script src="/js/offcanvas.js"></script>

<script type="text/javascript">
  $(document).ready(function() {
    $('#js-example-basic-single').select2();
  });
</script>
<script type="text/javascript" src="/js/trix.js"></script>
@livewireScripts
  </body>
</html>
