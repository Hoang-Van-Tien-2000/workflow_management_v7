@extends('master')
@section('main-content')
@csrf
@include('modules.user.change_pass')
<div class="admin-data-content layout-top-spacing">
    <div class="row project-cards">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="row">
                                <div class="col-3">
                                    <select multiple="multiple" class="form-control" id="fullname" name="fullname" >
                                        @foreach($user_fullname as $fullname)
                                        <option value="{{ $fullname }}">{{ $fullname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-3">
                                    <select multiple="multiple" class="form-control" id="phone" name="phone" >
                                        @foreach($user_phone as $phone)
                                        <option value="{{ $phone }}">{{ $phone }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-3">
                                    <select multiple="multiple" class="form-control" id="role_id" name="role_id" >
                                        @foreach($role as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- <div class="col-3">
                                    <div class="d-lg-flex justify-content-end">
                                        <a href="{{ route('user.create') }}" id="btn-them-moi" class="btn btn-primary mt-2 mt-lg-1">
                                            <i class="bx bxs-plus-square"></i>Thêm mới
                                        </a>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-content widget-content-area">
                                    <table id="user" class="table style-2  table-hover">
                                        <thead>
                                            <tr>
                                                <th><input name="select_all" value="1" type="checkbox"></th>
                                                <th>ID</th>
                                                <th>Mã nhân viên</th>
                                                <th>Họ tên</th>
                                                <th>Địa chỉ</th>
                                                <th>Số điện thoại</th>
                                                <th>Chức vụ</th>
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
@section('page-css')
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/dt-global_style.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/custom_dt_custom.css') }}">
@endsection
@section('page-js')
<script src="{{ asset('plugins/table/datatable/datatables.js') }}"></script>
<script type="text/javascript">
    $("#fullname").multipleSelect({
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
            var filterFullname = JSON.stringify($("#fullname").val())
            var filterPhone = JSON.stringify($("#phone").val())
            var filterRole = JSON.stringify($("#role_id").val())
            table.columns(3).search(filterFullname).draw();
            table.columns(5).search(filterPhone).draw();
            table.columns(6).search(filterRole).draw();
            $("#btn-ap-dung").attr('disabled', true);
            $("th.select-checkbox").removeClass("selected");

            $.ajax({
                url: "{{route('user.load_filter_user')}}",
                type: 'get',
                data: {
                    fullname: filterFullname,
                    phone: filterPhone,
                    role_id: filterRole
                },
                dataType: 'json',
            }).done(function(res) {
                if(res['role_id'].length>0)
                {
                    $("#role_id option").remove();
                    $('#role_id').multipleSelect("refresh");
                    res['role_id'].forEach(element => {
                        $('#role_id').append($('<option>', {
                            value: element["id"],
                            text: element["name"]
                        }));
                    });
                    $('#role_id').multipleSelect("refresh");
                }

                if(res['phone'].length>0)
                {
                    $("#phone option").remove();
                    $('#phone').multipleSelect("refresh");
                    res['phone'].forEach(element => {
                        $('#phone').append($('<option>', {
                            value: element,
                            text: element
                        }));
                    });
                    $('#phone').multipleSelect("refresh");
                }
            });
        },
        onClear: function () {
            var filterFullname = JSON.stringify($("#fullname").val())
            var filterPhone = JSON.stringify($("#phone").val())
            var filterRole = JSON.stringify($("#role_id").val())
            table.columns(3).search(filterFullname).draw();
            table.columns(5).search(filterPhone).draw();
            table.columns(6).search(filterRole).draw();
            $("#btn-ap-dung").attr('disabled', true);
            $("th.select-checkbox").removeClass("selected");

            $.ajax({
                url: "{{route('user.load_filter_user')}}",
                type: 'get',
                data: {
                    fullname: filterFullname,
                    phone: filterPhone,
                    role_id: filterRole
                },
                dataType: 'json',
            }).done(function(res) {
                if(res['role_id'].length>0)
                {
                    $("#role_id option").remove();
                    $('#role_id').multipleSelect("refresh");
                    res['role_id'].forEach(element => {
                        $('#role_id').append($('<option>', {
                            value: element["id"],
                            text: element["name"]
                        }));
                    });
                    $('#role_id').multipleSelect("refresh");
                }

                if(res['phone'].length>0)
                {
                    $("#phone option").remove();
                    $('#phone').multipleSelect("refresh");
                    res['phone'].forEach(element => {
                        $('#phone').append($('<option>', {
                            value: element,
                            text: element
                        }));
                    });
                    $('#phone').multipleSelect("refresh");
                }
            });
        }
    });
    $("#phone").multipleSelect({
        placeholder: "Chọn số điện thoại",
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
            var filterFullname = JSON.stringify($("#fullname").val())
            var filterPhone = JSON.stringify($("#phone").val())
            var filterRole = JSON.stringify($("#role_id").val())
            table.columns(3).search(filterFullname).draw();
            table.columns(5).search(filterPhone).draw();
            table.columns(6).search(filterRole).draw();
            $("#btn-ap-dung").attr('disabled', true);
            $("th.select-checkbox").removeClass("selected");

            $.ajax({
                url: "{{route('user.load_filter_user')}}",
                type: 'get',
                data: {
                    fullname: filterFullname,
                    phone: filterPhone,
                    role_id: filterRole
                },
                dataType: 'json',
            }).done(function(res) {
                if(res['role_id'].length>0)
                {
                    $("#role_id option").remove();
                    $('#role_id').multipleSelect("refresh");
                    res['role_id'].forEach(element => {
                        $('#role_id').append($('<option>', {
                            value: element["id"],
                            text: element["name"]
                        }));
                    });
                    $('#role_id').multipleSelect("refresh");
                }

                if(res['fullname'].length>0)
                {
                    $("#fullname option").remove();
                    $('#fullname').multipleSelect("refresh");
                    res['fullname'].forEach(element => {
                        $('#fullname').append($('<option>', {
                            value: element,
                            text: element
                        }));
                    });
                    $('#fullname').multipleSelect("refresh");
                }
            });
        },
        onClear: function () {
            var filterFullname = JSON.stringify($("#fullname").val())
            var filterPhone = JSON.stringify($("#phone").val())
            var filterRole = JSON.stringify($("#role_id").val())
            table.columns(3).search(filterFullname).draw();
            table.columns(5).search(filterPhone).draw();
            table.columns(6).search(filterRole).draw();
            $("#btn-ap-dung").attr('disabled', true);
            $("th.select-checkbox").removeClass("selected");

            $.ajax({
                url: "{{route('user.load_filter_user')}}",
                type: 'get',
                data: {
                    fullname: filterFullname,
                    phone: filterPhone,
                    role_id: filterRole
                },
                dataType: 'json',
            }).done(function(res) {
                if(res['role_id'].length>0)
                {
                    $("#role_id option").remove();
                    $('#role_id').multipleSelect("refresh");
                    res['role_id'].forEach(element => {
                        $('#role_id').append($('<option>', {
                            value: element["id"],
                            text: element["name"]
                        }));
                    });
                    $('#role_id').multipleSelect("refresh");
                }

                if(res['fullname'].length>0)
                {
                    $("#fullname option").remove();
                    $('#fullname').multipleSelect("refresh");
                    res['fullname'].forEach(element => {
                        $('#fullname').append($('<option>', {
                            value: element,
                            text: element
                        }));
                    });
                    $('#fullname').multipleSelect("refresh");
                }
            });
        }
    });
    $("#role_id").multipleSelect({
        placeholder: "Chọn chức vụ",
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
            var filterFullname = JSON.stringify($("#fullname").val())
            var filterPhone = JSON.stringify($("#phone").val())
            var filterRole = JSON.stringify($("#role_id").val())
            table.columns(3).search(filterFullname).draw();
            table.columns(5).search(filterPhone).draw();
            table.columns(6).search(filterRole).draw();
            $("#btn-ap-dung").attr('disabled', true);
            $("th.select-checkbox").removeClass("selected");

            $.ajax({
                url: "{{route('user.load_filter_user')}}",
                type: 'get',
                data: {
                    fullname: filterFullname,
                    phone: filterPhone,
                    role_id: filterRole
                },
                dataType: 'json',
            }).done(function(res) {
                if(res['phone'].length>0)
                {
                    $("#phone option").remove();
                    $('#phone').multipleSelect("refresh");
                    res['phone'].forEach(element => {
                        $('#phone').append($('<option>', {
                            value: element,
                            text: element
                        }));
                    });
                    $('#phone').multipleSelect("refresh");
                }

                if(res['fullname'].length>0)
                {
                    $("#fullname option").remove();
                    $('#fullname').multipleSelect("refresh");
                    res['fullname'].forEach(element => {
                        $('#fullname').append($('<option>', {
                            value: element,
                            text: element
                        }));
                    });
                    $('#fullname').multipleSelect("refresh");
                }
            });
        },
        onClear: function () {
            var filterFullname = JSON.stringify($("#fullname").val())
            var filterPhone = JSON.stringify($("#phone").val())
            var filterRole = JSON.stringify($("#role_id").val())
            table.columns(3).search(filterFullname).draw();
            table.columns(5).search(filterPhone).draw();
            table.columns(6).search(filterRole).draw();
            $("#btn-ap-dung").attr('disabled', true);
            $("th.select-checkbox").removeClass("selected");

            $.ajax({
                url: "{{route('user.load_filter_user')}}",
                type: 'get',
                data: {
                    fullname: filterFullname,
                    phone: filterPhone,
                    role_id: filterRole
                },
                dataType: 'json',
            }).done(function(res) {
                if(res['phone'].length>0)
                {
                    $("#phone option").remove();
                    $('#phone').multipleSelect("refresh");
                    res['phone'].forEach(element => {
                        $('#phone').append($('<option>', {
                            value: element,
                            text: element
                        }));
                    });
                    $('#phone').multipleSelect("refresh");
                }

                if(res['fullname'].length>0)
                {
                    $("#fullname option").remove();
                    $('#fullname').multipleSelect("refresh");
                    res['fullname'].forEach(element => {
                        $('#fullname').append($('<option>', {
                            value: element,
                            text: element
                        }));
                    });
                    $('#fullname').multipleSelect("refresh");
                }
            });
        }
    });
    $("#select-chon-hang-loat").select2({
       placeholder: "Chọn thao tác",
       allowClear: true,
       minimumResultsForSearch: -1
    });
</script>
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
            table = $('#user').DataTable({
                processing  : true,
                serverSide  : true,
                autoWidth   : false,
                pageLength  : 10,
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
                    url: "{{route('user.load_ajax_list_user')}}",
                    type: 'get'
                },
                select: {
                    style:    'multi',
                    selector: 'td:first-child'
                },
                initComplete: function(settings, json) {
                    $('#user tbody').on('click', 'input[type="checkbox"]', function(e) {
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
                // $('#user').on('click', 'tbody td, thead th:first-child', function(e) {
                //     $(this).parent().find('input[type="checkbox"]').trigger('click');
                // });

                // Handle click on "Select all" control
                $('thead input[name="select_all"]', table.table().container()).on('click', function(e) {
                    if (this.checked) {
                        $('#user tbody input[type="checkbox"]:not(:checked)').trigger('click');
                    } else {
                        $('#user tbody input[type="checkbox"]:checked').trigger('click');
                    }

                    // Prevent click event from propagating to parent
                    e.stopPropagation();
                });

                // Handle table draw event
                table.on('draw', function() {
                    // Update state of "Select all" control
                    updateDataTableSelectAllCtrl(table);
                });


                $("#user").parent().addClass(' table-responsive');
                $("#user").parent().parent().addClass(' d-inline');
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
                    { name: 'code', defaultContent: '',data: 'code',bSortable: true},
                    { name: 'fullname', defaultContent: '',data: 'fullname',bSortable: true},
                    { name: 'address', defaultContent: '',data: 'address',bSortable: true},
                    { name: 'phone', defaultContent: '',data: 'phone',bSortable: true},
                    { name: 'role_id', defaultContent: '',data: 'role.name',bSortable: true},
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
                        targets:7,
                        render: function(data,type, columns){
                            var urlUpdate =  "./nguoi-dung/cap-nhat/"+ columns.id;
                            return '<div class="d-flex order-actions">'
                            +'@if(Auth::user()->hasPermissionTo("Cập nhật nhân viên")) <a href="'+ urlUpdate +'" class="bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 p-1 br-6 mb-1"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a> @endif'
                            +'@if(Auth::user()->hasPermissionTo("Cập nhật nhân viên")) <a class="bs-tooltip ml-3" data-toggle="tooltip" data-placement="top" title="" onclick="changePass(this)" data-id="' +
                                columns.id +
                                '" href="javascript:;" data-original-title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-key"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"></path></svg></a> @endif'
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
<script type="text/javascript">
        function changePass(a) {
            var id = $(a).data("id");
            var modal = $("#update-modal");
            modal.modal('show')
            modal.on('shown.bs.modal', function(e) {
                $(e.currentTarget).find('input[name="id"]').val(id);
            });
            modal.on('hidden.bs.modal', function() {});
        };
    </script>
{{-- Delete --}}
<script type="text/javascript">
    function deleteRow(a) {
        var id = $(a).data("id");
        console.log(id);
        $.ajax({
            url:"{{route('checkRole')}}",
            type:'GET',

        }).done(function (result)
        {
            if(result)
            {
            Swal.fire({
            title: 'Bạn có chắc muốn xóa?',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Hủy',
            confirmButtonText: 'Xóa'
              }).then((result) => {
            if (result.value) {
                    $.ajax({
                                url: "{{route('user.destroy')}}",
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
            else{
                swal.fire({
                title:  "Bạn không được sử dụng quyền này!",
                icon:"error",
                type: 'error',
                padding: '2em',
                showConfirmButton: false,
                timer: 1500,
                 })
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

            $.ajax({
            url:"{{route('checkRole')}}",
            type:'GET',

        }).done(function (result)
        {
            if(result)
            {
                Swal.fire({
                title: 'Bạn có chắc muốn xóa?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Hủy',
                confirmButtonText: 'Xóa'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{route('user.destroy')}}",
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
                else{
                    swal.fire({
                    title:  "Bạn không được sử dụng quyền này!",
                    icon:"error",
                    type: 'error',
                    padding: '2em',
                    showConfirmButton: false,
                    timer: 1500,
                    })
                }
            })
            }
        })
           
        }
    });
</script>
@endsection
@endsection