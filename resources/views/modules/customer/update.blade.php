@extends('master')
@section('main-content')
@section('title', 'Cập nhật khách hàng')
    <div class="admin-data-content layout-top-spacing">
        <div class="row project-cards">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" id="frm-cap-nhat" data-parsley-validate="" novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-md-12 col-sm-12" style="margin-bottom:1%">
                                    <input type="text" class="form-control" id="code" name="code"
                                        value="{{ $customer->code }}" readonly>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12" style="margin-bottom:1%">
                                    <label class="form-label" for="name">Tên khách hàng<span class="required">
                                        *</span></label>
                                    <input type="text" class="form-control" id="username" name="name"
                                        data-parsley-required-message="Vui lòng nhập tên khách hàng"
                                        data-parsley-maxlength="191"
                                        data-parsley-maxlength-message="Tên khách hàng không thể nhập quá 191 ký tự"
                                        required value="{{ $customer->name }}">
                                </div>
                                <div class="col-md-6 col-sm-12" style="margin-bottom:1%">
                                    <label class="form-label" for="name">Số điện thoại<span class="required">
                                        *</span></label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        placeholder="Số điện thoại..."
                                        oninput="myFunction()"
                                        onkeypress="return isNumberKey(event)"
                                        data-parsley-maxlength-message="Số điện thoại tối đa 10 số"
                                        data-parsley-maxlength="10"
                                        data-parsley-required-message="Vui lòng nhập số điện thoại"
                                        value="{{ $customer->phone }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12" style="margin-bottom:1%">
                                    <label class="form-label" for="name">Email<span class="required">
                                        *</span></label>
                                    <input type="email" class="form-control" id="email" name="email"
                                         data-parsley-type="email"
                                        data-parsley-type-message="Email không đúng định dạng"
                                        data-parsley-required-message="Vui lòng nhập email" data-parsley-maxlength="191"
                                        data-parsley-maxlength-message="Email không thể nhập quá 191 ký tự" required
                                        value="{{ $customer->email }}">
                                </div>
                                <div class="col-md-6 col-sm-12" style="margin-bottom:1%">
                                    <label class="form-label" for="name">Địa chỉ<span class="required">
                                        *</span></label>
                                    <input type="text" class="form-control" id="address" name="address"
                                        data-parsley-maxlength="191"
                                        data-parsley-maxlength-message="Địa chỉ không thể nhập quá 191 ký tự"
                                        data-parsley-required-message="Vui lòng nhập địa chỉ" required
                                        value="{{ $customer->address }}">
                                </div>
                            </div>
                            <div class="d-lg-flex justify-content-end">
                                <div class="row mt-3">
                                    <div class="col-md-6 mb-3">
                                        <button id="btn-submit-form" type="button"
                                            class="btn btn-primary px-5">Lưu</button>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="{{ route('customer.list') }}"class="btn btn-outline-primary px-5">Hủy</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-js')
    <script>
        $('#btn-submit-form').click(function() {
            if ($('#frm-cap-nhat').parsley().validate()) {
                var formData = new FormData();
                $("input[name='code']").map(function() {
                    formData.append('code', this.value)
                }).get();
                $("input[name='name']").map(function() {
                    formData.append('name', this.value)
                }).get();
                $("input[name='phone']").map(function() {
                    formData.append('phone', this.value)
                }).get();
                $("input[name='email']").map(function() {
                    formData.append('email', this.value)
                }).get();
                $("input[name='birthday']").map(function() {
                    formData.append('birthday', this.value)
                }).get();
                $("input[name='phone']").map(function() {
                    formData.append('phone', this.value)
                }).get();
                $("input[name='address']").map(function() {
                    formData.append('address', this.value)
                }).get();
                $("input[name='address']").map(function() {
                    formData.append('address', this.value)
                }).get();
                $.ajax({
                    url: "{{ route('customer.update') }}",
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
@endsection
