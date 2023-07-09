@extends('master')
@section('main-content')
@csrf
<div class="admin-data-content layout-top-spacing">
    <div class="row project-cards">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="row">
                                <div class="col-3">
                                    <select multiple="multiple" class="form-control" id="user_id" name="user_id" >
                                        @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->fullname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-3">
                                    <select multiple="multiple" class="form-control" id="monthPaySalary" name="monthPaySalary" >
                                        @foreach($monthPaySalarys as $monthPaySalary)
                                        <option value="{{ $monthPaySalary['substring(month,1,7)']}}">{{ $monthPaySalary['substring(month,1,7)'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-3">
                                    <select multiple="multiple" class="form-control" id="department_id" name="department_id" >
                                        @foreach($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-3">
                                    <div class="d-lg-flex justify-content-end">
                                            <button 
                                            style="height: 45.17px; margin-right: 0.25em;" 
                                            type="button" 
                                            class="btn btn-outline-primary mt-2 mt-lg-0"
                                            data-toggle="modal" 
                                            data-target="#exportModal" 
                                            onclick="onOpenModalImport()" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-share"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path><polyline points="16 6 12 2 8 6"></polyline><line x1="12" y1="2" x2="12" y2="15"></line></svg></button>
                                    </div>
                               
                               
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-content widget-content-area">
                                    <table id="pay_salaries" class="table style-2  table-hover">
                                        <thead>
                                            <tr>
                                                <th><input name="select_all" value="1" type="checkbox"></th>
                                                <th>ID</th>
                                                <th>Họ và tên</th>
                                                <th>Chức danh</th>
                                                <th>Phòng ban</th>
                                                <th>Mức lương cơ bản</th>
                                                <th>Ngày công </th>
                                                <th>Lương</th>
                                                <th>Phụ cấp</th>
                                                <th>Tổng cộng</th>
                                                <th>Tạm ứng</th>
                                                <th>Khen thưởng</th>
                                                <th>Xử phạt</th>
                                                <th>Lương thực nhận</th>
                                                <th>Trạng thái</th>
                                                <th>Ngày tính</th>
                                                <th>Chức năng</th>
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
<div class="modal fade" id="exportModal" tabindex="-1" role="dialog">
    <form 
        data-validate-parsley 
        id="formexportModal" 
        class="modal-dialog modal-sm" 
        role="document"
        action="{{ route('pay_salaries.exporting_pay_salaries_of_department') }}" 
        method="post"
    >
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xuất danh sách chấm công</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
        <div class="modal-body"> 
            <div class="form-row mt-2">
                <label class="form-label" for="mo-ta">Phòng ban</label>
                <select id="phong_ban" name="phong_ban" class="form-select">   
                    <option value=""></option>
                    @foreach($departments as $department)
                    <option value="{{$department->id }}">{{$department->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-row mt-2">
                <label class="form-label" for="mo-ta">Tháng (Mặc định là tháng hiện tại)</label>
                <select id="thang" name="thang" class="form-select">
                    <option value=""></option>
                    @foreach($dates as $date)
                    <option value="{{ $date['substring(month,1,7)']}}">{{ $date['substring(month,1,7)'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button id="btn-cancel" onclick="onCloseModalExport()" class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Huỷ bỏ</button>
            <button onclick="onSubmitModal()"  id="btnSubmitModal" type="button" class="btn btn-primary">Đồng ý</button>
        </div>
        </div>
    </form>
</div>
@section('page-css')
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/dt-global_style.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/custom_dt_custom.css') }}">
@endsection
@section('page-js')
<script src="{{ asset('plugins/table/datatable/datatables.js') }}"></script>
<script type="text/javascript">
    function onOpenModalImport(button) {
        $('#exportModal').on('shown.bs.modal', function () {
            $("#phong_ban").select2({
               placeholder: "Chọn phòng ban",
               allowClear: true,
               closeOnSelect : true,
                tags: false, 
                language: {
                    noResults: function (params) {
                    return "Không tìm thấy kết quả";
                    }
                },
            });
            $("#thang").select2({
               placeholder: "Chọn tháng",
               allowClear: true,
               closeOnSelect : true,
                tags: false, 
                language: {
                    noResults: function (params) {
                    return "Không tìm thấy kết quả";
                    }
                },
            });
        })
    }

    function onCloseModalExport(button) {
        $('#exportModal').on('hide.bs.modal', function () {
        })
    }

    function onSubmitModal() {
        if($('#formexportModal').parsley().validate()) {
            $('#formexportModal').submit()
        }
    }
</script>
<script type="text/javascript">
    $("#user_id").multipleSelect({
        placeholder: "Chọn tên nhân viên",
        filter: true,
        showClear: true,
        //placeholder: 'Chọn mã hợp đồng',
        position: 'bottom',
        minimumCountSelected: 1,
        filterPlaceholder: 'Tìm kiếm',
        openOnHover: false,
        formatSelectAll () {
            return 'Chọn tất cả'
        },
        formatAllSelected () {
            return 'Đã chọn tất cả'
        },
        formatCountSelected (count, total) {
            return 'Đã chọn ' + count + ' trên ' + total
        },
        formatNoMatchesFound () {
            return 'Không tìm thấy kết quả'
        },
        onClose: function () {
            var filteruser_id = JSON.stringify($("#user_id").val())
            var filtermonth = JSON.stringify($("#monthPaySalary").val())
            var filterdepartment_id = JSON.stringify($("#department_id").val())
           table.columns(4).search(filterdepartment_id).draw();
            table.columns(2).search(filteruser_id).draw();
            table.columns(15).search(filtermonth).draw();
            $("#btn-ap-dung").attr('disabled', true);
            $("th.select-checkbox").removeClass("selected");
        },

        onClear: function () {
            var filteruser_id = JSON.stringify($("#user_id").val())
            var filtermonth = JSON.stringify($("#monthPaySalary").val())
            var filterdepartment_id = JSON.stringify($("#department_id").val())
           table.columns(4).search(filterdepartment_id).draw();
            table.columns(2).search(filteruser_id).draw();
            table.columns(15).search(filtermonth).draw();
            $("#btn-ap-dung").attr('disabled', true);
            $("th.select-checkbox").removeClass("selected");
        }
    });
   
    $("#select-chon-hang-loat").select2({
       placeholder: "Chọn thao tác",
       allowClear: true,
       minimumResultsForSearch: -1
    });
</script>
<script type="text/javascript">
    $("#department_id").multipleSelect({
        placeholder: "Chọn tên phòng ban",
        filter: true,
        showClear: true,
        //placeholder: 'Chọn mã hợp đồng',
        position: 'bottom',
        minimumCountSelected: 1,
        filterPlaceholder: 'Tìm kiếm',
        openOnHover: false,
        formatSelectAll () {
            return 'Chọn tất cả'
        },
        formatAllSelected () {
            return 'Đã chọn tất cả'
        },
        formatCountSelected (count, total) {
            return 'Đã chọn ' + count + ' trên ' + total
        },
        formatNoMatchesFound () {
            return 'Không tìm thấy kết quả'
        },
        onClose: function () {
            var filteruser_id = JSON.stringify($("#user_id").val())
            var filtermonth = JSON.stringify($("#monthPaySalary").val())
            var filterdepartment_id = JSON.stringify($("#department_id").val())
           table.columns(4).search(filterdepartment_id).draw();
            table.columns(2).search(filteruser_id).draw();
            table.columns(15).search(filtermonth).draw();
            $("#btn-ap-dung").attr('disabled', true);
            $("th.select-checkbox").removeClass("selected");
        },

        onClear: function () {
            var filteruser_id = JSON.stringify($("#user_id").val())
            var filtermonth = JSON.stringify($("#monthPaySalary").val())
            var filterdepartment_id = JSON.stringify($("#department_id").val())
           table.columns(4).search(filterdepartment_id).draw();
            table.columns(2).search(filteruser_id).draw();
            table.columns(15).search(filtermonth).draw();
            $("#btn-ap-dung").attr('disabled', true);
            $("th.select-checkbox").removeClass("selected");
        }
    });
   
    $("#select-chon-hang-loat").select2({
       placeholder: "Chọn thao tác",
       allowClear: true,
       minimumResultsForSearch: -1
    });
</script>
<script type="text/javascript">
    $("#monthPaySalary").multipleSelect({
        placeholder: "Chọn tháng",
        filter: true,
        showClear: true,
        //placeholder: 'Chọn mã hợp đồng',
        position: 'bottom',
        minimumCountSelected: 1,
        filterPlaceholder: 'Tìm kiếm',
        openOnHover: false,
        formatSelectAll () {
            return 'Chọn tất cả'
        },
        formatAllSelected () {
            return 'Đã chọn tất cả'
        },
        formatCountSelected (count, total) {
            return 'Đã chọn ' + count + ' trên ' + total
        },
        formatNoMatchesFound () {
            return 'Không tìm thấy kết quả'
        },
        onClose: function () {
            var filteruser_id = JSON.stringify($("#user_id").val())
            var filtermonth = JSON.stringify($("#monthPaySalary").val())
            var filterdepartment_id = JSON.stringify($("#department_id").val())
           table.columns(4).search(filterdepartment_id).draw();
            table.columns(2).search(filteruser_id).draw();
            table.columns(15).search(filtermonth).draw();
            $("#btn-ap-dung").attr('disabled', true);
            $("th.select-checkbox").removeClass("selected");
        },

        onClear: function () {
            var filteruser_id = JSON.stringify($("#user_id").val())
            var filtermonth = JSON.stringify($("#monthPaySalary").val())
            var filterdepartment_id = JSON.stringify($("#department_id").val())
           table.columns(4).search(filterdepartment_id).draw();
            table.columns(2).search(filteruser_id).draw();
            table.columns(15).search(filtermonth).draw();
            $("#btn-ap-dung").attr('disabled', true);
            $("th.select-checkbox").removeClass("selected");
        }
    });
</script>
{{-- Load danh sách --}}
<script>
    function updateDataTableSelectAllCtrl(table) {
        var $table = table.table().node();
        var $chkbox_all = $('tbody input[type="checkbox"]', $table);
        var $chkbox_checked = $('tbody input[type="checkbox"]:checked', $table);
        var chkbox_select_all = $('thead input[name="select_all"]', $table).get(0);

        // If none of the checkboxes are checked
        if ($chkbox_checked.length === 0) {
            chkbox_select_all.checked = false;
            if ('indeterminate' in chkbox_select_all) {
                chkbox_select_all.indeterminate = false;
            }

            // If all of the checkboxes are checked
        } else if ($chkbox_checked.length === $chkbox_all.length) {
            chkbox_select_all.checked = true;
            if ('indeterminate' in chkbox_select_all) {
                chkbox_select_all.indeterminate = false;
            }

            // If some of the checkboxes are checked
        } else {
            chkbox_select_all.checked = true;
            if ('indeterminate' in chkbox_select_all) {
                chkbox_select_all.indeterminate = true;
            }
        }
    }
</script>
<script>
    var table;
        var rows_selected = [];
        resetTable()
        function resetTable () {
            table = $('#pay_salaries').DataTable({
                processing  : true,
                serverSide  : true,
                autoWidth   : false,
                pageLength  : 11,
                language: {
                    emptyTable: "Không tồn tại dữ liệu",
                    zeroRecords: "Không tìm thấy dữ liệu",
                    info: "Hiển thị từ _START_ đến _END_ trong _TOTAL_ mục",
                    infoEmpty: "0 bảng ghi được hiển thị",
                    infoFiltered: "",
                    select:{
                        rows:"",
                    },
                    lengthMenu: "Hiển thị _MENU_ mục",
                    processing: "<span class='text-primary'>Đang tải dữ liệu...</span>",
                    oPaginate: { 
                    "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', 
                    "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                },
                ajax: {
                    url: "{{route('pay_salaries.load_ajax_list_pay_salaries')}}",
                    type: 'get'
                },
                select: {
                    style:    'multi',
                    selector: 'td:first-child'
                },
                initComplete: function(settings, json) {
                    $('#pay_salaries tbody').on('click', 'input[type="checkbox"]', function(e) {
                    var $row = $(this).closest('tr');

                    // Get row data
                    var data = table.row($row).data();

                    // Get row ID
                    var rowId = data[0];

                    // Determine whether row ID is in the list of selected row IDs 
                    var index = $.inArray(rowId, rows_selected);

                    // If checkbox is checked and row ID is not in list of selected row IDs
                    if (this.checked && index === -1) {
                        rows_selected.push(rowId);

                        // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
                    } else if (!this.checked && index !== -1) {
                        rows_selected.splice(index, 1);
                    }

                    if (this.checked) {
                        $row.addClass('selected');
                    } else {
                        $row.removeClass('selected');
                    }

                    // Update state of "Select all" control
                    updateDataTableSelectAllCtrl(table);
                    if (table.rows('.selected').data().length == 0) {
                        $("#btn-ap-dung").attr('disabled', true)
                    } else {
                        $("#btn-ap-dung").attr('disabled', false)
                    }
                    
                    e.stopPropagation();
                    });

                // Handle click on table cells with checkboxes
                // $('#pay_salaries').on('click', 'tbody td, thead th:first-child', function(e) {
                //     $(this).parent().find('input[type="checkbox"]').trigger('click');
                // });

                // Handle click on "Select all" control
                $('thead input[name="select_all"]', table.table().container()).on('click', function(e) {
                    if (this.checked) {
                        $('#pay_salaries tbody input[type="checkbox"]:not(:checked)').trigger('click');
                    } else {
                        $('#pay_salaries tbody input[type="checkbox"]:checked').trigger('click');
                    }

                    // Prevent click event from propagating to parent
                    e.stopPropagation();
                });

                // Handle table draw event
                table.on('draw', function() {
                    // Update state of "Select all" control
                    updateDataTableSelectAllCtrl(table);
                });


                $("#pay_salaries").parent().addClass(' table-responsive');
                $("#pay_salaries").parent().parent().addClass(' d-inline');
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
                    { data: null, defaultContent: '', bSortable: false },
                    { name: 'id', defaultContent: '',data: 'id',visible: false,bSortable: true},
                    { name: 'user_id', defaultContent: '',data: 'user.fullname',bSortable: true},
                    { name: 'salary_name', defaultContent: '',data: 'user.role.name',bSortable: true},
                    { name: 'department_id', defaultContent: '',data: 'user.department.name',bSortable: true},
                    { name: 'salary.salary_payable', defaultContent: '',data: 'luongCoBan',bSortable: true},
                    { name: 'working_day', defaultContent: '',data: 'working_day',bSortable: true},
                    { name: 'salary', defaultContent: '',data: 'salary',bSortable: true},
                    { name: 'allowance', defaultContent: '',data: 'allowance',bSortable: true},
                    { name: 'total', defaultContent: '',data: 'total',bSortable: true},
                    { name: 'advance', defaultContent: '',data: 'advance',bSortable: true},
                    { name: 'sum_bonus', defaultContent: '',data: 'sum_bonus',bSortable: true},
                    { name: 'sum_discipline', defaultContent: '',data: 'sum_discipline',bSortable: true},
                    { name: 'actual_salary', defaultContent: '',data: 'actual_salary',bSortable: true},
                    { name: 'status', defaultContent: '',data: 'status',bSortable: true},
                    { name: 'month', defaultContent: '',data: 'month',bSortable: true},
                ],
                columnDefs: [
                    {
                        'targets': 0,
                        'searchable': false,
                        'orderable': false,
                        'width': '1%',
                        'className': 'dt-body-center',
                        'render': function(data, type, full, meta) {
                            return '<input type="checkbox">';
                        }
                    },
                    {
                        targets:11,
                        render: function(data,type, columns){
                            if(columns.sum_bonus == null)
                            {
                                return 0;
                            }
                            else
                            {
                                return columns.sum_bonus;
                            }
                        }
                    },
                    {
                        targets:12,
                        render: function(data,type, columns){
                            if(columns.sum_discipline == null)
                            {
                                return 0;
                            }
                            else
                            {
                                return columns.sum_discipline;
                            }
                        }
                    },
                    {
                        targets:16,
                        render: function(data,type, columns){
                            var urlUpdate =  "./bang-luong/cap-nhat/"+ columns.id;
                            var urlExport = "/bang-luong/exporting-paysalary/"+ columns.id;
                            var urlMail = "/bang-luong/send-mail/"+ columns.id;
                            return '<div class="d-flex order-actions">'
                            +'@if(Auth::user()->hasPermissionTo("Export bảng lương")) <a href="'+ urlExport +'" class="bs-tooltip" data-toggle="tooltip" data-placement="top" title=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-share"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path><polyline points="16 6 12 2 8 6"></polyline><line x1="12" y1="2" x2="12" y2="15"></line></svg></a> @endif'
                            +'<a href="'+ urlMail +'" class="bs-tooltip ml-3" data-toggle="tooltip" data-placement="top" title=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg></a>'
                            +'</div>' 
                        }
                    },

                ],
                ordering: true,
                order: [[ 1, 'asc' ]],
                "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                "<'table-responsive'tr>" +
                "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            });
        }

</script>
{{-- Delete --}}
<script type="text/javascript">
    function deleteRow(a) {
        var id = $(a).data("id");
        Swal.fire({
            title: 'Bạn có chắc muốn xóa?',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Hủy',
            confirmButtonText: 'Xóa'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "{{route('pay_salaries.destroy')}}",
                    type: 'post',
                    data: {id:id},
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
                        })
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
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
        })
    }
</script>
{{-- Xóa hàng loạt --}}
<script>
    $('#btn-ap-dung').click( function () {
            if($("#select-chon-hang-loat").val() == "") {
                 Swal.fire({
                    title: 'Bạn chưa chọn thao tác',
                    icon: 'error',
                    padding: '2em',
                    showConfirmButton: false,
                    timer: 1500,
                })
            } else {
                var data = table.rows('.selected').data();
                var formData = new FormData();
                data.map(function(item){ formData.append('id[]', item.id)});
                Swal.fire({
                    title: 'Bạn có chắc muốn xóa?',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'Hủy',
                    confirmButtonText: 'Xóa'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "{{route('pay_salaries.destroy')}}",
                            type: 'post',
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
                                })
                                setTimeout(function() {
                                    location.reload();
                                }, 1500);
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
                })
            }
        });
</script>
@endsection
@endsection