<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Mazer Admin Dashboard</title>
    <link rel="canonical" href="https://www.wrappixel.com/templates/monster-admin-lite/" />
    <!-- Favicon icon -->
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>
    <div id="auth">
        <div class="row">
            <center>
                <div class="col-lg-3 col-12 mt-5 bg-light p-4  rounded-3">
                    <div >
                    {{-- <div class="auth-logo">
                        <a href="index.html"><img src="{{ asset('t_admin/assets/images/logo/logo.svg') }}"
                                alt="Logo" /></a>
                    </div> --}}
                    <h1 class="auth-title">Back-end</h1>
                    {{-- <p class="auth-subtitle mb-5">
                        Log in with your data that you entered during
                        registration.
                    </p> --}}
                     @if ($errors->any())
                        @foreach ($errors->all() as $err)
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ $err }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endforeach
                        @endif

                        <form action="/admin/auth/login" method="POST">
                            @csrf
                            <div class="form-group position-relative has-icon-left mb-4">
                                <input type="email" class="form-control form-control-xl" placeholder="Email"
                                    name="email" />
                                <div class="form-control-icon">
                                    <i class="bi bi-person"></i>
                                </div>
                            </div>
                            <div class="form-group position-relative has-icon-left">
                                <input type="password" class="form-control form-control-xl" placeholder="Password"
                                    name="password" />
                                <div class="form-control-icon">
                                    <i class="bi bi-shield-lock"></i>
                                </div>
                            </div>

                            <button class="btn btn-primary btn-md btn-block btn-lg shadow-lg btn-sm w-100 mt-3">
                                Log in
                            </button>
                        </form>

                    </div>
                </div>
            </center>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>
