
<!doctype html>
<html lang="en">

    <head>

        <meta charset="utf-8" />
        <title>Login | Momopetshop</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesdesign" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="/assets/images/ico_momopetshop.ico">

        <!-- Bootstrap Css -->
        <link href="/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
        

    </head>

    
    <body>

    <!-- <body data-layout="horizontal"> -->

    <div class="authentication-bg min-vh-100">
        <div class="bg-overlay bg-light"></div>
        <div class="container">
            <div class="d-flex flex-column min-vh-100 px-3 pt-4">
                <div class="row justify-content-center my-auto">
                    <div class="col-md-8 col-lg-6 col-xl-5">

                        <div class="mb-4 pb-2">
                            <a href="index.html" class="d-block auth-logo">
                                <img src="/assets/images/logo_momopetshop.png" alt="" height="50" class="auth-logo-dark me-start">
                                <img src="/assets/images/logo_momopetshop.png" alt="" height="50" class="auth-logo-light me-start">
                            </a>
                        </div>

                        <div class="card">
                            <div class="card-body p-4"> 
                                <div class="text-center mt-2">
                                    <h5>Welcome Back !</h5>
                                    <p class="text-muted">Silahkan masuk ke momopetshop.</p>
                                </div>
                                <div class="p-2 mt-4">
                                    @if (session()->has('success'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <i class="mdi mdi-check-all me-2"></i>
                                            {{ session('success') }}!
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endif
                                    @if (session()->has('loginError'))
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <i class="mdi mdi-check-all me-2"></i>
                                            {{ session('loginError') }}!
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endif
                                    <form action="{{ route('aksilogin') }}" method="post">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label" for="username">Username</label>
                                            <div class="position-relative input-custom-icon">
                                                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="Masukan username" value="{{ old('username') }}">
                                                 <span class="bx bx-user"></span>
                                            </div>
                                            @error('username')
                                                <div class="text-danger">
                                                    Username harus diisi.
                                                </div>
                                            @enderror
                                        </div>
                
                                        <div class="mb-3">
                                            <div class="float-end">
                                                {{-- <a href="auth-recoverpw.html" class="text-muted text-decoration-underline">Forgot password?</a> --}}
                                            </div>
                                            <label class="form-label" for="password-input">Password</label>
                                            <div class="position-relative auth-pass-inputgroup input-custom-icon">
                                                <span class="bx bx-lock-alt"></span>
                                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Masukan password">
                                                {{-- <button type="button" class="btn btn-link position-absolute h-100 end-0 top-0" id="password-addon">
                                                    <i class="mdi mdi-eye-outline font-size-18 text-muted"></i>
                                                </button> --}}
                                            </div>
                                            @error('username')
                                                <div class="text-danger">
                                                    Password harus diisi.
                                                </div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mt-3">
                                            <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Log In</button>
                                        </div>

                                        <div class="mt-4 text-center">
                                            <p class="mb-2">Belum memiliki akun ? <a href="{{ url('register') }}" class="fw-medium text-primary"> Registrasi sekarang </a> </p>
                                            <a href="/">Home</a>
                                        </div>
                                    </form>
                                </div>
            
                            </div>
                        </div>

                    </div><!-- end col -->
                </div><!-- end row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center p-4">
                            <p>© <script>document.write(new Date().getFullYear())</script> Momopetshop. Crafted with <i class="mdi mdi-heart text-danger"></i></p>
                        </div>
                    </div>
                </div>

            </div>
        </div><!-- end container -->
    </div>
    <!-- end authentication section -->

        <!-- JAVASCRIPT -->
        <script src="/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="/assets/libs/metismenujs/metismenujs.min.js"></script>
        <script src="/assets/libs/simplebar/simplebar.min.js"></script>
        <script src="/assets/libs/eva-icons/eva.min.js"></script>
        <script src="/assets/js/pages/form-validation.init.js"></script>
        <script src="/assets/js/pages/pass-addon.init.js"></script>

        <script src="/assets/js/app.js"></script>

    </body>

</html>