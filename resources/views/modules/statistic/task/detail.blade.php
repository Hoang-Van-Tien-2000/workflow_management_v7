@extends('master')
@section('title', 'Thống kê chi tiết công việc')
@section('main-content')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <div class="card">
        <div class="card-body">
            <div class="ms-auto">
                <div class="row mb-3">
                    <div class="col-sm-12 col-md-4">
                        <select multiple="multiple" class="form-control" id="nameproject" name="nameproject">
                            @foreach ($nameProject as $value)
                                @if(!empty($value->Work))
                                    <option value="{{ $value->Work->name }}">{{ $value->Work->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <select multiple="multiple" class="form-control" id="nametask" name="nametask">
                            @foreach ($nameTask as $value)
                                @if(!empty($value->Work))
                                    <option value="{{ $value->task->title }}">{{ $value->task->title }}</option>
                                @endif
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
                            <th style="width: 10%">Tham gia</th>
                            <th style="width: 10%">Tên dự án</th>
                            <th style="width: 10%">Tên công việc</th>
                            <th style="width: 10%">Hạn nộp</th>
                            <th style="width: 10%">Trạng thái</th>
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
        $("#nameproject").multipleSelect({
            placeholder: 'Chọn mã dự án',
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
                var filtertask = JSON.stringify($("#nametask").val())
                var filterproject = JSON.stringify($("#nameproject").val())
                table.columns(2).search(filtertask).draw();
                table.columns(1).search(filterproject).draw();
                $("#btn-ap-dung").attr('disabled', true);
                $("th.select-checkbox").removeClass("selected")
            },
            onClear: function() {
                var filtertask = JSON.stringify($("#nametask").val())
                var filterproject = JSON.stringify($("#nameproject").val())
                table.columns(2).search(filtertask).draw();
                table.columns(1).search(filterproject).draw();
                $("#btn-ap-dung").attr('disabled', true);
                $("th.select-checkbox").removeClass("selected")
            }
        });

        $("#nametask").multipleSelect({
            placeholder: 'Chọn tên công việc',
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
                var filtertask = JSON.stringify($("#nametask").val())
                var filterproject = JSON.stringify($("#nameproject").val())
                table.columns(2).search(filtertask).draw();
                table.columns(1).search(filterproject).draw();
                $("#btn-ap-dung").attr('disabled', true);
                $("th.select-checkbox").removeClass("selected")
            },
            onClear: function() {
                var filtertask = JSON.stringify($("#nametask").val())
                var filterproject = JSON.stringify($("#nameproject").val())
                table.columns(2).search(filtertask).draw();
                table.columns(1).search(filterproject).draw();
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
                    url: "{{ route('statistic.task.load_ajax_detail_statistic_task') }}",
                    "data": {
                            "sdt": "{{$sdt}}",
                        },
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
                columns: [
                    {
                        name: 'updated_at',
                        defaultContent: '',
                        data: 'updated_at',
                        bSortable: true
                    },
                    {
                        name: 'task.work.name',
                        defaultContent: '',
                        data: 'task.work.name',
                        bSortable: true
                    },
                    {
                        name: 'task.title',
                        defaultContent: '',
                        data: 'task.title',
                        bSortable: true
                    },
                    {
                        name: 'task.timeOut',
                        defaultContent: '',
                        data: 'task.timeOut',
                        bSortable: true
                    },
                ],
                columnDefs: [
                    {
                        targets: 4,
                        render: function(data, type, columns) {
                           if(columns.task.status == 0){
                            return '<span class="badge bg-danger" style="background-color:#e7515a !important;border-color:#e7515a;color:#fff">Chưa hoàn thành</span>';

                           }
                           return '<span class="badge bg-primary">Hoàn thành</span>';
                        }
                    },
                    {
                    targets: 5,
                    render: function(data, type, columns) {
                        var view = "../../../du-an/" + columns.task.work.id+"/cong-viec?task="+columns.task.id;
                        return '<div class="d-flex order-actions">' +
                            '<a data-toggle="tooltip" data-placement="right" title="Xem chi tiết" href="'+view+'" target="_blank" style="margin-right:6%"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye table-cancel"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>' +
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