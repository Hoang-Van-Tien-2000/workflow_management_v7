@extends('master')
@section('main-content')
<div class="admin-data-content layout-top-spacing">
    <div class="container-fluid rounded bg-white mt-5 mb-5">
        <div class="row">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    <img class="rounded-circle shadow-4 mb-3" style="width: 150px;height: 150px;" @if(auth()->user()->avatar == null || file_exists(public_path(auth()->user()->avatar)) == false) src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg" @else src="{{URL::to('/')}}/{{auth()->user()->avatar}}" @endif>
                    <span class="font-weight-bold">{{auth()->user()->fullname}}</span>
                    <span class="text-black-50 mb-3">{{auth()->user()->email}}</span>
                    <a class="btn btn-primary" onclick="updateRow(this)" >Đổi ảnh đại diện</a>
                </div>
            </div>
            <div class="col-md-5 border-right">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Thông tin cá nhân</h4>
                    </div>
                    <form method="POST" id="frm-cap-nhat" data-parsley-validate="" novalidate>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label class="labels">Họ tên</label>
                                <input type="text" class="form-control" placeholder="Nhập họ tên" 
                                id="fullname" name="fullname"
                                value="{{auth()->user()->fullname}}"
                                data-parsley-required-message="Vui lòng nhập họ tên người dùng"
                                data-parsley-maxlength="191"
                                data-parsley-maxlength-message="Họ tên người dùng không thể nhập quá 191 ký tự"
                                required>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label class="labels">Ngày sinh</label>
                                <input type="date" class="form-control" value="{{auth()->user()->birthday}}"
                                id="birthday" name="birthday"
                                data-parsley-required-message="Vui lòng nhập ngày sinh"
                                required>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label class="labels">CMND/CCCD</label>
                                <input type="text" class="form-control" placeholder="Nhập CMND/CCCD"
                                value="{{auth()->user()->citizen_identification}}"
                                id="citizen_identification" name="citizen_identification"
                                data-parsley-required-message="Vui lòng nhập cccd/cmnd"
                                data-parsley-maxlength="191"
                                data-parsley-maxlength-message="CCCD/CMND không thể nhập quá 191 ký tự"
                                required>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label class="labels">Số điện thoại</label>
                                <input type="text" class="form-control" placeholder="Nhập số điện thoại" 
                                value="{{auth()->user()->phone}}"
                                id="phone" name="phone"
                                maxlength="20"
                                placeholder="Số điện thoại..."
                                data-parsley-required-message="Vui lòng nhập số điện thoại"
                                required>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label class="labels">Email</label>
                                <input type="email" class="form-control" placeholder="Nhập Email" 
                                value="{{auth()->user()->email}}"
                                id="email" name="email"
                                data-parsley-type="email"
                                data-parsley-type-message="Email không đúng định dạng"
                                data-parsley-required-message="Vui lòng nhập email"
                                data-parsley-maxlength="191"
                                data-parsley-maxlength-message="Email không thể nhập quá 191 ký tự"
                                required>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label class="labels">Địa chỉ</label>
                                <input type="text" class="form-control" placeholder="Nhập địa chỉ" 
                                value="{{auth()->user()->address}}"
                                id="address" name="address"
                                data-parsley-maxlength="191"
                                data-parsley-maxlength-message="Địa chỉ không thể nhập quá 191 ký tự"
                                data-parsley-required-message="Vui lòng nhập địa chỉ"
                                required>
                            </div>
                        </div>
                        <div class="mt-5 text-center">
                            <button class="btn btn-primary profile-button" id="btn-submit-form" type="button">Lưu thông tin</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Thay đổi mật khẩu</h4>
                    </div>
                    <form data-parsley-validate="" id="frm-cap-nhat-mk" method="POST" novalidate>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label class="labels">Mật khẩu cũ</label>
                                <div class="input-group" id="show_hide_password_1">
                                    <input type="password" class="form-control" placeholder="Nhập mật khẩu cũ"
                                    name="password" id="password"
                                    data-parsley-errors-container="#error-parley-select-mk"
                                    data-parsley-required-message="Vui lòng nhập mật khẩu"
                                    data-parsley-maxlength="191"
                                    data-parsley-maxlength-message="Mật khẩu không thể nhập quá 191 ký tự"
                                    required>
                                    <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                                </div>
                                <div id="error-parley-select-mk"></div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label class="labels">Mật khẩu mới</label>
                                <div class="input-group" id="show_hide_password_2">
                                    <input type="password" class="form-control" placeholder="Nhập mật khẩu mới"
                                    name="new_password" id="new_password"
                                    data-parsley-errors-container="#error-parley-select-mkm"
                                    data-parsley-minlength="6"
                                    data-parsley-minlength-message="Vui lòng nhập mật khẩu mới ít nhất 6 kí tự"
                                    data-parsley-required-message="Vui lòng nhập mật khẩu mới"
                                    data-parsley-maxlength="191"
                                    data-parsley-maxlength-message="Mật khẩu mới không thể nhập quá 191 ký tự"
                                    required>
                                    <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                                </div>
                                <div id="error-parley-select-mkm"></div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label class="labels">Nhập lại mật khẩu</label>
                                <div class="input-group" id="show_hide_password_3">
                                    <input type="password" class="form-control" placeholder="Nhập xác nhận mật khẩu"
                                    data-parsley-errors-container="#error-parley-select-mknl"
                                    name="enter_new_pass" id="enter_new_pass"
                                    data-parsley-required-message="Vui lòng nhập xác nhận mật khẩu"
                                    data-parsley-maxlength="191"
                                    data-parsley-maxlength-message="Xác nhận mật khẩu không thể nhập quá 191 ký tự"
                                    required>
                                    <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                                </div>
                                <div id="error-parley-select-mknl"></div>
                            </div>
                        </div>
                        <div class="mt-5 text-center">
                            <button  id="btn-update-pass" class="btn btn-primary profile-button" type="button">Lưu mật khẩu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('modules.profile.update_avt')
<script type="text/javascript">
    function updateRow(a) {
        var modal = $("#update-avt-modal");
        modal.modal('show')
        modal.on('shown.bs.modal', function(e) {
        });
        modal.on('hidden.bs.modal', function() {
            $('#frm-cap-nhat-avt').parsley().reset();
        });
    };
</script>
<script>
    $('#btn-submit-form').click(function() {
        if($('#frm-cap-nhat').parsley().validate()) {
            console.log(1)
            var formData = new FormData();
                $("input[name='fullname']").map(function(){ formData.append('fullname', this.value)}).get();
                $("input[name='birthday']").map(function(){ formData.append('birthday', this.value)}).get();
                $("input[name='phone']").map(function(){ formData.append('phone', this.value)}).get();
                $("input[name='address']").map(function(){ formData.append('address', this.value)}).get();
                $("input[name='citizen_identification']").map(function(){ formData.append('citizen_identification', this.value)}).get();
                $("input[name='email']").map(function(){ formData.append('email', this.value)}).get();

                $.ajax({
                    url: "{{ route('profile.update') }}",
                    type: 'POST',
                    data: formData,
                    cache:false,
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
                       if (result.dismiss === Swal.DismissReason.timer) 
                        {
                            window.location.replace(res.redirect)
                        }
                    })
                    }else {
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
		$(document).ready(function () {
			// Password show & hide
			$("#show_hide_password_1 a").on('click', function (event) {
				event.preventDefault();
				if ($('#show_hide_password_1 input').attr("type") == "text") {
					$('#show_hide_password_1 input').attr('type', 'password');
					$('#show_hide_password_1 i').addClass("bx-hide");
					$('#show_hide_password_1 i').removeClass("bx-show");
				} else if ($('#show_hide_password_1 input').attr("type") == "password") {
					$('#show_hide_password_1 input').attr('type', 'text');
					$('#show_hide_password_1 i').removeClass("bx-hide");
					$('#show_hide_password_1 i').addClass("bx-show");
				}
			});

            $("#show_hide_password_2 a").on('click', function (event) {
				event.preventDefault();
				if ($('#show_hide_password_2 input').attr("type") == "text") {
					$('#show_hide_password_2 input').attr('type', 'password');
					$('#show_hide_password_2 i').addClass("bx-hide");
					$('#show_hide_password_2 i').removeClass("bx-show");
				} else if ($('#show_hide_password_2 input').attr("type") == "password") {
					$('#show_hide_password_2 input').attr('type', 'text');
					$('#show_hide_password_2 i').removeClass("bx-hide");
					$('#show_hide_password_2 i').addClass("bx-show");
				}
			});

            $("#show_hide_password_3 a").on('click', function (event) {
				event.preventDefault();
				if ($('#show_hide_password_3 input').attr("type") == "text") {
					$('#show_hide_password_3 input').attr('type', 'password');
					$('#show_hide_password_3 i').addClass("bx-hide");
					$('#show_hide_password_3 i').removeClass("bx-show");
				} else if ($('#show_hide_password_3 input').attr("type") == "password") {
					$('#show_hide_password_3 input').attr('type', 'text');
					$('#show_hide_password_3 i').removeClass("bx-hide");
					$('#show_hide_password_3 i').addClass("bx-show");
				}
			});
        });
</script>
<script>
	$('#btn-update-pass').click(function() {
		if($('#frm-cap-nhat-mk').parsley().validate()) {
			var formData = new FormData();
			$("input[name='password']").map(function(){ formData.append('password', this.value)}).get();
			$("input[name='new_password']").map(function(){ formData.append('new_password', this.value)}).get();
			$("input[name='enter_new_pass']").map(function(){ formData.append('enter_new_pass', this.value)}).get();
			$.ajax({
				url: "{{ route('profile.update_pass') }}",
				type: 'POST',
				data: formData,
				cache:false,
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
						icon: res.status,
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
@endsection
