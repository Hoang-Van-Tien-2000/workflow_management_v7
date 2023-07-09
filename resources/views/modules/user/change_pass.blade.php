<div class="modal fade" id="update-modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cập nhật</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="update_form"  data-parsley-validate="" id="frm-cap-nhat-mk" method="POST" novalidate>
                    @csrf
                    <input type="hidden" id = "id" name = "id">
					<div class="mb-3 needs-validation">
						<label class="form-label" for="mo-ta">Mật khẩu mới <span style="color:red;">*</span></label>
						<div class="input-group" id="show_hide_password_2">
							<input type="password" class="form-control border-end-0" 
							name="new_password" id="new_password" placeholder="Nhập mật khẩu mới" 
							data-parsley-required-message="Vui lòng nhập mật khẩu mới"
							data-parsley-errors-container="#error-parley-select-mkm"
							data-parsley-maxlength="191"
                            data-parsley-minlength="6"
                            data-parsley-minlength-message="Mật khẩu mới không thể nhập ít hơn 6 ký tự"
                    		data-parsley-maxlength-message="Mật khẩu mới không thể nhập quá 191 ký tự"
							required>
							<a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
							<div class="invalid-feedback">Chưa nhập mật khẩu mới</div>
						</div>
						<div id="error-parley-select-mkm"></div>
					</div>
					<div class="mb-3 needs-validation">
						<label class="form-label" for="mo-ta">Xác nhận mật khẩu <span style="color:red;">*</span></label>
						<div class="input-group" id="show_hide_password_3">
							<input type="password" class="form-control border-end-0" 
							name="enter_new_pass" id="enter_new_pass" placeholder="Nhập xác nhận mật khẩu" 
							data-parsley-required-message="Vui lòng nhập lại mật khẩu mới"
							data-parsley-errors-container="#error-parley-select-mknl"
							data-parsley-maxlength="191"
                    		data-parsley-maxlength-message="Mật khẩu nhập lại không thể nhập quá 191 ký tự"
							required>
							<a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
							<div class="invalid-feedback">Chưa nhập lại mật khẩu </div>
						</div>
						<div id="error-parley-select-mknl"></div>
					</div>
                    <div class="d-lg-flex justify-content-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button id="btn-update-pass-modal" type="button" class="btn btn-primary ml-3">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalerts/sweetalert2.min.js') }}"></script>
<script>
		$(document).ready(function () {
			// Password show & hide

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

        $("#show_hide_password_3 a").on('click', function(event) {
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
	$('#btn-update-pass-modal').click(function(e) {
        if($('#frm-cap-nhat-mk').parsley().validate()) {
            var id = $('#id').val();
            var new_password = $('#new_password').val();
            var enter_new_pass = $('#enter_new_pass').val();
            $.ajax({
                url: "{{ route('user.change_pass') }}",
                type: 'POST',
                data: {
                    id:id,
                    new_password:new_password,
                    enter_new_pass:enter_new_pass,
                },
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
                setTimeout(function() {
                    location.reload();
                }, 1500);
                }else {
                    $('#new_password').val("");
                    $('#enter_new_pass').val("");
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
</script>

<script>
	$(document).ready(function() {
		$(".modal").on("hidden.bs.modal", function() {
			$(this).find('form').trigger('reset');
		});
	  });
</script>