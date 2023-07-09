<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Quản lý nhân sự - {{$title}}</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
    <link href="{{ asset('assets/css/loader.css') }}" rel="stylesheet" type="text/css" />
    {{-- <script src="assets/js/loader.js"></script> --}}
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    {{-- <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" /> --}}
    @include('inc.common-css');
    @yield('page-css')
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->

    <style>
        /*
            The below code is for DEMO purpose --- Use it if you are using this demo otherwise Remove it
        */
        .navbar .navbar-item.navbar-dropdown {
            margin-left: auto;
        }


        .alt-menu #content .col-right {
            position: fixed;
            top: 0;
            width: 310px;
            right: -380px;
            border-radius: 0;
            z-index: 1029 !important;
            transition: .3s ease all;
            width: 348px;
        }

        .alt-menu #content .col-right.show {
            right: 0;
        }

        .alt-menu.admin-header .toggle-notification-bar {
            display: block;
            cursor: pointer;
        }

        .alt-menu.overlay.show {
            display: block;
            opacity: .7;
        }

        .alt-menu.admin-header .toggle-notification-bar svg {
            width: 19px;
            height: 19px;
            stroke-width: 1.6px;
        }

        .alt-menu .col-right-content .col-right-content-container {
            position: relative;
            height: calc(100vh - 92px);
            padding: 0 0 0 0;
        }

        #content .col-left {
            margin-right: 0;
        }

        @media (max-width: 399px) {
            .alt-menu .col-right-content .col-right-content-container {
                padding-right: 15px;
            }
        }

        /*
            Just for demo purpose ---- Remove it.
        */
        /*<starter kit design>*/

        .widget-one {}

        .widget-one h6 {
            font-size: 20px;
            font-weight: 600;
            letter-spacing: 0px;
            margin-bottom: 22px;
        }

        .widget-one p {
            font-size: 15px;
            margin-bottom: 0;
        }
    </style>

    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->

</head>

<body class="sidebar-noneoverflow starterkit admin-header alt-menu">

    <!-- BEGIN LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <!--  END LOADER -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">
        @include('inc.side-bar')

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <div id="checkin"></div>
                <div id="checkout"></div>
                <div class="content-container">

                    <div class="col-left ">
                        <div class="col-left-content">
                            @include('inc.breadcrumb')
                            @yield('main-content')
                            @include('inc.footer')
                        </div>
                    </div>

                    @include('inc.col-right')
                </div>
            </div>

        </div>
        <!--  END CONTENT AREA  -->
    </div>
    <!-- END MAIN CONTAINER -->


    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    @include('inc.common-js')
    {{-- <script src="{{asset('assets/js/libs/jquery-3.1.1.min.js')}}"></script>
    <script src="{{asset('bootstrap/js/popper.min.js')}}"></script>
    <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
    <script src="{{asset('assets/js/app.js')}}"></script> --}}
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    {{-- <script src="{{asset('assets/js/custom.js')}}"></script> --}}
    @yield('page-js')
    <script>
        $(document).ready(function() {
            $.ajax({
                url: "{{ route('check-in') }}",
                type: 'GET',
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
            }).done(function(res) {
                if (res.status == 'checkin') {
                    var html = `<div class="modal show check-in" tabindex="-1" role="dialog" style="display: block;">
                    <div class="modal-dialog dialog-checkin" role="document">
                        <div class="modal-content">
                            <div class="modal-header header-checkin">
                            </div>
                            <div class="modal-body">
                                <div class="icon-error">
                                    <i class='bx bx-error-circle'></i>
                                </div>
                                <div class="checkin">
                                    Vui lòng checkin
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="buttonCheckin" class="btn btn-primary">Checkin</button>
                            </div>
                        </div>
                    </div>
                    </div>`
                } else if (res.status == 'checkout') {
                    var html = `<div class="modal show check-in" tabindex="-1" role="dialog" style="display: block;">
                    <div class="modal-dialog dialog-checkin" role="document">
                        <div class="modal-content">
                            <div class="modal-header header-checkin">
                            </div>
                            <div class="modal-body">
                                <div class="icon-error">
                                    <i class='bx bx-error-circle'></i>
                                </div>
                                <div class="checkin">
                                    Vui lòng checkout
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="buttonCheckout1" class="btn btn-primary">Checkout</button>
                            </div>
                        </div>
                    </div>
                    </div>`

                }

                $("#checkin").append(html);
                handleCheckin();
                handleCheckout();
            });

        });
    </script>
    <script>
        function handleCheckin() {
            $("#buttonCheckin").click(function() {
                $.ajax({
                        url: "{{ route('auth-checkin') }}",
                        type: 'GET',
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                    })
                    .done(function(res) {
                        if (res.status == 'success') {
                            swal.fire({
                                title: res.message,
                                icon: 'success',
                                showCancelButton: false,
                                showConfirmButton: false,
                                position: 'center',
                                padding: '2em',
                                timer: 1500,
                            })
                            window.location.reload(true);
                        } else {
                            Swal.fire({
                                title: res.message,
                                icon: 'error',
                                showCancelButton: false,
                                showConfirmButton: false,
                                position: 'center',
                                padding: '2em',
                                timer: 1500,
                            })
                        }
                    });
            })
        }
    </script>
    <script>
        $("#buttonCheckout").click(function() {
            Swal.fire({
                title: 'Bạn có muốn checkout không ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Checkout',
                cancelButtonText: "Hủy bỏ",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                            url: "{{ route('checkout') }}",
                            type: 'GET',
                            cache: false,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                        })
                        .done(function(res) {
                            if (res.status == 'success') {
                                swal.fire({
                                    title: res.message,
                                    icon: 'success',
                                    showCancelButton: false,
                                    showConfirmButton: false,
                                    position: 'center',
                                    padding: '2em',
                                    timer: 1500,
                                })
                                window.location.href = "{{ route('logout') }}";
                            } else {
                                Swal.fire({
                                    title: res.message,
                                    icon: 'error',
                                    showCancelButton: false,
                                    showConfirmButton: false,
                                    position: 'center',
                                    padding: '2em',
                                    timer: 1500,
                                })
                            }
                        });
                }
            })

        })
    </script>
    <script>
        function handleCheckout() {
            $("#buttonCheckout1").click(function() {
                Swal.fire({
                    title: 'Bạn có muốn checkout không ?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Checkout',

                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                                url: "{{ route('checkout') }}",
                                type: 'GET',
                                cache: false,
                                contentType: false,
                                processData: false,
                                dataType: 'json',
                            })
                            .done(function(res) {
                                if (res.status == 'success') {
                                    swal.fire({
                                        title: res.message,
                                        icon: 'success',
                                        showCancelButton: false,
                                        showConfirmButton: false,
                                        position: 'center',
                                        padding: '2em',
                                        timer: 1500,
                                    })
                                    window.location.reload();
                                } else {
                                    Swal.fire({
                                        title: res.message,
                                        icon: 'error',
                                        showCancelButton: false,
                                        showConfirmButton: false,
                                        position: 'center',
                                        padding: '2em',
                                        timer: 1500,
                                    })
                                }
                            });
                    }
                })

            })
        }
    </script>
    <script>
        $(document).ready(function() {
            $.ajax({
                url: "{{ route('checkout-at') }}",
                type: 'GET',
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
            }).done(function(res) {
                if (res.status == 'success') {
                    var html = `<div class="modal show check-in" tabindex="-1" role="dialog" style="display: block;">
                    <div class="modal-dialog dialog-checkin" role="document">
                        <div class="modal-content">
                            <div class="modal-header header-checkin">
                            </div>
                            <div class="modal-body">
                                <div class="icon-success">
                                    <i class='bx bx-check-circle'></i>
                                </div>
                                <div class="checkout">
                                    Công việc hôm nay đã hoàn thành
                                </div>
                            </div>
                            <div class="modal-footer">
                               
                            </div>
                        </div>
                    </div>
                    </div>`
                    $("#checkout").append(html);
                }
            });

        });
    </script>
</body>

</html>
