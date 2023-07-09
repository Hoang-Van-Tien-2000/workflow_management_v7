@extends('master')
@section('main-content')
<div class="admin-data-content layout-top-spacing">
    <div class="row project-cards">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="widget-content widget-content-area">
                        <form method="POST" id="frm-them-moi" data-parsley-validate="" novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-md-6 col-sm-12" >
                                    <label class="form-label" for="ten">Tên nhân viên<span class="required"> *</span></label>
                                    <select class="form-control custom-select2"
                                        data-parsley-required-message="Vui lòng chọn nhân viên"
                                        data-parsley-errors-container="#error-parley-select-nv"
                                        required
                                        id="user_id" name="user_id">
                                        <option value=""></option>
                                        @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->fullname }}</option>
                                        @endforeach
                                    </select>
                                    <div id="error-parley-select-nv"></div>
                                </div>
                                <div class="col-md-6 col-sm-12" >
                                    <label class="form-label" for="ten">Chức danh<span class="required"> *</span></label>
                                    <input type="text" class="form-control" id="salary_name" name="salary_name" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-sm-12" >
                                    <label class="form-label" for="ten">Ngày công<span class="required"> *</span></label>
                                    <input type="text" class="form-control" id="working_day" name="working_day"
                                    data-parsley-max="31"
                                    data-parsley-max-message="Vui lòng nhập ngày công nhỏ hơn 31"
                                    data-parsley-required-message="Vui lòng nhập ngày ngày công"
                                    required >
                                </div>
                                <div class="col-md-6 col-sm-12" >
                                    <label class="form-label" for="ten">Lương cơ bản<span class="required"> *</span></label>
                                    <input type="text" class="form-control" id="salary_payable" name="salary_payable" 
                                    readonly>
                                </div>
                            
                            </div>
                            <div class="row">
                            <div class="col-md-6 col-sm-12" >
                                    <label class="form-label" for="ten">Lương<span class="required"> *</span></label>
                                    <input type="text" class="form-control" id="salary" name="salary" 
                                    data-parsley-maxlength="20"
                                    data-parsley-maxlength-message="Lương không thể nhập quá 20 ký tự"
                                    readonly>
                                </div>
                                <div class="col-md-6 col-sm-12" style="margin-bottom:1%">
                                    <label class="form-label" for="ten">Phụ cấp<span class="required"> *</span></label>
                                    <input type="text" class="form-control" id="allowance" name="allowance"
                                    placeholder="Phụ cấp"
                                    data-parsley-required-message="Vui lòng nhập lương phụ cấp"
                                    data-parsley-maxlength="20"
                                    data-parsley-maxlength-message="Lương phụ cấp không thể nhập quá 20 ký tự"
                                    required>
                                </div>
                                <div class="col-md-6 col-sm-12" style="margin-bottom:1%">
                                    <label class="form-label" for="ten">Tổng cộng<span class="required"> *</span></label>
                                    <input type="text" class="form-control" id="total" 
                                    data-parsley-maxlength="20"
                                    data-parsley-maxlength-message="Lương tổng cộng không thể nhập quá 20 ký tự"
                                    name="total" readonly>
                                </div>
                                <div class="col-md-6 col-sm-12" style="margin-bottom:1%">
                                    <label class="form-label" for="ten">Tạm ứng<span class="required"> *</span></label>
                                    <input type="text" class="form-control" id="advance" name="advance"
                                    placeholder="Lương tạm ứng"
                                    data-parsley-required-message="Vui lòng nhập lương tạm ứng"
                                    data-parsley-maxlength="20"
                                    data-parsley-maxlength-message="Lương tạm ứng không thể nhập quá 20 ký tự"
                                    required>
                                </div>
                                <div class="col-md-6 col-sm-12" style="margin-bottom:1%">
                                    <label class="form-label" for="ten">Lương nhận thực<span class="required"> *</span></label>
                                    <input type="text" class="form-control" id="actual_salary" name="actual_salary" 
                                    data-parsley-maxlength="20"
                                    data-parsley-maxlength-message="Lương nhận thực không thể nhập quá 20 ký tự"
                                    readonly>
                                </div>
                                <div class="col-md-6 col-sm-12" >
                                    <label class="form-label" for="ten">Trạng thái<span class="required"> *</span></label>
                                    <select class="form-control "
                                        data-parsley-required-message="Vui lòng chọn trạng thái"
                                        data-parsley-errors-container="#error-parley-select-tt"
                                        required
                                        id="status" name="status">
                                            <option></option>
                                            <option value = 1 >Đã xác nhận</option>
                                            <option value = 0 >Chưa xác nhận</option>
                                    </select>
                                    <div id="error-parley-select-tt"></div>
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
</div>
@section('page-js')
<script>
    $('#btn-submit-form').click(function() {
        if($('#frm-them-moi').parsley().validate()) {
            var formData = new FormData();
                $("select[name='user_id']").map(function(){ formData.append('user_id', this.value)}).get();
                $("input[name='salary_name']").map(function(){ formData.append('salary_name', this.value)}).get();
                $("input[name='working_day']").map(function(){ formData.append('working_day', this.value)}).get();
                $("input[name='salary']").map(function(){ formData.append('salary', this.value)}).get();
                $("input[name='allowance']").map(function(){ formData.append('allowance', this.value)}).get();
                $("input[name='total']").map(function(){ formData.append('total', this.value)}).get();
                $("input[name='advance']").map(function(){ formData.append('advance', this.value)}).get();
                $("input[name='actual_salary']").map(function(){ formData.append('actual_salary', this.value)}).get();
                $("select[name='status']").map(function(){ formData.append('status', this.value)}).get();

                $.ajax({
                    url: "{{ route('pay_salaries.store') }}",
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
    $("#salary_id").select2({
       placeholder: "Chọn chức danh",
       closeOnSelect : true,
        tags: false, 
    });

</script>

<script type="text/javascript">
    $("#status").select2({
       placeholder: "Chọn trạng thái",
       closeOnSelect : true,
        tags: false, 
    });

</script>

<script type="text/javascript">
    var token = $("input[name='_token']").val();
    $('#user_id').change(function(){
        var id=$("#user_id").val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': token
        }
    });
    if(id!=0)
    {
        $.ajax({
            url: "{{route('salary.show')}}",
            data: { "id": $("#user_id").val() },
            dataType:"json",
            type: "post",
            success: function(data){
                var chuc_danh=data["name"];
                var luong_co_ban=data["salary_payable"];
                document.getElementById('salary_name').value = chuc_danh;
                document.getElementById('salary_payable').value = luong_co_ban;
            }
        });
    }
    // else
    // {
    //     document.getElementById('ten_sp').value = '';
    // }
});
</script>

<script>
  $("#working_day").blur(function(){
    var working_day = $("#working_day").val();
    var salary_payable = $("#salary_payable").val();
    var luong= Number(working_day)*Number(salary_payable);
    $("#salary").val(luong);
    var allowance = $("#allowance").val();
    var tongcong= Number(luong)+Number(allowance);
    $("#total").val(tongcong);
    var advance = $("#advance").val();
    var tienthuc = Number(tongcong)-Number(advance);
    $("#actual_salary").val(tienthuc);
    
  });
</script>

<script>
  $("#allowance").blur(function(){
    var salary = $("#salary").val();
    var allowance = $("#allowance").val();
    var tongcong= Number(salary)+Number(allowance);
    $("#total").val(tongcong);
    var advance = $("#advance").val();
    var tienthuc = Number(tongcong)-Number(advance);
    $("#actual_salary").val(tienthuc);
  });
</script>
<script>
  $("#advance").blur(function(){
    var total = $("#total").val();
    var advance = $("#advance").val();
    var tienthuc = Number(total)-Number(advance);
    $("#actual_salary").val(tienthuc);
  });
</script>
@endsection
@endsection
