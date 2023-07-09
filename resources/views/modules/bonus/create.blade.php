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
                            <div class="col-md-6 col-sm-12" style="margin-bottom:1%">
                                <label class="form-label" for="ten">Lý do<span class="required"> *</span></label>
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
                                <label class="form-label" for="ten">Lương thưởng<span class="required"> *</span></label>
                                <input type="text" class="form-control" name="salary_bonus" id="salary_bonus"
                                oninput="myFunction()"
                                onkeypress="return isNumberKey(event)"
                                placeholder="Nhập lương thưởng"
                                data-parsley-required-message="Vui lòng nhập lương thưởng"
                                data-parsley-maxlength="20"
                                data-parsley-maxlength-message="Lương thưởng không thể nhập quá 20 kí tự"
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
  var x=document.getElementById("salary_bonus").value;
  if(isNaN(x))
  {
    document.getElementById("salary_bonus").value="";
  }
}
</script>
<script>
    $('#btn-submit-form').click(function() {
        if($('#frm-them-moi').parsley().validate()) {
            var formData = new FormData();
                $("select[name='user_id']").map(function(){ formData.append('user_id', this.value)}).get();
                $("input[name='salary_bonus']").map(function(){ formData.append('salary_bonus', this.value)}).get();
                $("input[name='content']").map(function(){ formData.append('content', this.value)}).get();
                $.ajax({
                    url: "{{ route('bonus.store') }}",
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
@endsection
@endsection
