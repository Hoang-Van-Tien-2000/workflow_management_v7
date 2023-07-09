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
                                <div id="error-parley-select-fd" class="error-date"></div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6 col-sm-12" >
                                <label class="form-label" for="ten">Tên nhân viên<span class="required"> *</span></label>
                                <select class="form-control"
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
                                <label class="form-label" for="ten">Số ngày nghĩ<span class="required"> *</span></label>
                                <input type="text" class="form-control" id="total_day" name="total_day" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12" >
                                <label class="form-label" for="ten-loai">Lý do<span class="required"> *</span></label>
                                <input type="text" class="form-control" id="reason" name="reason" 
                                placeholder="Nhập lý do"
                                data-parsley-required-message="Vui lòng nhập lý do"
                                data-parsley-maxlength="191"
                                data-parsley-maxlength-message="Lý do thể nhập quá 191 ký tự"
                                required>
                            </div>
                        </div>
                        <div class="d-lg-flex justify-content-end">
                            <div class="row mt-3" >
                                <div class="col-md-6 mb-3">
                                    <button id="btn-submit-form" type="button" class="btn btn-primary px-5">Lưu</button>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{route('user.list')}}"class="btn btn-outline-primary px-5">Hủy</a>
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
    $("#user_id").select2({
       placeholder: "Chọn nhân viên",
       closeOnSelect : true,
        tags: false, 
    });
</script>

<script>
    $('#btn-submit-form').click(function() {
        if($('#frm-them-moi').parsley().validate()) {
            var formData = new FormData();
                $("input[name='start_date']").map(function(){ formData.append('start_date', this.value)}).get();
                $("input[name='finish_date']").map(function(){ formData.append('finish_date', this.value)}).get();
                $("select[name='user_id']").map(function(){ formData.append('user_id', this.value)}).get();
                $("input[name='reason']").map(function(){ formData.append('reason', this.value)}).get();
                $.ajax({
                    url: "{{ route('annual_leave.store') }}",
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
<script>
    $("#finish_date").blur(function(){
        var ngay_bat_dau  = $("#start_date").val();
        var ngay_ket_thuc = $("#finish_date").val();
        var date1 = new Date(ngay_bat_dau);
        var date2 = new Date(ngay_ket_thuc);
        var difference = date2.getTime() - date1.getTime();
        var days = Math.ceil(difference / (1000 * 3600 * 24)) + 1;
        var today = new Date().toISOString().split("T")[0];

        var d = new Date(ngay_ket_thuc);
        if(!isNaN(d))
        {
            if(ngay_bat_dau !='')
            {
                if(ngay_bat_dau>ngay_ket_thuc)
                {
                    $("#error-parley-select-fd").html("Ngày nghĩ đến không được nhỏ hơn ngày nghĩ từ");
                    $( "#btn-submit-form" ).prop( "disabled", true );
                    $("#total_day").val('');
                }
                else
                {
                    $("#error-parley-select-fd").html("");
                    $("#total_day").val(days);
                    $( "#btn-submit-form" ).prop( "disabled", false );
                }
            }
        }
        else
        {
            document.getElementById("finish_date").value="";
            document.getElementById("error-parley-select-fd").innerHTML=""
        }
    });
</script>
<script>
  $("#start_date").blur(function(){
    $("#finish_date").val("");
    $("#error-parley-select-fd").html("");
    var ngay_bat_dau  = $("#start_date").val();
    var ngay_ket_thuc = $("#finish_date").val();
    var d = new Date(ngay_bat_dau);
    var today = new Date().toISOString().split("T")[0];
    if(!isNaN(d))
    {
        if(ngay_bat_dau<today)
        {
            $("#error-parley-select-nbd").html("Ngày bắt đầu không được nhỏ hơn ngày hiện tại");
            $( "#btn-submit-form" ).prop( "disabled", true );
        }
        else
        {
            $("#error-parley-select-nbd").html("");
            $( "#btn-submit-form" ).prop( "disabled", false );
        }
    }
    else
    {
        $("#start_date").val("")
        $("#error-parley-select-nbd").html("");
    }
  });
</script>
@endsection
@endsection