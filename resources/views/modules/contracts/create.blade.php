@extends('master')
@section('main-content')

<div class="admin-data-content layout-top-spacing">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" id="frm-them-moi" data-parsley-validate="" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-sm-12" style="margin-bottom:1%">
                                <label class="form-label" for="ten">Mã hợp đồng<span class="required"> *</span></label>
                                <input type="text" class="form-control" id="code" name="code">
                            </div>
                            <div class="col-md-6 col-sm-12" >
                                <label class="form-label" for="ten">Ngày kí hợp đồng<span class="required"> *</span></label>
                                <input type="date" class="form-control" id="signing_date" name="signing_date"
                                data-parsley-required-message="Vui lòng nhập ngày kí hợp đồng"
                                required>
                                <div id="error-parley-select-nkhd" class="error-date"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12" >
                                <label class="form-label" for="ten">Ngày bắt đầu<span class="required"> *</span></label>
                                <input type="date" class="form-control" id="start_date" name="start_date"
                                data-parsley-required-message="Vui lòng nhập ngày bắt đầu"
                                required>
                                <div id="error-parley-select-nbd" class="error-date"></div>
                            </div>
                            <div class="col-md-6 col-sm-12" >
                                <label class="form-label" for="ten">Ngày kết thúc<span class="required"> *</span></label>
                                <input type="date" class="form-control" id="finish_date" name="finish_date"
                                data-parsley-required-message="Vui lòng nhập ngày kết thúc"
                                required>
                                <div id="error-parley-select-nkt" class="error-date"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12" style="margin-bottom:1%">
                                <label class="form-label" for="ten">Họ Tên<span class="required"> *</span></label>
                                <input type="text" class="form-control" id="fullname" name="fullname"
                                placeholder="Họ tên người dùng..."
                                data-parsley-required-message="Vui lòng nhập họ tên người dùng"
                                data-parsley-maxlength="191"
                                data-parsley-maxlength-message="Họ tên người dùng không thể nhập quá 191 ký tự"
                                required>
                            </div>
                            <div class="col-md-6 col-sm-12" style="margin-bottom:1%">
                                <label class="form-label" for="ten">Mã nhân viên</label>
                                <input type="text" class="form-control" id="code_nv" name="code_nv" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12" style="margin-bottom:1%">
                                <label class="form-label" for="ten">Tên đăng nhập<span class="required"> *</span></label>
                                <input type="text" class="form-control" id="username" name="username"
                                onkeypress="return isSpaceKey(event)"
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
                                oninput="myFunction()"
                                onkeypress="return isNumberKey(event)"
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
                                oninput="myFunction()"
                                onkeypress="return isNumberKey(event)"
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
                            <div class="col-md-6 col-sm-12" style="margin-bottom:1%">
                                <label class="form-label" for="ten">Nội dung<span class="required"> *</span></label>
                                <input type="text" class="form-control" name="content"
                                placeholder="Nhập nội dung"
                                data-parsley-required-message="Vui lòng nhập nội dung"
                                data-parsley-maxlength="191"
                                data-parsley-maxlength-message="Nội dung không thể nhập quá 191 ký tự"
                                required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12" >
                                <label class="form-label" for="ten">Lương cơ bản<span class="required"> *</span></label>
                                <input type="text" class="form-control" name="salary" id="salary"
                                oninput="myFunction()"
                                onkeypress="return isNumberKey(event)"
                                placeholder="Nhập lương cơ bản"
                                data-parsley-required-message="Vui lòng nhập Lương cơ bản"
                                data-parsley-maxlength="20"
                                data-parsley-maxlength-message="Lương cơ bản không thể nhập quá 20 kí tự"
                                required>
                            </div>
                        </div>
                        <div class="d-lg-flex justify-content-end">
                            <div class="row mt-3" >
                                <div class="col-md-6 mb-3">
                                    <button id="btn-submit-form" type="button" class="btn btn-primary px-5">Lưu</button>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{route('contracts.list')}}"class="btn btn-outline-primary px-5">Hủy</a>
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
<script>
function isNumberKey(e) {
    var charCode = (e.which) ? e.which : e.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
</script>
<script>
function myFunction() {
  var x=document.getElementById("phone").value;
  if(isNaN(x))
  {
    document.getElementById("phone").value="";
  }
  var y=document.getElementById("citizen_identification").value;
  if(isNaN(y))
  {
    document.getElementById("citizen_identification").value="";
  }
  var z=document.getElementById("salary").value;
  if(isNaN(z))
  {
    document.getElementById("salary").value="";
  }
}
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $("input[name='_token']").val()
            }
        });

        $.ajax({
                url: "{{route('contracts.code')}}",
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
        
        $.ajax({
                url: "{{route('user.code')}}",
                type: 'get',
                cache:false,
                contentType: false,
                processData: false,
                dataType: 'json',
        }).done(function(res) {
            if (res.status == 'success') {
                $("#code_nv").val(res.data)
            }
        });
    });
</script>
<script>
    $('#btn-submit-form').click(function() {
        if($('#frm-them-moi').parsley().validate()) {
            var formData = new FormData();
                $("input[name='code']").map(function(){ formData.append('code', this.value)}).get();
                $("select[name='user_id']").map(function(){ formData.append('user_id', this.value)}).get();
                $("input[name='signing_date']").map(function(){ formData.append('signing_date', this.value)}).get();
                $("input[name='start_date']").map(function(){ formData.append('start_date', this.value)}).get();
                $("input[name='finish_date']").map(function(){ formData.append('finish_date', this.value)}).get();
                $("input[name='content']").map(function(){ formData.append('content', this.value)}).get();
                $("input[name='salary']").map(function(){ formData.append('salary', this.value)}).get();

                $("input[name='code_nv']").map(function(){ formData.append('code_nv', this.value)}).get();
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
                $.ajax({
                    url: "{{ route('contracts.store_new_user') }}",
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
<script type="text/javascript">
    $("#user_id").select2({
       placeholder: "Chọn nhân viên",
       closeOnSelect : true,
        tags: false, 
    });

</script>
<script type="text/javascript">
    $("#role_id").select2({
       placeholder: "Chọn chức vụ",
       closeOnSelect : true,
        tags: false, 
    });

</script>
<script type="text/javascript">
    $("#department_id").select2({
       placeholder: "Chọn phòng ban",
       closeOnSelect : true,
        tags: false, 
    });

</script>
<script type="text/javascript">
    $("#salary_id").select2({
       placeholder: "Chọn loại lương",
       closeOnSelect : true,
        tags: false, 
    });
</script>
<script>
  $("#signing_date").blur(function(){
    var ngay_ki_hop_dong = $("#signing_date").val();
    var d = new Date(ngay_ki_hop_dong);
    var today = new Date().toISOString().split("T")[0];
    if(!isNaN(d))
    {
        if(ngay_ki_hop_dong>today)
        {
            document.getElementById("error-parley-select-nkhd").innerHTML="Ngày kí hợp đồng không được lớn hơn ngày hiện tại"
            document.getElementById("btn-submit-form").disabled = true;
        }
        else
        {
            document.getElementById("error-parley-select-nkhd").innerHTML=""
            document.getElementById("btn-submit-form").disabled = false;
        }
    }
    else
    {
        document.getElementById("signing_date").value="";
        document.getElementById("error-parley-select-nkhd").innerHTML=""
    }
  });
</script>
<script>
  $("#finish_date").blur(function(){
    var ngay_ket_thuc = $("#finish_date").val();
    var ngay_bat_dau = $("#start_date").val();
    var d = new Date(ngay_ket_thuc);
    if(!isNaN(d))
    {
        if(ngay_bat_dau!='')
        {
            if(ngay_ket_thuc<ngay_bat_dau)
            {
                document.getElementById("error-parley-select-nkt").innerHTML="Ngày kết thúc không được nhỏ hơn ngày bắt đầu"
                document.getElementById("btn-submit-form").disabled = true;
            }
            else
            {
                document.getElementById("error-parley-select-nkt").innerHTML=""
                document.getElementById("btn-submit-form").disabled = false;
            }
        }
    }
    else
    {
        document.getElementById("finish_date").value="";
        document.getElementById("error-parley-select-nkt").innerHTML=""
    }
  });
</script>
<script>
  $("#start_date").blur(function(){
    $("#finish_date").val('');
    var ngay_bat_dau = $("#start_date").val();
    var d = new Date(ngay_bat_dau);
    if(isNaN(d))
    {
        document.getElementById("start_date").value="";
    }
  });
</script>
@endsection
@endsection
