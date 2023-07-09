@extends('master')
@section('main-content')
<div class="admin-data-content layout-top-spacing">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" id="frm-them-moi" data-parsley-validate="" novalidate>
                        @csrf
                        <input type="text" class="form-control" id="id" name="id" value="{{$salary->id}}" readonly>
                        <div class="row">
                            <div class="col-md-6" style="margin-bottom:1%">
                                <label class="form-label" for="ten">Tên nhân viên<span class="required"> *</span></label>
                                <input type="text" class="form-control" id="user_id" name="user_id"
                                    value="{{$salary->user->fullname}}" readonly>
                            </div>
                            <div class="col-md-6" style="margin-bottom:1%">
                                <label class="form-label" for="ten">Lương cơ bản<span class="required"> *</span></label>
                                <input type="text" class="form-control" id="contract_id" name="contract_id"
                                    value="{{$salary->contract->salary}}" readonly>
                            </div>
                            <div class="col-md-6" style="margin-bottom:1%">
                                <label class="form-label" for="ten">Số ngày làm việc<span class="required"> *</span></label>
                                <input type="text" class="form-control" id="working_day" name="working_day"
                                    value="{{$salary->working_day}}" readonly>
                            </div>
                            <div class="col-md-6" style="margin-bottom:1%">
                                <label class="form-label" for="ten">Trợ cấp<span class="required"> *</span></label>
                                <input type="text" class="form-control" id="allowance" name="allowance"
                                    value="{{$salary->allowance}}" readonly>
                            </div>
                            <div class="col-md-6" style="margin-bottom:1%">
                                <label class="form-label" for="ten">Tổng cộng<span class="required"> *</span></label>
                                <input type="text" class="form-control" id="total" name="total"
                                    value="{{$salary->total}}" readonly>
                            </div>
                            <div class="col-md-6" style="margin-bottom:1%">
                                <label class="form-label" for="ten">Tạm ứng<span class="required"> *</span></label>
                                <input type="text" class="form-control" id="advance" name="advance"
                                    value="{{$salary->advance}}" readonly>
                            </div>
                            <div class="col-md-6" style="margin-bottom:1%">
                                <label class="form-label" for="ten">Khen thưởng<span class="required"> *</span></label>
                                <input type="text" class="form-control" id="sum_bonus" name="sum_bonus"
                                    @if($salary->sum_bonus != null) value="{{$salary->sum_bonus}}" @else value="0" @endif readonly>
                            </div>
                            <div class="col-md-6" style="margin-bottom:1%">
                                <label class="form-label" for="ten">Xử phạt<span class="required"> *</span></label>
                                <input type="text" class="form-control" id="sum_discipline" name="sum_discipline"
                                @if($salary->sum_discipline != null) value="{{$salary->sum_discipline}}" @else value="0" @endif readonly>
                            </div>
                            <div class="col-md-6" style="margin-bottom:1%">
                                <label class="form-label" for="ten">Lương thực nhận<span class="required"> *</span></label>
                                <input type="text" class="form-control" id="actual_salary" name="actual_salary"
                                    value="{{$salary->actual_salary}}" readonly>
                            </div>
                            <div class="col-md-6" style="margin-bottom:1%">
                                <label class="form-label" for="ten">Nội dung<span class="required"> *</span></label>
                                <input type="text" class="form-control" id="noi_dung" name="noi_dung">
                            </div>
                        </div>
                        <div class="d-lg-flex justify-content-end">
                            <div class="row mt-3" >
                                <div class="col-md-12 mb-3">
                                    <button id="btn-submit-form" type="button" class="btn btn-primary px-5">Gửi</button>
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
    $('#btn-submit-form').click(function() {
        if($('#frm-them-moi').parsley().validate()) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $("input[name='_token']").val()
                }
            })
            var formData = new FormData();
                $("input[name='id']").map(function(){ formData.append('id', this.value)}).get();
                $("input[name='noi_dung']").map(function(){ formData.append('noi_dung', this.value)}).get();
                
                $.ajax({
                    url: "{{ route('pay_salaries.send_mail') }}",
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
