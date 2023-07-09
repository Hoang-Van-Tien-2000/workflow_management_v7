@extends('master')
@section('main-content')
@section('title', 'Thêm mới dự án')
<div class="admin-data-content layout-top-spacing">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" id="frm-them-moi" data-parsley-validate="" novalidate>
                        @csrf
                        <div class="form theme-form">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="name">Tên dự án<span class="required">
                                                *</span></label>
                                        <input class="form-control" name="name" type="text"
                                            data-parsley-required-message="Vui lòng nhập tên dự án" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="name">Mức độ<span class="required">
                                                *</span></label>
                                        <select class="form-control custom-select2" style=""
                                            data-parsley-required-message="Vui lòng chọn mức độ"
                                            data-parsley-errors-container="#error-parley-select-priority" required
                                            id="priority" name="priority">
                                            <option></option>
                                            <option value="Thấp">Thấp</option>
                                            <option value="Vừa">Vừa</option>
                                            <option value="Cao">Cao</option>
                                            <option value="Rất cao">Rất cao</option>
                                        </select>
                                        <div id="error-parley-select-priority"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="name">Kích thước<span class="required">
                                                *</span></label>
                                        <select class="form-control custom-select2" style=""
                                            data-parsley-required-message="Vui lòng chọn kích thức"
                                            data-parsley-errors-container="#error-parley-select-size" required
                                            id="size" name="size">
                                            <option></option>
                                            <option value="Nhỏ">Nhỏ</option>
                                            <option value="Vừa">Vừa</option>
                                            <option value="Lớn">Lớn</option>
                                        </select>
                                        <div id="error-parley-select-size"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="startdate">Ngày bắt đầu<span class="required">
                                                *</span></label>
                                        <input value="" class="form-control" name="startdate" type="text"
                                            onfocus="(this.type='datetime-local')"
                                            data-parsley-required-message="Vui lòng nhập ngày bắt đầu" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="enđate">Ngày kết thúc<span class="required">
                                                *</span></label>
                                        <input value="" class="form-control" name="enddate" type="text"
                                            onfocus="(this.type='datetime-local')"
                                            data-parsley-required-message="Vui lòng nhập ngày kết thúc" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <textarea placeholder="Chi tiết dự án" class="form-control" id="exampleFormControlTextarea4" name="detail"
                                            rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="text-end">
                                        <button id="btn-submit-form" type="button"
                                            class="btn btn-primary me-3">Thêm</button>
                                        <a class="btn btn-danger" href="{{ route('project.list') }}">Quay lại</a>
                                    </div>
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
        if ($('#frm-them-moi').parsley().validate()) {
            var formData = new FormData();
            $("input[name='name']").map(function() {
                formData.append('name', this.value)
            }).get();
            $("input[name='rate']").map(function() {
                formData.append('rate', this.value)
            }).get();
            $("select[name='type']").map(function() {
                formData.append('type', this.value)
            }).get();
            $("select[name='priority']").map(function() {
                formData.append('priority', this.value)
            }).get();
            $("select[name='size']").map(function() {
                formData.append('size', this.value)
            }).get();
            $("input[name='startdate']").map(function() {
                formData.append('startdate', this.value)
            }).get();
            $("input[name='enddate']").map(function() {
                formData.append('enddate', this.value)
            }).get();
            $("textarea[name='detail']").map(function() {
                formData.append('detail', this.value)
            }).get();
            $.ajax({
                url: "{{ route('project.store') }}",
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
    $("#priority").select2({
        placeholder: "Chọn mức độ",
        closeOnSelect: true,
        tags: false,
        language: {
            noResults: function(params) {
                return "Không tìm thấy kết quả";
            }
        },
    });
    $("#size").select2({
        placeholder: "Chọn kích thức",
        closeOnSelect: true,
        tags: false,
        language: {
            noResults: function(params) {
                return "Không tìm thấy kết quả";
            }
        },
    });
</script>
@endsection
