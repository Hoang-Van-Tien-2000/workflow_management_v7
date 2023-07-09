@extends('master')
@section('main-content')
@include('modules.salary.create-modal')
@include('modules.salary.update-modal')
<div class="admin-data-content layout-top-spacing">
    <div class="row project-cards">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="row">
                                <div class="col-3">
                                    <select multiple="multiple" class="form-control" id="name" name="name" >
                                        @foreach($salary as $sa)
                                        <option value="{{ $sa->id }}">{{ $sa->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-9">
                                    <div class="d-lg-flex justify-content-end">
                                        <a id="btn-them-moi" class="btn btn-primary mt-2 mt-lg-1">
                                            <i class="bx bxs-plus-square"></i>Thêm mới
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-4">
                            <div class="row">
                                <div class="col-3">
                                    <select id="select-chon-hang-loat" class="form-control">
                                        <option value=""></option>
                                        <option value="delete"> Xoá</option>
                                    </select>
                                </div>
                                <div class="col-3">
                                    <button id="btn-ap-dung" class="btn btn-outline-primary form-control " type="button" disabled>Áp dụng</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-content widget-content-area">
                                    <table id="salary" class="table style-2  table-hover">
                                        <thead>
                                            <tr>
                                                <th><input name="select_all" value="1" type="checkbox"></th>
                                                <th>ID</th>
                                                <th>Tên loại lương</th>
                                                <th>Mức lương cơ bản</th>
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
    function resetTable() {
        table = $('#salary').DataTable({
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
                url: "{{route('salary.load_ajax_list_salary')}}",
                type: 'get'
            },
            select: {
                style: 'multi',
                selector: 'td:first-child'
            },
            initComplete: function(settings, json) {
                $('#salary tbody').on('click', 'input[type="checkbox"]', function(e) {
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
                // $('#salary').on('click', 'tbody td, thead th:first-child', function(e) {
                //     $(this).parent().find('input[type="checkbox"]').trigger('click');
                // });

                // Handle click on "Select all" control
                $('thead input[name="select_all"]', table.table().container()).on('click', function(e) {
                    if (this.checked) {
                        $('#salary tbody input[type="checkbox"]:not(:checked)').trigger('click');
                    } else {
                        $('#salary tbody input[type="checkbox"]:checked').trigger('click');
                    }

                    // Prevent click event from propagating to parent
                    e.stopPropagation();
                });

                // Handle table draw event
                table.on('draw', function() {
                    // Update state of "Select all" control
                    updateDataTableSelectAllCtrl(table);
                });


                $("#salary").parent().addClass(' table-responsive');
                $("#salary").parent().parent().addClass(' d-inline');
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
                { name: 'name', defaultContent: '',data: 'name',bSortable: true},
                { name: 'salary_payable', defaultContent: '',data: 'salary_payable',bSortable: true},
            ],
            columnDefs:[ 
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
                    targets:4, 
                    render: function(data,type, columns){
                        return '<div class="d-flex order-actions">'
                            +'<a href="javascript:void(0);" onclick="updateRow(this)"  data-toggle="modal" data-id="'+columns.id+'" data-name="'+columns.name+'"  data-salary_payable="'+columns.salary_payable+'" class="bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 p-1 br-6 mb-1"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a>'
                            +'<a href="javascript:void(0);" onclick="deleteRow(this)" data-id="'+columns.id+'" class="bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash p-1 br-6 mb-1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></a>'
                            +'</div>'                    
                    }
                }
            ],
            order: [[2, 'asc' ]],
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
            "<'table-responsive'tr>" +
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
        });
    }
</script>
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
                                    url: "{{route('salary.destroy')}}",
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
                                    url: "{{route('salary.destroy')}}",
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
<script type="text/javascript">
    $("#name").multipleSelect({
        placeholder: "Chọn tên lương",
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
            var filterName = JSON.stringify($("#name").val())
            table.columns(2).search(filterName).draw();
            $("#btn-ap-dung").attr('disabled', true);
            $("th.select-checkbox").removeClass("selected");
        },

        onClear: function () {
            var filterName = JSON.stringify($("#name").val())
            table.columns(2).search(filterName).draw();
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
    $(document).ready(function() {

        var modal = $("#create-modal");

        $('#btn-them-moi').click(function() {
            modal.modal('show')
        });

        // Modal shown
        modal.on('shown.bs.modal', function() {
            document.getElementById("name_create").focus();
            document.getElementById("name_create").value = "";
            document.getElementById("salary_payable").value = "";
        });

        // Modal hidden
        modal.on('hidden.bs.modal', function() {
            $('#frm-them-moi').parsley().reset();

        });
 
        $('#btn-save-modal').click(function() {
            if($('#frm-them-moi').parsley().validate()) {
               $.ajax({
                    url: "{{ route('salary.store') }}",
                    type: 'POST',
                    data: $('form.create_form').serialize(),
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
                            icon: res.status,
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
        $('#btn-update-modal').click(function(e) {
            if($('#frm-cap-nhat').parsley().validate()) {
                $.ajax({
                    url: "{{ route('salary.update') }}",
                    type: 'POST',
                    data: $('form.update_form').serialize(),
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
                            icon: res.status,
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
    });
</script>
<script type="text/javascript">
    function updateRow(a) {
        var id = $(a).data("id");
        var name = $(a).data("name");
        var salary_payable = $(a).data("salary_payable");
        console.log(name)
        var modal = $("#update-modal");
        modal.modal('show')
        modal.on('shown.bs.modal', function(e) {
             $(e.currentTarget).find('input[name="id"]').val(id);
             $(e.currentTarget).find('input[name="name_update"]').val(name);
             $(e.currentTarget).find('input[name="salary_payable"]').val(salary_payable);
        });
        modal.on('hidden.bs.modal', function() {
            $('#frm-cap-nhat').parsley().reset();

        });
    };
</script>
@endsection
@endsection