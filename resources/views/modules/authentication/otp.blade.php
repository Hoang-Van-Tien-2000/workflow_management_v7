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
    <title>Forget Password</title>
    @include('inc.common-css')
</head>

<body cz-shortcut-listen="true">
    <section>
        <div class="container-fluid p-0">
            <div class="row m-0">
                <div class="col-12 p-0">
                    <div class="login-card">
                        <div class="login-main">
                            <form class="theme-form login-form">
                                <h4 class="mb-3">Khôi phục mật khẩu</h4>
                                <div class="form-group">
                                    <label>Nhập số điện thoại</label>
                                    <div class="row">
                                        <div class="col-4 col-sm-3">
                                            <input class="form-control" type="text" value="+84">
                                        </div>
                                        <div class="col-8 col-sm-9">
                                            <input class="form-control" type="tel" value="000-000-0000">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary btn-block col-md-4" type="submit">Gửi</button>
                                </div>
                                <div class="form-group">
                                    <span class="reset-password-link">Nếu không nhận được OTP ? <a
                                            class="btn-link text-danger" href="javascript:void(0)">Gửi lại</a></span>
                                </div>
                                <div class="form-group">
                                    <label>Nhập OTP</label>
                                    <div class="row">
                                        <div class="col">
                                            <input class="form-control text-center opt-text" type="text"
                                                value="00" maxlength="2">
                                        </div>
                                        <div class="col">
                                            <input class="form-control text-center opt-text" type="text"
                                                value="00" maxlength="2">
                                        </div>
                                        <div class="col">
                                            <input class="form-control text-center opt-text" type="text"
                                                value="00" maxlength="2">
                                        </div>
                                    </div>
                                </div>
                                <h6>Tạo mật khẩu</h6>
                                <div class="form-group">
                                    <label>Mật khẩu mới</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class='bx bx-lock-alt'></i></span>
                                        <input class="form-control" type="password" name="login[password]"
                                            required="" placeholder="*********">
                                        <div class="show-hide"><span class="show"></span></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Nhập lại mật khẩu</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class='bx bx-lock-alt'></i></span>
                                        <input class="form-control" type="password" name="login[password]"
                                            required="" placeholder="*********">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary btn-block col-md-4" type="submit">Xác nhận</button>
                                </div>
                                <p>Đã khôi phục mật khẩu <a class="ms-2" href="{{ route('login') }}">Đăng nhập</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div style="display: none" class="ubey-RecordingScreen-count-down ubey-RecordingScreen-count-down-container">
        <style>
            .ubey-RecordingScreen-count-down-container {
                position: fixed;
                height: 100vh;
                width: 100vw;
                top: 0;
                left: 0;
                z-index: 9999999999999;
                background-color: rgba(0, 0, 0, 0.2);
            }

            .ubey-RecordingScreen-count-down-content {
                position: absolute;
                display: flex;
                top: 50%;
                left: 50%;
                justify-content: center;
                align-items: center;
                color: white;
                height: 15em;
                width: 15em;
                transform: translate(-50%, -100%);
                background-color: rgba(0, 0, 0, 0.6);
                border-radius: 50%;
            }

            #ubey-RecordingScreen-count-count {
                font-size: 14em;
                transform: translateY(-2%);
            }
        </style>
        <div class="ubey-RecordingScreen-count-down-content">
            <span id="ubey-RecordingScreen-count-count"></span>
        </div>
    </div>
    @include('inc.common-js')
</body>

</html>
