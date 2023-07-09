@extends('master')
@section('main-content')
@section('title', 'Danh sách khách hàng')
    <div class="admin-data-content layout-top-spacing">
        <div class="row project-cards">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-4">
                                <div class="row">
                                    <div class="col-3">
                                        <select multiple="multiple" class="form-control" id="code" name="code">
                                            @foreach ($maKh as $kh)
                                                <option value="{{ $kh->code }}">{{ $kh->code }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <select multiple="multiple" class="form-control" id="phone" name="phone">
                                            @foreach ($sdt as $dt)
                                                <option value="{{ $dt->phone }}">{{ $dt->phone }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <select multiple="multiple" class="form-control" id="email" name="email">
                                            @foreach ($email as $e)
                                                <option value="{{ $e->email }}">{{ $e->email }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <div class="d-lg-flex justify-content-end">
                                            <a href="{{ route('customer.create') }}"id="btn-them-moi"
                                                class="btn btn-primary mt-2 mt-lg-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-plus-square">
                                                    <rect x="3" y="3" width="18" height="18"
                                                        rx="2" ry="2"></rect>
                                                    <line x1="12" y1="8" x2="12" y2="16">
                                                    </line>
                                                    <line x1="8" y1="12" x2="16" y2="12">
                                                    </line>
                                                </svg>Thêm mới
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
                                        <button id="btn-ap-dung" class="btn btn-outline-primary form-control "
                                            type="button" disabled>Áp dụng</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="statbox widget box box-shadow">
                                    <div class="widget-content widget-content-area table-responsive">
                                        <table id="customer"
                                            class="table style-2 table-hover  table-striped table-bordered table-custom-text">
                                            <thead>
                                                <tr>
                                                    <th><input name="select_all" value="1" type="checkbox"></th>

                                                    <th>Mã khách hàng</th>
                                                    <th>Tên khách hàng</th>
                                                    <th>Số điện thoai</th>
                                                    <th>Email</th>
                                                    <th>Địa chỉ</th>
                                                    <th>Trạng thái</th>
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
            <div class="send-email">
                <!-- Modal -->
                <div class="modal fade" id="sendEmail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Gửi tin nhắn</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <input type="hidden" id="id" name="id">
                                    <label for="title">Tiêu đề</label>
                                    <input type="text" id="title" name="title"
                                        class="comment-box-input input-title">
                                </div>
                                <div class="form-group">
                                    <label for="#content-email">Nội dung</label>
                                    <textarea class="comment-email js-new-comment-input is-focused" contenteditable="true" name="message"
                                        id="content-email"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-cancel" data-dismiss="modal">Hủy
                                    bỏ</button>
                                <button type="button" class="btn btn-primary" id="send-email">Gửi</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/dt-global_style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/custom_dt_custom.css') }}">
    <!-- buttons -->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
@endsection
@section('page-js')
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
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
            table = $('#customer').DataTable({
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
                    url: "{{ route('customer.load_ajax_list_customer') }}",
                    type: 'get'
                },
                select: {
                    style: 'multi',
                    selector: 'td:first-child'
                },
                initComplete: function(settings, json) {
                    $('#customer tbody').on('click', 'input[type="checkbox"]', function(e) {
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


                    // Handle click on "Select all" control
                    $('thead input[name="select_all"]', table.table().container()).on('click', function(e) {
                        if (this.checked) {
                            $('#customer tbody input[type="checkbox"]:not(:checked)').trigger('click');
                        } else {
                            $('#customer tbody input[type="checkbox"]:checked').trigger('click');
                        }

                        // Prevent click event from propagating to parent
                        e.stopPropagation();
                    });

                    // Handle table draw event
                    table.on('draw', function() {
                        // Update state of "Select all" control
                        updateDataTableSelectAllCtrl(table);
                    });


                    $("#customer").parent().addClass(' table-responsive');
                    $("#customer").parent().parent().addClass(' d-inline');
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
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                columns: [{
                        data: null,
                        defaultContent: '',
                        bSortable: false
                    },
                    {
                        name: 'code',
                        defaultContent: '',
                        data: 'code',
                        bSortable: true
                    },
                    {
                        name: 'name',
                        defaultContent: '',
                        data: 'name',
                        bSortable: true
                    },
                    {
                        name: 'phone',
                        defaultContent: '',
                        data: 'phone',
                        bSortable: true
                    },
                    {
                        name: 'email',
                        defaultContent: '',
                        data: 'email',
                        bSortable: true
                    },
                    {
                        name: 'address',
                        defaultContent: '',
                        data: 'address',
                        bSortable: true
                    },
                ],
                columnDefs: [{
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
                        targets: 6,
                        render: function(data, type, columns) {
                            if (columns.status == 'active') {
                                return `<span class="badge badge-primary">Tồn tại</span>`
                            }
                            return `<span class="badge badge-danger">Không tồn tại</span>`
                        }
                    },
                    {
                        targets: 7,
                        render: function(data, type, columns) {
                            var url = "./khach-hang/cap-nhat/" + columns.id;
                            return '<div class="order-actions">' +
                                '<a href="' + url +
                                '" class="bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 p-1 br-6 mb-1"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a>' +
                                '<a href="javascript:void(0);" onclick="deleteRow(this)" data-id="' +
                                columns.id +
                                '" class="bs-tooltip ml-3" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash p-1 br-6 mb-1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></a>' +
                                '<a data-toggle="tooltip" data-placement="right" title="Gửi email" onclick="sendEmail(this)" data-id="' +
                                columns.id +
                                '" href="javascript:;" class="btn-email ml-4"><i class="bx bx-message-dots" ></i></a>'
                            '</div>'
                        }
                    }
                ],
                order: [
                    [2, 'asc']
                ],
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
                        url: "{{ route('customer.destroy') }}",
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
    {{-- Xóa hàng loạt --}}
    <script>
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
                            url: "{{ route('customer.destroy') }}",
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
    </script>
    <script type="text/javascript">
        $("#code").multipleSelect({
            placeholder: 'Chọn mã khách hàng',
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
                var filterMaKh = JSON.stringify($("#code").val());
                table.columns(1).search(filterMaKh).draw();
                $("#btn-ap-dung").attr('disabled', true);
                $("th.select-checkbox").removeClass("selected");
            },
            onClear: function() {
                var filterMaKh = JSON.stringify($("#code").val())
                table.columns(1).search(filterMaKh).draw();
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
        $("#phone").multipleSelect({
            placeholder: 'Chọn số điện thoại',
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
                var filterPhone = JSON.stringify($("#phone").val())
                table.columns(3).search(filterPhone).draw();
                $("#btn-ap-dung").attr('disabled', true);
                $("th.select-checkbox").removeClass("selected");
            },
            onClear: function() {
                var filterPhone = JSON.stringify($("#phone").val())
                table.columns(3).search(filterPhone).draw();
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
        $("#email").multipleSelect({
            placeholder: 'Chọn email',
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
                var filterEmail = JSON.stringify($("#email").val())
                table.columns(4).search(filterEmail).draw();
                $("#btn-ap-dung").attr('disabled', true);
                $("th.select-checkbox").removeClass("selected");
            },
            onClear: function() {
                var filterEmail = JSON.stringify($("#email").val())
                table.columns(4).search(filterEmail).draw();
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
        function sendEmail(a) {
            var id = $(a).data("id");
            var modal = $("#sendEmail");
            modal.modal('show')
            modal.on('shown.bs.modal', function(e) {
                $(e.currentTarget).find('input[name="id"]').val(id);
            });
            modal.on('hidden.bs.modal', function() {});
        };
    </script>
    <script>
        $('#send-email').click(function() {
            var formData = new FormData();
            formData.append('content', $('#content-email').val())
            formData.append('customerId', $('#id').val())
            formData.append('title', $('#title').val())
            $.ajax({
                url: "{{ route('customer.send_email') }}",
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
            })
        })
    </script>
    {{-- Toggle Modal Sendemail --}}
    <script>
        $('.send-email .close').click(function() {
            $('#sendEmail').modal('hide')
        })
        $('.btn-cancel').click(function() {
            $('#sendEmail').modal('hide')
        })
    </script>
@endsection
