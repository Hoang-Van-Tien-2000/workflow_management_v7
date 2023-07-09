@extends('master')
@section('main-content')
@section('title', 'Cài đặt dự án')
<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link href="{{ asset('assets/src/jquery.tagsinput-revisited.css') }}" rel="stylesheet" />
<style>
    .custom-button {
        border: none;
        background-color: white;
        color: red;
    }

    .articles a {
        text-decoration: none !important;
        display: block;
        margin-bottom: 0;
        color: #555
    }

    .articles .badge {
        font-size: 0.7em;
        padding: 5px 10px;
        line-height: 1;
        margin-left: 10px
    }

    .articles .item {
        padding: 20px
    }

    .articles .item:nth-of-type(even) {
        background: #fafafa
    }

    .articles .item .image {
        width: 50px;
        height: 50px;
        margin-right: 15px
    }

    .articles .item img {
        padding: 3px;
        width: 50px;
        height: 50px;
        border: solid 1px gray;
    }

    .articles .item h3 {
        color: #555;
        font-weight: 400;
        margin-bottom: 0
    }

    .articles .item small {
        color: #aaa;
        font-size: 0.75em
    }

    .card-close {
        position: absolute;
        top: 15px;
        right: 15px
    }

    .card-close .dropdown-toggle {
        color: #999;
        background: none;
        border: none
    }

    .card-close .dropdown-toggle:after {
        display: none
    }

    .card-close .dropdown-menu {
        border: none;
        min-width: auto;
        font-size: 0.9em;
        border-radius: 0;
        -webkit-box-shadow: 3px 3px 3px rgba(0, 0, 0, 0.1), -2px -2px 3px rgba(0, 0, 0, 0.1);
        box-shadow: 3px 3px 3px rgba(0, 0, 0, 0.1), -2px -2px 3px rgba(0, 0, 0, 0.1)
    }

    .card-close .dropdown-menu a {
        color: #999 !important
    }

    .card-close .dropdown-menu a:hover {
        background: #796AEE;
        color: #fff !important
    }

    .card-close .dropdown-menu a i {
        margin-right: 10px;
        -webkit-transition: none;
        transition: none
    }
</style>
<div class="admin-data-content layout-top-spacing">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body" id="reload">
                    <form method="POST" id="frm-them-moi" data-parsley-validate="" novalidate>
                        @csrf
                        <div class="form theme-form">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-6">
                                        <label>Thêm thành viên<span class="required">
                                                *</span></label>
                                        <input id="form-tags-4" name="tags-4" type="text" value="">
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <button id="btn-assign" type="button" class="btn btn-primary me-3">Thêm</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mt-3">
                                    <div class="articles card">
                                        <div id="infoUser"></div>
                                    </div>
                                    </br>
                                </div>
                            </div>
                            @if (Auth::user()->id != $work->user_id)
                                <div class="row">
                                    <div class="col-md-2 mb-3">
                                        <label>Xóa dự án: </label>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <button id="btn-out-project" type="button" class="btn btn-danger"><i
                                                class='bx bxs-log-out'></i></button>
                                    </div>
                                </div>
                            @endif
                            @if (Auth::user()->hasPermissionTo('Xóa dự án'))
                                <div class="row">
                                    <div class="col-md-2 mb-3">
                                        <label>Xóa dự án: </label>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <button id="btn-delete-project" type="button" class="btn btn-danger"><i
                                                class='bx bx-trash'></i></button>
                                    </div>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col">
                                    <div class="d-lg-flex justify-content-end">

                                        <a class="btn btn-danger" href="{{ route('project.list') }}">Quay
                                            lại</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>

                </form>
            </div>
        </div>
        @section('page-css')
        @endsection
        @section('page-js')
            <script src="https://code.jquery.com/jquery-3.1.1.min.js"
                integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
            <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
                integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
            <script src="{{ asset('assets/src/jquery.tagsinput-revisited.js') }}"></script>

            <script>
                $('#btn-submit-form').click(function() {
                    if ($('#frm-them-moi').parsley().validate()) {
                        var formData = new FormData();
                        $("input[name='name']").map(function() {
                            formData.append('name', this.value)
                        }).get();
                        $("input[name='rate']").map(function() {
                            formData.append('rate', this.value)
                        }).get();
                        $("select[name='type']").map(function() {
                            formData.append('type', this.value)
                        }).get();
                        $("select[name='priority']").map(function() {
                            formData.append('priority', this.value)
                        }).get();
                        $("select[name='size']").map(function() {
                            formData.append('size', this.value)
                        }).get();
                        $("input[name='startdate']").map(function() {
                            formData.append('startdate', this.value)
                        }).get();
                        $("input[name='enddate']").map(function() {
                            formData.append('enddate', this.value)
                        }).get();
                        $("textarea[name='detail']").map(function() {
                            formData.append('detail', this.value)
                        }).get();
                        $.ajax({
                            url: "{{ route('project.store') }}",
                            type: 'POST',
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                        }).done(function(res) {
                            if (res.status == 'success') {
                                swal.fire({
                                    title: res.message,
                                    icon: 'success',
                                    showCancelButton: false,
                                    showConfirmButton: false,
                                    position: 'center',
                                    padding: '2em',
                                    timer: 1500,
                                }).then((result) => {
                                    if (result.dismiss === Swal.DismissReason.timer) {
                                        window.location.replace(res.redirect)
                                    }
                                })
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
                });
            </script>
            <script>
                var formData = new FormData();
                formData.append('work_id', {{ $work_id }})
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('project.load_ajax_user') }}",
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                }).done(function(res) {
                    console.log(res);
                    if (res.status == 'success') {
                        $(function() {
                            $('#form-tags-4').tagsInput({
                                'autocomplete': {
                                    source: res.data
                                }
                            });
                        });
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
            </script>
            <script>
                function Autocomplete() {
                    var formData = new FormData();
                    formData.append('work_id', {{ $work_id }})
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{ route('project.load_ajax_user') }}",
                        type: 'POST',
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                    }).done(function(res) {
                        console.log(res);
                        if (res.status == 'success') {
                            $(function() {
                                $('#form-tags-4').tagsInput({
                                    'autocomplete': {
                                        source: res.data
                                    }
                                });
                            });
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
            </script>
            <script>
                $('#btn-assign').click(function() {
                    var formData = new FormData();
                    formData.append('work_id', {{ $work_id }});
                    formData.append('value', $('#form-tags-4').val());
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{ route('project.assign') }}",
                        type: 'POST',
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                    }).done(function(res) {
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
                });
            </script>
            <script>
                function removeUser() {
                    $(".removeUser").off('click').on('click', function(event) {
                        Swal.fire({
                            title: 'Bạn có chắc chắn xóa?',
                            text: "Sau khi chấp nhận tài khoảng sẽ không truy cập được dự án",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Chấp nhận'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                var user_id = $(this).val();
                                var formData = new FormData();
                                formData.append('work_id', {{ $work_id }});
                                formData.append('user_id', user_id);
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                                $.ajax({
                                    url: "{{ route('project.remove_user') }}",
                                    type: 'POST',
                                    data: formData,
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    dataType: 'json',
                                }).done(function(res) {
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
                                        $("#infoUser").html("");
                                        loadUser()
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
                function loadUser() {
                    var formData = new FormData();
                    formData.append('work_id', {{ $work_id }});
                    $.ajax({
                        url: "{{ route('project.user_in_work') }}",
                        type: 'POST',
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                    }).done(function(res) {
                        if (res.status == 'success') {
                            console.log(res.data);
                            var $html = "";
                            res.data.forEach(myFunction);

                            function myFunction(item, index) {
                                $html += `<div class="formremoveuser">
                                                    <div class="item d-flex align-items-center">
                                                        <div class="image"><img
                                                                src="{{ asset('${item.avatar}') }}"
                                                                alt="..." class="img-fluid rounded-circle" ></div>
                                                        <div class="text">
                                                            <h6>${item.fullname}</h6>
                                                            <p> ${item.code}<button value=" ${item.id}"
                                                                    class="custom-button removeUser" type="button"><i
                                                                        class='bx bx-x-circle'></i></button></p>

                                                        </div>
                                                    </div>
                                                </div>`
                            }


                            $("#infoUser").append($html);
                            removeUser();
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
            </script>
            <script>
                $(document).ready(function() {
                    loadUser()
                })
            </script>
            <script>
                $("#btn-out-project").click(function() {
                    Swal.fire({
                        title: 'Bạn có chắc rời khỏi dự án ?',
                        text: "Sau khi chấp nhận bạn sẽ không truy cập được dự án",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Confirm'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var formData = new FormData();
                            formData.append('work_id', {{ $work_id }});
                            $.ajax({
                                    url: "{{ route('project.out_project') }}",
                                    type: 'POST',
                                    data: formData,
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
                                        }).then((result) => {
                                            if (result.dismiss === Swal.DismissReason.timer) {
                                                window.location.replace(res.redirect)
                                            }
                                        })
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
                $("#btn-delete-project").click(function() {
                    Swal.fire({
                        title: 'Bạn có chắc xóa dự án ?',
                        text: "Sau khi chấp nhận dự án sẽ không còn tồn tại.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Confirm'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var formData = new FormData();
                            formData.append('work_id', {{ $work_id }});
                            $.ajax({
                                    url: "{{ route('project.delete_project') }}",
                                    type: 'POST',
                                    data: formData,
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
                                        }).then((result) => {
                                            if (result.dismiss === Swal.DismissReason.timer) {
                                                window.location.replace(res.redirect)
                                            }
                                        })
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
        @endsection
    @endsection
