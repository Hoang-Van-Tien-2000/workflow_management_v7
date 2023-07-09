@extends('master')
@section('title', 'Thống kê công việc')
@section('main-content')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <div class="card">
        <div class="card-body">
            <div class="ms-auto">
                <div class="row mb-3">
                    {{-- <div class="col-sm-12 col-md-4">
                        <label class="form-label" for="mo-ta">Ngày tháng</label>
                        <input class="form-control" type="text" id="time_to" data-date-format="dd/mm/yy"
                            name="daterange" value="{{$value}}" />
                    </div> --}}
                    <div class="col-sm-12 col-md-4">
                        <label class="form-label" for="mo-ta">Mã nhân viên</label>
                        <select multiple="multiple" class="form-control" id="code" name="code">
                            @foreach ($code as $value)
                                <option value="{{ $value->code }}">{{ $value->code }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <label class="form-label" for="mo-ta">Tên nhân viên</label>
                        <select multiple="multiple" class="form-control" id="name" name="name">
                            @foreach ($name as $value)
                                <option value="{{ $value->fullname }}">{{ $value->fullname }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                {{-- <button class="btn-export" id="exportExcel">Xuất Excel</button> --}}
            </div>
            <div class="table-responsive">
                <table id="statistic" class="table table-striped table-bordered table-custom-text">
                    <thead class="table-light">
                        <tr>
                            <th style="display: none">ID</th>
                            <th style="width: 15%">Mã nhân viên</th>
                            <th style="width: 30%">Tên nhân viên</th>
                            <th style="width: 10%">Tổng đang làm</th>
                            <th style="width: 10%">Tổng hoàn thành</th>
                            <th style="width: 10%">Tổng trễ hạn</th>
                            <th style="width: 10%">Chức năng</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('page-css')
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/dt-global_style.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/custom_dt_custom.css') }}">
@endsection

@section('page-js')
<script src="{{ asset('plugins/table/datatable/datatables.js') }}"></script>
    {{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script></script>
    <script type="text/javascript">
        $(function() {
            $('input[name="daterange"]').daterangepicker({
                opens: 'left'
            }, function(start, end, label) {
                var filterTimeFrom = `${start.format('YYYY-MM-DD')}.${end.format('YYYY-MM-DD')}`;                
                table.columns(4).search(filterTimeFrom).draw();
                $("#btn-ap-dung").attr('disabled', true);
                $("th.select-checkbox").removeClass("selected");
                // data = `${start.format('YYYY-MM-DD')} - ${end.format('YYYY-MM-DD')}`;
            });
        });
        $("#code").multipleSelect({
            placeholder: 'Chọn mã nhân viên',
            filter: true,
            showClear: true,
            position: 'bottom',
            minimumCountSelected: 1,
            filterPlaceholder: 'Tìm kiếm',
            openOnHover: false,
            formatSelectAll() {
                return 'Chọn tất cả'
            },
            formatAllSelected() {
                return 'Đã chọn tất cả'
            },
            formatCountSelected(count, total) {
                return 'Đã chọn ' + count + ' trên ' + total
            },
            formatNoMatchesFound() {
                return 'Không tìm thấy kết quả'
            },
            onClose: function() {
                var filtercode = JSON.stringify($("#code").val())
                var filtername = JSON.stringify($("#name").val())
                table.columns(1).search(filtercode).draw();
                table.columns(2).search(filtername).draw();
                $("#btn-ap-dung").attr('disabled', true);
                $("th.select-checkbox").removeClass("selected")
            },
            onClear: function() {
                var filtercode = JSON.stringify($("#code").val())
                var filtername = JSON.stringify($("#name").val())
                table.columns(1).search(filtercode).draw();
                table.columns(2).search(filtername).draw();
                $("#btn-ap-dung").attr('disabled', true);
                $("th.select-checkbox").removeClass("selected")
            }
        });

        $("#name").multipleSelect({
            placeholder: 'Chọn tên nhân viên',
            filter: true,
            showClear: true,
            position: 'bottom',
            minimumCountSelected: 1,
            filterPlaceholder: 'Tìm kiếm',
            openOnHover: false,
            formatSelectAll() {
                return 'Chọn tất cả'
            },
            formatAllSelected() {
                return 'Đã chọn tất cả'
            },
            formatCountSelected(count, total) {
                return 'Đã chọn ' + count + ' trên ' + total
            },
            formatNoMatchesFound() {
                return 'Không tìm thấy kết quả'
            },
            onClose: function() {
                var filtercode = JSON.stringify($("#code").val())
                var filtername = JSON.stringify($("#name").val())
                table.columns(1).search(filtercode).draw();
                table.columns(2).search(filtername).draw();
                $("#btn-ap-dung").attr('disabled', true);
                $("th.select-checkbox").removeClass("selected")
            },
            onClear: function() {
                var filtercode = JSON.stringify($("#code").val())
                var filtername = JSON.stringify($("#name").val())
                table.columns(1).search(filtercode).draw();
                table.columns(2).search(filtername).draw();
                $("#btn-ap-dung").attr('disabled', true);
                $("th.select-checkbox").removeClass("selected")
            }
        });

        $("#select-chon-hang-loat").select2({
            placeholder: "Chọn thao tác",
            allowClear: true,
            minimumResultsForSearch: -1
        });
    </script>
    <script>
        var table;
        resetTable()
        function resetTable() {
            table = $('#statistic').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                pageLength: 25,
                language: {
                    emptyTable: "Không tồn tại dữ liệu",
                    zeroRecords: "Không tìm thấy dữ liệu",
                    info: "Hiển thị từ _START_ đến _END_ trong _TOTAL_ mục",
                    infoEmpty: "0 bảng ghi được hiển thị",
                    infoFiltered: "",
                    select: {
                        rows: "",
                    },
                    lengthMenu: "Hiển thị _MENU_ mục",
                    processing: "<span class='text-primary'>Đang tải dữ liệu...</span>",
                    oPaginate: {
                        sNext: '<i class="fa-solid fa-angle-right"></i>',
                        sPrevious: '<i class="fa-solid fa-angle-left"></i>',
                        sFirst: '<i class="fa fa-step-backward"></i>',
                        sLast: '<i class="fa fa-step-forward"></i>'
                    }
                },
                ajax: {
                    url: "{{ route('statistic.task.load_ajax_statistic_task') }}",
                    type: 'get'
                },
                select: {
                    style: 'multi',
                    selector: 'td:first-child'
                },
                drawCallback: function(oSettings) {
                    if (oSettings._iDisplayLength >= oSettings.fnRecordsDisplay()) {
                        $(oSettings.nTableWrapper).find('.dataTables_paginate').hide();
                    } else {
                        $(oSettings.nTableWrapper).find('.dataTables_paginate').show();
                    }

                    if (oSettings.fnRecordsDisplay() == 0) {
                        $(oSettings.nTableWrapper).find('.dataTables_info').hide();
                    }
                },
                columns: [{
                        name: 'id',
                        defaultContent: '',
                        data: 'id',
                        visible: false,
                        bSortable: true
                    },
                    {
                        name: 'code',
                        defaultContent: '',
                        data: 'code',
                        bSortable: true
                    },
                    {
                        name: 'fullname',
                        defaultContent: '',
                        data: 'fullname',
                        bSortable: true
                    },
                    {
                        name: 'danglam_count',
                        defaultContent: '',
                        data: 'danglam_count',
                        bSortable: true
                    },
                    {
                        name: 'hoanthanh_count',
                        defaultContent: '',
                        data: 'hoanthanh_count',
                        bSortable: true
                    },
                    {
                        name: 'trehan_count',
                        defaultContent: '',
                        data: 'trehan_count',
                        bSortable: true
                    },
                    
                ],
                columnDefs: [
                    {
                        targets: 6,
                        render: function(data, type, columns) {
                            var url = "./cong-viec/chi-tiet/" + columns.phone;
                            return '<div class="d-flex order-actions">' +
                                '<a data-toggle="tooltip" data-placement="right" title="Cập nhật" href="' +url + '" class="btn-edit ms-3"><i class="bx bxs-edit "></i></a>' +
                                '</div>'
                        }
                    },
                ],
                ordering: true,
                order: [
                    [1, 'desc']
                ],

            });
        }
    </script>
    @endsection