<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="viho admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, viho admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="{{ asset('assets/img/favicon.ico') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.ico') }}" type="image/x-icon">
    <title>Task management</title>
    <!-- Google font-->
    @include('inc.common-css')
</head>

<body>
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5 b-center bg-size"
                    style="background-image: url({{ asset('assets/img/login.jpg') }});background-size: cover;background-position: center center;display: block;">
                    <img class="bg-img-cover bg-center" src="" alt="looginpage" style="display: none;">
                </div>
                <div class="col-md-7 p-0">
                    <div class="login-card">
                        <form class="theme-form login-form" data-parsley-validate="" action="{{ route('do_login') }}" method="POST">
                            @csrf
                            <h4>Đăng nhập</h4>
                            <h6>Chào mừng bạn trở lại !</h6>
                            <!-- <div class="form-group">
                  <label>Email Address</label>
                  <div class="input-group"><span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    <input class="form-control" type="email" required="" placeholder="Test@gmail.com">
                  </div>
                </div> -->

                            <div id="username-field" class="field-wrapper input">
                                <span class="input-group-text">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                </span>
                                <input id="username" name="username" type="text" class="form-control"
                                    data-parsley-required-message="Vui lòng nhập tên đăng nhập"
                                    data-parsley-maxlength="191"
                                    data-parsley-maxlength-message="Tên đăng nhập không thể nhập quá 191 ký tự"
                                    data-parsley-errors-container="#error-parley-select-us"
                                    placeholder="Tên đăng nhập" required>
                            </div>
                            <div id="error-parley-select-us" class="mb-3"></div>
                            <div class="form-group">
                                <div class="input-group"><span class="input-group-text"><i
                                            class="fas fa-lock"></i></span>
                                    <input class="form-control" type="password" name="password" 
                                    data-parsley-required-message="Vui lòng nhập mật khẩu"
                                    data-parsley-maxlength="191"
                                    data-parsley-maxlength-message="Mật khẩu không thể nhập quá 191 ký tự" 
                                    data-parsley-errors-container="#error-parley-select-pa" required
                                        placeholder="*********">
                                    <div class="show-hide"><span class="show"> </span></div>
                                </div>
                                <div id="error-parley-select-pa" class="mb-3"></div>
                            </div>
                            <div class="form-group d-flex justify-content-between">
                                <label class="custom-control overflow-checkbox">
                                    <input type="checkbox" class="overflow-control-input" id="checkbox1">
                                    <span class="overflow-control-indicator"></span>
                                    <label class="text-muted" for="checkbox1">Nhớ mật khẩu</label>
                                </label>
                                <a class="link" href="{{ route('forget-password') }}">Quên mật khẩu</a>
                            </div>
                            <button type="submit" class="btn btn-primary" value="">Đăng nhập</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('inc.common-js')
    @if(session('error'))
        <script type="text/javascript">
            swal.fire({
                title:  "{{session('error')}}",
                icon: 'error',
                padding: '2em',
                showConfirmButton: false,
                timer: 1500,
            })
        </script>
    @endif
</body>

</html>
