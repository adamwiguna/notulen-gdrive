<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Notulen · Halaman Log In</title>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

    <!-- Bootstrap core CSS -->
    <link href="/assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
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
    </style>

    
    <!-- Custom styles for this template -->
    <link href="/css/signin.css" rel="stylesheet">
</head>
<body class="text-center">

  <main class="form-signin">
  
  <img class="mb-4" src="/Lambang_Kabupaten_Tabanan.png" alt="" width="150" height="150">
  <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

  @if (session()->has('loginError'))
  <div class="alert alert-danger alert-dismissible fade show text-start" role="alert">
      <i class="bi bi-exclamation-triangle"></i>
      {!! session('loginError') !!}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>   
  @endif

  <form action="/login" method="POST">
    @csrf

    <div class="form-floating">
      <input type="text" class="form-control rounded-0 rounded-top" id="floatingInput" placeholder="name@example.com" name="email">
      <label for="floatingInput">Username / N I P</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control rounded-0 rounded-bottom" id="floatingPassword" placeholder="Password" name="password">
      <label for="floatingPassword">Password</label>
    </div>

    {{-- <div class="checkbox mb-3">
      <label>
        <input type="checkbox" value="remember-me"> Remember me
      </label>
    </div> --}}
    <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2021–2022</p>
  </form>
</main>


    
  </body>
</html>
