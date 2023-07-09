@extends('master')
@section('main-content')
<div class="admin-data-content layout-top-spacing">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" id="frm-them-moi" data-parsley-validate="" novalidate>
                        @csrf
                        <div class="col-md-6 col-sm-12 mb-2" >
                            <label class="form-label" for="ten">Số ngày đi làm một tháng<span class="required"> *</span></label>
                            <input type="number" class="form-control" name="work_date_in_month" id="work_date_in_month"
                            oninput="myFunction()"
                            onkeypress="return isNumberKey(event)"
                            value="{{$config->work_date_in_month}}"
                            placeholder="Nhập số ngày làm một tháng"
                            data-parsley-required-message="Vui lòng nhập số ngày làm một tháng"
                            data-parsley-min="1" 
                            data-parsley-min-message="Vui lòng nhập số ngày làm một tháng lớn hơn 0"
                            data-parsley-max="31" 
                            data-parsley-max-message="Vui lòng nhập số ngày làm một tháng nhỏ hơn 31"
                            required>
                        </div>
                        <div class="col-md-6 col-sm-12 mb-2" >
                            <label class="form-label" for="ten">Giờ vào làm<span class="required"> *</span></label>
                            <input type="time" class="form-control" name="in_hour" id="in_hour"
                            value="{{$config->in_hour}}"
                            data-parsley-required-message="Vui lòng nhập giờ vào làm"
                            required>
                        </div>
                        <div class="col-md-6 col-sm-12 mb-2" >
                            <label class="form-label" for="ten">Giờ tan làm<span class="required"> *</span></label>
                            <input type="time" class="form-control" name="out_hour" id="out_hour"
                            value="{{$config->out_hour}}"
                            data-parsley-required-message="Vui lòng nhập giờ tan làm"
                            required>
                        </div>
                        <div class="col-md-12 mt-3">
                            <button id="btn-submit-form" type="button" class="btn btn-primary px-5">Lưu</button>
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
  var x=document.getElementById("work_date_in_month").value;
  if(isNaN(x))
  {
    document.getElementById("work_date_in_month").value="";
  }
}
</script>
<script>
    $('#btn-submit-form').click(function() {
        if($('#frm-them-moi').parsley().validate()) {
            var formData = new FormData();
                $("input[name='work_date_in_month']").map(function(){ formData.append('work_date_in_month', this.value)}).get();
                $("input[name='in_hour']").map(function(){ formData.append('in_hour', this.value)}).get();
                $("input[name='out_hour']").map(function(){ formData.append('out_hour', this.value)}).get();
                $.ajax({
                    url: "{{ route('config.update') }}",
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
@endsection
@endsection
