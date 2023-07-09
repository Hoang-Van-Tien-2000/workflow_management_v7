@extends('master')
@section('main-content')
@section('title', 'Cập nhật dự án')
    <style>
        htl input[type=&#34;
        range&#34;

        ] {
            outline: 0;
            border: 0;
            border-radius: 500px;
            width: 400px;
            max-width: 100%;
            margin: 24px 0 16px;
            transition: box-shadow 0.2s ease-in-out;
        }

        @media screen and (-webkit-min-device-pixel-ratio: 0) {
            input[type=&#34;
            range&#34;

            ] {
                overflow: hidden;
                height: 40px;
                -webkit-appearance: none;
                background-color: #ddd;
            }

            input[type=&#34;
            range&#34;

            ]::-webkit-slider-runnable-track {
                height: 40px;
                -webkit-appearance: none;
                color: #444;
                transition: box-shadow 0.2s ease-in-out;
            }

            input[type=&#34;
            range&#34;

            ]::-webkit-slider-thumb {
                width: 40px;
                -webkit-appearance: none;
                height: 40px;
                cursor: ew-resize;
                background: #fff;
                box-shadow: -340px 0 0 320px #1597ff, inset 0 0 0 40px #1597ff;
                border-radius: 50%;
                transition: box-shadow 0.2s ease-in-out;
                position: relative;
            }

            html input[type=&#34;
            range&#34;

            ]:active::-webkit-slider-thumb {
                background: #fff;
                box-shadow: -340px 0 0 320px #1597ff, inset 0 0 0 3px #1597ff;
            }
        }

        input[type=&#34;
        range&#34;

        ]::-moz-range-progress {
            background-color: #43e5f7;
        }

        input[type=&#34;
        range&#34;

        ]::-moz-range-track {
            background-color: #9a905d;
        }

        input[type=&#34;
        range&#34;

        ]::-ms-fill-lower {
            background-color: #43e5f7;
        }

        html input[type=&#34;
        range&#34;

        ]::-ms-fill-upper {
            background-color: #9a905d;
        }

        #h4-container {
            width: 400px;
            max-width: 100%;
            padding: 0 20px;
            box-sizing: border-box;
            position: relative;
        }

        #h4-container #h4-subcontainer {
            width: 100%;
            position: relative;
        }

        #h4-container #h4-subcontainer h4 {
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            top: 0;
            width: 40px;
            height: 40px;
            color: #fff !important;
            font-size: 12px;
            transform-origin: center -10px;
            transform: translateX(-50%);
            transition: margin-top 0.15s ease-in-out, opacity 0.15s ease-in-out;
        }

        #h4-container #h4-subcontainer h4 span {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background-color: #1597ff;
            border-radius: 0 50% 50% 50%;
            transform: rotate(45deg);
            z-index: -1;
        }

        input:not(:active)+#h4-container h4 {
            opacity: 0;
            margin-top: -50px;
            pointer-events: none;
        }
    </style>
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
                                            <label class="form-label" for="name">Nhập tên dự án<span class="required">
                                                *</span></label>
                                            <input class="form-control" name="name" type="text"
                                                data-parsley-required-message="Vui lòng nhập tên dự án" required
                                                value="{{ $work->name }}">
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
                                                <option value="Thấp" @if ($work->priority == 'Thấp') selected @endif>
                                                    Thấp</option>
                                                <option value="Vừa" @if ($work->priority == 'Vừa') selected @endif>Vừa
                                                </option>
                                                <option value="Cao" @if ($work->priority == 'Cao') selected @endif>Cao
                                                </option>
                                                <option value="Rất cao" @if ($work->priority == 'Rất cao') selected @endif>
                                                    Rất cao</option>
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
                                                <option value="Nhỏ" @if ($work->size == 'Nhỏ') selected @endif>Nhỏ
                                                </option>
                                                <option value="Vừa" @if ($work->size == 'Vừa') selected @endif>Vừa
                                                </option>
                                                <option value="Lớn" @if ($work->size == 'Lớn') selected @endif>Lớn
                                                </option>
                                            </select>
                                            <div id="error-parley-select-size"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            {{-- {{dd($work->starting)}} --}}
                                            <label class="form-label" for="name">Ngày bắt đầu<span class="required">
                                                *</span></label>
                                            <input class="form-control" name="startdate" type="date"
                                                data-parsley-required-message="Vui lòng nhập ngày bắt đầu" required
                                                value="{{ \Carbon\Carbon::createFromFormat('d/m/Y', $work->starting)->format('Y-m-d') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="name">Ngày kết thúc<span class="required">
                                                *</span></label>
                                            <input class="form-control" name="enddate" type="date"
                                                data-parsley-required-message="Vui lòng nhập ngày kết thúc" required
                                                value="{{ \Carbon\Carbon::createFromFormat('d/m/Y', $work->ending)->format('Y-m-d') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <textarea placeholder=="Chi tiết dự án" class="form-control" id="exampleFormControlTextarea4" name="detail"
                                                rows="3">{{ $work->detail }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="text-end">
                                            <button id="btn-submit-form" type="button" class="btn btn-primary me-3">Cập
                                                nhật</button>
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
                formData.append('id', {{ $work->id }});
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
                $("input[name='progress']").map(function() {
                    formData.append('progress', this.value)
                }).get();

                $.ajax({
                    url: "{{ route('project.update') }}",
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
        $("#status").select2({
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
    <script>
        $(function() {
            var rangePercent = $('[type="range"]').val();
            $('[type="range"]').on('change input', function() {
                rangePercent = $('[type="range"]').val();
                $('h4').html(rangePercent + '<span></span>');
                $('[type="range"], h4>span').css('filter', 'hue-rotate(-' + rangePercent + 'deg)');
                // $('h4').css({'transform': 'translateX(calc(-50% - 20px)) scale(' + (1+(rangePercent/100)) + ')', 'left': rangePercent+'%'});
                $('h4').css({
                    'transform': 'translateX(-50%)',
                    'left': rangePercent + '%'
                });
            });
        });
    </script>
@endsection
