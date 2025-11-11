<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RoomMitra | Admin Login</title>
    
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
    
    <!-- BoxIcons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <!-- AdminLTE Theme -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css?v=3.2.0') }}">
    
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    
    <!-- Custom Admin Login Styles -->
    <link rel="stylesheet" href="{{ asset('css/admin-login.css') }}?v=2.0.0">

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card">
            <div class="card-header text-center">
                <div class="login-logo">
                    <div class="logo-icon">
                        <i class='bx bxs-home-heart'></i>
                    </div>
                </div>
                <h1><b>Admin</b> Login</h1>
            </div>
            <div class="card-body">
                
                    @forelse ($errors->all() as $error)
                    <p class="login-box-msg text-danger">  {{ $error }}</p>
                    @empty
                    <p class="login-box-msg">     Welcome to the Admin Login Page   </p>
                    @endforelse
              

                <form action="{{ route('admin.login') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class='bx bx-envelope'></i>
                            </div>
                        </div>
                        <input type="email" class="form-control" placeholder="Email" name="email" required>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class='bx bx-lock-alt'></i>
                            </div>
                        </div>
                        <input type="password" class="form-control" placeholder="Password" name="password" required>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember" name="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js?v=3.2.0') }}"></script>
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
        integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
        data-cf-beacon='{"rayId":"933de69d3e343f85","serverTiming":{"name":{"cfExtPri":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"version":"2025.4.0-1-g37f21b1","token":"2437d112162f4ec4b63c3ca0eb38fb20"}'
        crossorigin="anonymous"></script>
</body>

</html>
