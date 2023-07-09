@extends('master')
@section('main-content')
<div class="admin-data-content layout-top-spacing">
    <div class="row project-cards">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" id="frm-them-moi" data-parsley-validate="" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-sm-12" style="margin-bottom:1%">
                                <label class="form-label" for="ten">Mã nhân viên</label>
                                <input type="text" class="form-control" id="code" name="code" readonly>
                            </div>
                            <div class="col-md-6 col-sm-12" style="margin-bottom:1%">
                                <label class="form-label" for="ten">Họ Tên<span class="required"> *</span></label>
                                <input type="text" class="form-control" id="fullname" name="fullname"
                                placeholder="Họ tên người dùng..."
                                data-parsley-required-message="Vui lòng nhập họ tên người dùng"
                                data-parsley-maxlength="191"
                                data-parsley-maxlength-message="Họ tên người dùng không thể nhập quá 191 ký tự"
                                required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12" style="margin-bottom:1%">
                                <label class="form-label" for="ten">Tên đăng nhập<span class="required"> *</span></label>
                                <input type="text" class="form-control" id="username" name="username"
                                placeholder="Tên đăng nhập..."
                                data-parsley-required-message="Vui lòng nhập tên đăng nhập"
                                data-parsley-maxlength="191"
                                data-parsley-maxlength-message="Tên đăng nhập không thể nhập quá 191 ký tự"
                                required>
                            </div>
                            <div class="col-md-6 col-sm-12" style="margin-bottom:1%">
                                <label class="form-label" for="ten">Mật khẩu<span class="required"> *</span></label>
                                <input type="password" class="form-control" id="password" name="password"
                                placeholder="Mật khẩu..."
                                data-parsley-minlength="6"
                                data-parsley-minlength-message="Vui lòng nhập mật khẩu ít nhất 6 kí tự"
                                data-parsley-required-message="Vui lòng nhập mật khẩu"
                                data-parsley-maxlength="191"
                                data-parsley-maxlength-message="Mật khẩu không thể nhập quá 191 ký tự"
                                required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12" style="margin-bottom:1%">
                                <label class="form-label" for="ten">Ngày sinh<span class="required"> *</span></label>
                                <input type="date" class="form-control" id="birthday" name="birthday"
                                data-parsley-required-message="Vui lòng nhập ngày sinh"
                                required>
                                <div id="error-parley-select-ns" class="error-date"></div>
                            </div>
                            <div class="col-md-6 col-sm-12" style="margin-bottom:1%">
                                <label class="form-label" for="dien-thoai">Số điện thoại<span class="required"> *</span></label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                maxlength="20"
                                placeholder="Số điện thoại..."
                                data-parsley-required-message="Vui lòng nhập số điện thoại"
                                required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12" style="margin-bottom:1%">
                                <label class="form-label" for="dia-chi">Địa chỉ<span class="required"> *</span></label>
                                <input type="text" class="form-control" id="address" name="address"
                                placeholder="Địa chỉ..."
                                data-parsley-maxlength="191"
                                data-parsley-maxlength-message="Địa chỉ không thể nhập quá 191 ký tự"
                                data-parsley-required-message="Vui lòng nhập địa chỉ"
                                required>
                            </div>
                            <div class="col-md-6 col-sm-12" style="margin-bottom:1%">
                                <label class="form-label" for="ten">CMND/CCCD<span class="required"> *</span></label>
                                <input type="text" class="form-control" id="citizen_identification" name="citizen_identification"
                                placeholder="CCCD/CMND..."
                                data-parsley-required-message="Vui lòng nhập cccd/cmnd"
                                data-parsley-maxlength="191"
                                data-parsley-maxlength-message="CCCD/CMND không thể nhập quá 191 ký tự"
                                required>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-md-6 col-sm-12" style="margin-bottom:1%">
                                <label class="form-label" for="ten">Email<span class="required"> *</span></label>
                                <input type="email" class="form-control" id="email" name="email"
                                placeholder="Email..."
                                data-parsley-type="email"
                                data-parsley-type-message="Email không đúng định dạng"
                                data-parsley-required-message="Vui lòng nhập email"
                                data-parsley-maxlength="191"
                                data-parsley-maxlength-message="Email không thể nhập quá 191 ký tự"
                                required>
                            </div>
                            <div class="col-md-6 col-sm-12" >
                                <label class="form-label" for="chuc-vu">Chức vụ<span class="required"> *</span></label>
                                <select class="form-control custom-select2"
                                data-parsley-required-message="Vui lòng chọn chức vụ"
                                data-parsley-errors-container="#error-parley-select-cv"
                                required
                                id="role_id" name="role_id">
                                <option value=""></option>
                                    @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                <div id="error-parley-select-cv"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12" >
                                <label class="form-label" for="chuc-vu">Phòng ban<span class="required"> *</span></label>
                                <select class="form-control custom-select2"
                                data-parsley-required-message="Vui lòng chọn phòng ban"
                                data-parsley-errors-container="#error-parley-select-pb"
                                required
                                id="department_id" name="department_id">
                                <option value=""></option>
                                    @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                                <div id="error-parley-select-pb"></div>
                            </div>
                            <div class="col-md-6 col-sm-12" style="margin-bottom:2%">
                                <div class="custom-file-container" data-upload-id="anhDaiDien">
                                    <label>Ảnh đại diện <a href="javascript:void(0)" class="custom-file-container__image-clear"
                                            title="Clear Image">x</a></label>
                                    <label class="custom-file-container__custom-file">
                                        <input type="file" class="custom-file-container__custom-file__custom-file-input" name="image"
                                            accept="image/*">
                                        <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                        <span class="custom-file-container__custom-file__custom-file-control"></span>
                                    </label>
                                    <div class="custom-file-container__image-preview"></div>
                                </div>
                            </div>
                        </div>
                        <div class="d-lg-flex justify-content-end">
                            <div class="row mt-3" >
                                <div class="col-md-6 mb-3">
                                    <button id="btn-submit-form" type="button" class="btn btn-primary px-5">Lưu</button>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{route('pay_salaries.list')}}"class="btn btn-outline-primary px-5">Hủy</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@section('page-js')

<script type="text/javascript">
    $("#role_id").select2({
       placeholder: "Chọn chức vụ",
       closeOnSelect : true,
        tags: false, 
    });

    $("#department_id").select2({
       placeholder: "Chọn phòng ban",
       closeOnSelect : true,
        tags: false, 
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $("input[name='_token']").val()
            }
        });

        $.ajax({
                url: "{{route('user.code')}}",
                type: 'get',
                cache:false,
                contentType: false,
                processData: false,
                dataType: 'json',
        }).done(function(res) {
            if (res.status == 'success') {
                $("#code").val(res.data)
            }
        });
        
    });
</script>
<script>
    var fileImages = [];
    var firstUpload = new FileUploadWithPreview('anhDaiDien', {
        text: {
            chooseFile: "Chọn ảnh đại diện...",
            browse: "Chọn ảnh",
            //selectedCount: "Custom Files Selected Copy",
        }  
    });

    window.addEventListener('fileUploadWithPreview:imagesAdded', function (e) {
        if (e.detail.uploadId === 'anhDaiDien') {
            fileImages = e.detail.cachedFileArray
        }
    })
    window.addEventListener('fileUploadWithPreview:imageDeleted', function (e) {
        if (e.detail.uploadId === 'anhDaiDien') {
            fileImages= e.detail.cachedFileArray;
        } 
    })
</script>
<script>
    $('#btn-submit-form').click(function() {
        if($('#frm-them-moi').parsley().validate()) {
            var formData = new FormData();
                $("input[name='code']").map(function(){ formData.append('code', this.value)}).get();
                $("input[name='fullname']").map(function(){ formData.append('fullname', this.value)}).get();
                $("input[name='username']").map(function(){ formData.append('username', this.value)}).get();
                $("input[name='password']").map(function(){ formData.append('password', this.value)}).get();
                $("input[name='birthday']").map(function(){ formData.append('birthday', this.value)}).get();
                $("input[name='phone']").map(function(){ formData.append('phone', this.value)}).get();
                $("input[name='address']").map(function(){ formData.append('address', this.value)}).get();
                $("input[name='citizen_identification']").map(function(){ formData.append('citizen_identification', this.value)}).get();
                $("input[name='email']").map(function(){ formData.append('email', this.value)}).get();
                $("select[name='role_id']").map(function(){ formData.append('role_id', this.value)}).get();
                $("select[name='department_id']").map(function(){ formData.append('department_id', this.value)}).get();
                fileImages.map(function(file){ formData.append('avatar', file)});
                $.ajax({
                    url: "{{ route('user.store') }}",
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
  $("#birthday").blur(function(){
    var birthday = $("#birthday").val();
    var d = new Date(birthday);
    var today = new Date().toISOString().split("T")[0];
    if(!isNaN(d))
    {
        if(birthday>today)
        {
            document.getElementById("error-parley-select-ns").innerHTML="Ngày sinh không được lớn hơn ngày hiện tại"
            document.getElementById("btn-submit-form").disabled = true;
        }
        else
        {
            document.getElementById("error-parley-select-ns").innerHTML=""
            document.getElementById("btn-submit-form").disabled = false;
        }
    }
    else
    {
        document.getElementById("birthday").value="";
        document.getElementById("error-parley-select-ns").innerHTML=""
    }
  });
</script>
@endsection
@endsection
