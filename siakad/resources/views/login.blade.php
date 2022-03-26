<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> --}}
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    {{-- <link href="{{ asset('fontawesome/css/fontawesome.min.css') }}" rel="stylesheet" type="text/css"> --}}
    <link href="{{ asset('fontawesome/css/all.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">

    <title>Login Page</title>
  </head>
  <body>
    <section class="ftco-section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-6 col-lg-5">
            <div class="login-wrap p-4 p-md-5">
              <div class="icon d-flex align-items-center justify-content-center">
                <span class="far fa-user"></span>
              </div>
              <h3 class="text-center mb-4">Selamat Datang</h3>
              <div class="errorlogin"></div>
              {{-- <form class="login-form"> --}}
                <div class="login-form">
                {{-- @csrf --}}
                {{-- <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}"> --}}
                <div class="input-group mb-3 form-group">
                  <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                  <input type="text" class="form-control rounded-left" name="email" id="email" placeholder="Email" aria-describedby="basic-addon1" required>
                </div>
                <div class="input-group mb-3 form-group d-flex">
                  <span class="input-group-text" id="basic-addon1"><i class="fas fa-key"></i></span>
                  <input type="password" class="form-control rounded-left" name="password" id="password" placeholder="Password" aria-describedby="basic-addon1" required>
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-primary rounded submit px-5 p-3" onclick="login()">Login</button>
                </div>
              </div>
              {{-- </form> --}}
            </div>
          </div>
        </div>
      </div>
    </section>
  </body>
  <script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
  <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('popper/popper.min.js') }}"></script>
  <script src="{{ asset('js/login.js') }}"></script>
</html>