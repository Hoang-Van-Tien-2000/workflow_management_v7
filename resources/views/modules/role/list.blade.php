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
                                    <select multiple="multiple" class="form-control" id="role_id" name="role_id" >
                                        @foreach($roles_name as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if(Auth::user()->hasPermissionTo("Thêm chức vụ"))
                                <div class="col-9">
                                    <div class="d-lg-flex justify-content-end">
                                        <a href="{{ route('role.create') }}" id="btn-them-moi" class="btn btn-primary mt-2 mt-lg-1">
                                            <i class="bx bxs-plus-square"></i>Thêm mới
                                        </a>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        @if(Auth::user()->hasPermissionTo("Xóa chức vụ"))
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
                        @endif
                        <div class="col-12">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-content widget-content-area">
                                    <table id="role" class="table table-striped table-bordered table-custom-text">
                                        <thead>
                                            <tr>
                                                <th><input name="select_all" value="1" type="checkbox"></th>
                                                <th>ID</th>
                                                <th style="width: 15%" >Tên phân quyền</th>
                                                <th style="width: 70%" >Danh sách quyền</th>
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
        $("#role_id").multipleSelect({
        placeholder: 'Chọn tên chức vụ',
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
        onClose:function(){
            var filterRole = JSON.stringify($("#role_id").val())
            table.columns(1).search(filterRole).draw();
            $("#btn-ap-dung").attr('disabled', true);
            $("th.select-checkbox").removeClass("selected");
        },
        onClear:function(){
            var filterRole = JSON.stringify($("#role_id").val())
            table.columns(1).search(filterRole).draw();
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
    {{-- Load --}}
    <script>
        var table;
        resetTable()

        function resetTable() {
            table = $('#role').DataTable({
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
                    "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                },
                ajax: {
                    url: "{{ route('role.load_ajax_list_role') }}",
                    type: 'get'
                },
                select: {
                    style: 'multi',
                    selector: 'td:first-child'
                },
                initComplete: function(settings, json) {
                    table.on('click', 'tbody tr', function() {
                        $(this).toggleClass('selected');
                        if (table.rows('.selected').data().length == 0) {
                            $("#btn-ap-dung").attr('disabled', true)
                        } else {
                            $("#btn-ap-dung").attr('disabled', false)
                        }
                        if ($("th.select-checkbox").hasClass("selected")) {
                            $("th.select-checkbox").removeClass("selected");
                        }
                        if (json.aaData.length == table.rows('.selected').data().length) {
                            $("th.select-checkbox").addClass("selected");
                        }
                    });

                    table.on("click", "th.select-checkbox", function() {
                        if ($("th.select-checkbox").hasClass("selected")) {
                            $("tbody tr").removeClass('selected');
                            $("th.select-checkbox").removeClass("selected");
                        } else {
                            $("tbody tr").addClass('selected');
                            $("th.select-checkbox").addClass("selected");
                        }
                        if (table.rows('.selected').data().length == 0) {
                            $("#btn-ap-dung").attr('disabled', true)
                        } else {
                            $("#btn-ap-dung").attr('disabled', false)
                        }
                    })

                    $("#role").parent().addClass(' table-responsive');
                    $("#role").parent().parent().addClass(' d-inline');

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
                        data: null,
                        defaultContent: '',
                        bSortable: false
                    },
                    {
                        name: 'id',
                        defaultContent: '',
                        data: 'id',
                        visible: false,
                        bSortable: true
                    },

                    {
                        name: 'name',
                        defaultContent: '',
                        data: 'name',
                        bSortable: false
                    },
                    {
                        name: 'permission',
                        defaultContent: '',
                        data: 'permission[].name',
                        bSortable: false
                    },

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
                        targets: 3,
                        render: function(data, type, columns) {
                            var text = "";
                            columns.permission.forEach(permission);

                            function permission(item, index) {
                                console.log(item.name);
                                text += `<span class="badge bg-primary">${item.name}</span> &nbsp`
                            }
                            return text;

                        }
                    },
                    {
                        targets: 4,
                        render: function(data, type, columns) {
                            var url = "./phan-quyen/cap-nhat/" + columns.id;
                            return '<div class="d-flex order-actions">'
                            +'@if(Auth::user()->hasPermissionTo("Cập nhật chức vụ")) <a href="'+ url +'" class="bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 p-1 br-6 mb-1"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a> @endif'
                            +'@if(Auth::user()->hasPermissionTo("Xóa chức vụ")) <a href="javascript:void(0);" onclick="deleteRow(this)" data-id="'+columns.id+'" class="bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash p-1 br-6 mb-1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></a> @endif'
                            +'</div>' 
                            
                        }
                    },
                ],
                // ordering: true,
                order: [
                    [1, 'asc']
                ],
                order: [[ 1, 'asc' ]],
                "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                "<'table-responsive'tr>" +
                "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            });
        };
    </script>
    {{-- Xóa tìm kiếm mặc định --}}
    <script>
        const box = document.getElementById('role_filter');
        box.remove();
    </script>
    {{-- Thêm-Sửa --}}
    {{-- <script type="text/javascript">
        $(document).ready(function() {

            var modal = $("#create-modal");

            $('#btn-them-moi').click(function() {
                modal.modal('show')
            });

            // Modal shown
            modal.on('shown.bs.modal', function() {
                document.getElementById("name").focus();
                document.getElementById("name").value = "";

                console.log('Modal shown')
            });

            // Modal hidden
            modal.on('hidden.bs.modal', function() {
                $('#frm-them-moi').parsley().reset();

            });

            $('#btn-save-modal').click(function() {
                if ($('#frm-them-moi').parsley().validate()) {
                    $.ajax({
                        url: "{{ route('role.store') }}",
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

        });
    </script> --}}
    {{-- Load modal --}}
    {{-- <script type="text/javascript">
    function updateRow(a) {
        var id = $(a).data("id");
        var modal = $("#update-modal");
            $.ajax({
                url: "{{ route('role.edit') }}",
                type: 'GET',
                data: {id:id},
                dataType: 'json',                    
            }).done(function(res) {
                $('#role_id').val(3)
                $('#role_id').trigger('change');
                // $("#role_id option").remove();
                // $('#role_id').multipleSelect("refresh");
                console.log(res)
                // res['name'].forEach(element => {
                //     $('#ten_khach_hang').append($('<option>', {
                //         value: element,
                //         text: element
                //     }));
                // });
                // $('#ten_khach_hang').multipleSelect("refresh");
            });
        modal.modal('show')
       
        modal.on('shown.bs.modal', function(e) {
             $(e.currentTarget).find('input[name="id"]').val(id);

        });  
        modal.on('hidden.bs.modal', function() {
            $('#frm-cap-nhat').parsley().reset();
        
        });
        $('#btn-update-modal').click(function(e) {
    
            var role= ( $("#role_id").val());
                var formData = new FormData();
                    // $("input[name='id']").map(function(){ formData.append('id', this.value)}).get();
                    formData.append('role_id',role );
                    formData.append('id',id );

            $.ajax({
                url: "{{ route('role.update') }}",
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
        })
    }; 
</script> --}}
    {{-- Delete --}}
    <script type="text/javascript">
        function deleteRow(a) {
            var id = $(a).data("id");
            console.log(id);
            Swal.fire({
                title: 'Bạn có chắc muốn xóa?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Hủy',
                confirmButtonText: 'Xóa'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ route('role.destroy') }}",
                        type: 'post',
                        data: {
                            id: id
                        },
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
    {{-- Xóa hàng hoạt --}}
    <!-- <script>
        $('#btn-ap-dung').click(function() {
            if ($("#select-chon-hang-loat").val() == "") {
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
                data.map(function(item) {
                    formData.append('id[]', item.id)
                });
                Swal.fire({
                    title: 'Bạn có chắc muốn xóa?',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'Hủy',
                    confirmButtonText: 'Xóa'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "{{ route('role.destroy') }}",
                            type: 'post',
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
    </script> -->
    <script type="text/javascript">
        $("#btn-loc-du-lieu").click(function(e) {
            var filterFullname = JSON.stringify($("#fullname").val())
            var filterRole = JSON.stringify($("#name").val())
            table.columns(1).search(filterFullname).draw();
            table.columns(3).search(filterRole).draw();
            $("#btn-ap-dung").attr('disabled', true);
            $("th.select-checkbox").removeClass("selected");
        })
    </script>
@endsection
@endsection