@extends('master')
@section('main-content')
@section('title', 'Trang chủ')
    <div class="admin-data-content layout-top-spacing">
        <div class="row project-cards">
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <div class="avatar-md rounded-circle mr-3">
                                <i class='bx bxs-component'></i>
                            </div>
                            <div class="media-body overflow-hidden">
                                <h5 class="font-14 mt-0 mb-1">Dự án</h5>
                                <p class="mb-1 font-13 text-truncate">150</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <div class="avatar-md rounded-circle mr-3">
                                <i class='bx bx-task'></i>
                            </div>
                            <div class="media-body overflow-hidden">
                                <h5 class="font-14 mt-0 mb-1">Công việc</h5>
                                <p class="mb-1 font-13 text-truncate">200</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <div class="avatar-md rounded-circle mr-3">
                                <i class='bx bx-list-check'></i>
                            </div>
                            <div class="media-body overflow-hidden">
                                <h5 class="font-14 mt-0 mb-1">Công việc hoàn thành</h5>
                                <p class="mb-1 font-13 text-truncate">150</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <div class="avatar-md rounded-circle mr-3">
                                <i class='bx bx-shape-square'></i>
                            </div>
                            <div class="media-body overflow-hidden">
                                <h5 class="font-14 mt-0 mb-1">
                                    Công việc đang làm</h5>
                                <p class="mb-1 font-13 text-truncate">200</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="widget-heading">
                                    <h5 class="">DANH SÁCH NHÂN VIÊN</h5>
                                </div>
                                <div class="statbox widget box box-shadow">
                                    <div class="widget-content widget-content-area">
                                        <table id="user" class="table style-2  table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Mã nhân viên</th>
                                                    <th>Họ tên</th>
                                                    <th>Địa chỉ</th>
                                                    <th>Số điện thoại</th>
                                                    <th>Chức vụ</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="widget-heading">
                                    <h5 class="">DANH SÁCH NGHĨ PHÉP ĐÃ DUYỆT</h5>
                                </div>
                                <div class="statbox widget box box-shadow">
                                    <div class="widget-content widget-content-area">
                                        <table id="annual_leave" class="table style-2  table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Họ tên</th>
                                                    <th>Nghĩ từ ngày</th>
                                                    <th>Nghĩ đến ngày</th>
                                                    <th>Số ngày nghĩ</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/dt-global_style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/custom_dt_custom.css') }}">
@endsection
@section('page-js')
    <script src="{{ asset('plugins/table/datatable/datatables.js') }}"></script>
    <script>
        var table;
        var rows_selected = [];
        resetTable()

        function resetTable() {
            table = $('#user').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                pageLength: 10,
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
                        "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                        "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                    },
                },
                ajax: {
                    url: "{{ route('dashboard.load_ajax_list_user') }}",
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
                        name: 'address',
                        defaultContent: '',
                        data: 'address',
                        bSortable: true
                    },
                    {
                        name: 'phone',
                        defaultContent: '',
                        data: 'phone',
                        bSortable: true
                    },
                    {
                        name: 'role_id',
                        defaultContent: '',
                        data: 'role.name',
                        bSortable: true
                    },
                ],
                columnDefs: [

                ],
                ordering: true,
                order: [
                    [1, 'asc']
                ],
                "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                    "<'table-responsive'tr>" +
                    "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            });
        }
    </script>
    <script>
        var table;
        var rows_selected = [];
        resetTable()

        function resetTable() {
            table = $('#annual_leave').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                pageLength: 10,
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
                        "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                        "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                    },
                },
                ajax: {
                    url: "{{ route('dashboard.load_ajax_list_annual_leave') }}",
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
                        name: 'user_id',
                        defaultContent: '',
                        data: 'user.fullname',
                        bSortable: true
                    },
                    {
                        name: 'start_date',
                        defaultContent: '',
                        data: 'start_date',
                        bSortable: true
                    },
                    {
                        name: 'finish_date',
                        defaultContent: '',
                        data: 'finish_date',
                        bSortable: true
                    },
                    {
                        name: 'total_day',
                        defaultContent: '',
                        data: 'total_day',
                        bSortable: true
                    },
                ],
                columnDefs: [

                ],
                ordering: true,
                order: [
                    [1, 'asc']
                ],
                "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                    "<'table-responsive'tr>" +
                    "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            });
        }
    </script>
@endsection
@endsection
