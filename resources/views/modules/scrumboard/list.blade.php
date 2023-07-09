@extends('master')
@section('main-content')
@section('title', 'Danh sách công việc')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
<input type="hidden" id="work_id" value="{{ $id }}">
<div class="admin-data-content layout-top-spacing">
    <div class="d-lg-flex justify-content-end">
        <div class="action-btn mb-5">
            <a href="{{ route('task.trash', ['id' => $id]) }}" class="btn btn-danger"><i class="bx bx-trash"></i>Thùng
                rác</a>
        </div>
        @if (Auth::user()->hasPermissionTo('Thêm công việc'))
            <div class="action-btn mb-5">
                <p id="demo"></p>
                <button id="add-list" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2">
                        </rect>
                        <line x1="12" y1="8" x2="12" y2="16"></line>
                        <line x1="8" y1="12" x2="16" y2="12"></line>
                    </svg>Thêm danh sách</button>
            </div>
        @endif
    </div>
    @php
        $task_id = isset($_GET['task']) ? $_GET['task'] : '';
    @endphp
    <div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-labelledby="addTaskModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="compose-box">
                        <div class="compose-content" id="addTaskModalTitle">
                            <h5 class="add-task-title">Thêm mới</h5>
                            <h5 class="edit-task-title">Edit Task</h5>

                            <div class="addTaskAccordion" id="add_task_accordion">
                                <div class="card task-text-progress">
                                    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo"
                                        data-parent="#add_task_accordion">
                                        <div class="card-body">
                                            <form action="javascript:void(0);">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="task-title mb-4">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-edit-3">
                                                                <path d="M12 20h9"></path>
                                                                <path
                                                                    d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z">
                                                                </path>
                                                            </svg>
                                                            <input id="s-task" type="text"
                                                                placeholder="Tên công việc" class="form-control"
                                                                name="task">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="task-badge">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-star">
                                                                <polygon
                                                                    points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                                                </polygon>
                                                            </svg>
                                                            <textarea id="s-text" placeholder="Chi tiết công việc" class="form-control" name="taskText"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <span
                                                    style="padding-left:35px;color:#e7515a;font-size:13px;font-weight;700"
                                                    id="error-addtask"></span>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-closeAdd" data-dismiss="modal"><svg xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg> Đóng</button>
                    <button data-btnfn="addTask" class="btn add-tsk">Thêm mới</button>
                    <button data-btnfn="editTask" class="btn edit-tsk" style="display: none;">Lưu</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addListModal" tabindex="-1" role="dialog" aria-labelledby="addListModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="compose-box">
                        <div class="compose-content" id="addListModalTitle">
                            <h5 class="add-list-title">Thêm danh sách</h5>
                            <h5 class="edit-list-title">Chỉnh sửa danh sách</h5>
                            <form action="javascript:void(0);">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="list-title">

                                            <input id="s-list-name" type="text" placeholder="Tên danh sách"
                                                class="form-control" name="task">
                                        </div>
                                        <span style="color:#e7515a;font-size:13px;font-weight;700"
                                            id="error-list"></span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-x" data-dismiss="modal"><svg xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg> Đóng</button>
                    <button class="btn add-list">Thêm danh sách</button>
                    <button class="btn edit-list" style="display: none;">Lưu</button>
                </div>
            </div>
        </div>
    </div>

    @include('modules.scrumboard.delete_modal')

    <div class="row scrumboard" id="cancel-row">
        <div class="col-lg-12 layout-spacing">

            <div class="task-list-section">
                <div id="detail_modal"></div>

                @foreach ($scrum as $level)
                    <div data-section="{{ $level->id }}" class="task-list-container" data-connect="sorting">
                        <div class="connect-sorting">
                            <div class="task-container-header">
                                <h6 class="s-heading" data-listtitle="{{ $level->name }}">{{ $level->name }}
                                </h6>
                                <div class="dropdown">
                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-1"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-more-horizontal">
                                            <circle cx="12" cy="12" r="1"></circle>
                                            <circle cx="19" cy="12" r="1"></circle>
                                            <circle cx="5" cy="12" r="1"></circle>
                                        </svg>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right"
                                        aria-labelledby="dropdownMenuLink-1">
                                        @if (Auth::user()->hasPermissionTo('Cập nhật công việc'))
                                            <a class="dropdown-item list-edit" href="javascript:void(0);">Chỉnh
                                                sửa</a>
                                        @endif
                                        @if (Auth::user()->hasPermissionTo('Xóa công việc'))
                                            <a class="dropdown-item list-delete" href="javascript:void(0);">Xóa dách
                                                sách</a>
                                            <a class="dropdown-item list-clear-all" href="javascript:void(0);">Xóa tất
                                                cả
                                                Công việc</a>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="connect-sorting-content ui-sortable" data-sortable="true">
                                @foreach ($level->listTask as $task)
                                    <div data-draggable="true" class="card img-task ui-sortable-handle"
                                        style="">
                                        <div class="card-body" id="taskbody-{{ $task->id }}"
                                            @if (!empty($task->priority)) style="background-color:{{ $task->priority->code }}; color:white" @endif>
                                            <div class="customers">
                                                <ul id="list-assign-{{ $task->id }}">
                                                    @foreach ($task->assign as $assign)
                                                        <li style="display: inline-block;margin: 5px -10px"
                                                            id="image-assign-{{ $task->id }}-{{ $assign->id }}"
                                                            idmember="62a47f6d8eefda1d0d27fc21"
                                                            title="{{ $assign->user->fullname }}">
                                                            <img class="rounded-circle"
                                                                src="{{ asset($assign->user->avatar) }}"
                                                                style="width:25px;height:25px" alt="">
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="task-header" data-toggle="modal" data-target="#exampleModal">
                                                <div class="">
                                                    <h4 class="" data-taskid="{{ $task->id }}"
                                                        data-tasktitle="{{ $task->title }}"
                                                        id="task-{{ $task->id }}"
                                                        @if (!empty($task->priority)) style="color:white" @endif>
                                                        {{ $task->title }}</h4>
                                                </div>
                                            </div>

                                            <div class="task-body">

                                                <div class="task-bottom">
                                                    <div class="tb-section-1">
                                                        <span data-taskdate="08 Aug 2020"><svg
                                                                xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-calendar">
                                                                <rect x="3" y="4" width="18"
                                                                    height="18" rx="2" ry="2">
                                                                </rect>
                                                                <line x1="16" y1="2" x2="16"
                                                                    y2="6"></line>
                                                                <line x1="8" y1="2" x2="8"
                                                                    y2="6"></line>
                                                                <line x1="3" y1="10" x2="21"
                                                                    y2="10"></line>
                                                            </svg>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $task->created_at)->format('d/m/Y H:i:s') }}</span>
                                                    </div>
                                                    <div class="tb-section-2">
                                                        @if (Auth::user()->hasPermissionTo('Xóa công việc') || $task->user_id == Auth::user()->id)
                                                            <button class="feather feather-trash-2 s-task-delete"><i
                                                                    class='bx bx-trash'
                                                                    id="tasktra-{{ $task->id }}"
                                                                    @if (!empty($task->priority)) style="color:white" @endif></i></button>
                                                        @endif

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="add-s-task">
                                <a class="addTask"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-plus-circle">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="12" y1="8" x2="12" y2="16"></line>
                                        <line x1="8" y1="12" x2="16" y2="12"></line>
                                    </svg> Thêm mới</a>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script>
    $(document).ready(function() {
        if ("{{ $task_id }}" != "") {
            var task_id = "{{ $task_id }}";
            var work_id = "{{ $id }}";
            var params = {
                "task_id": task_id,
                "work_id": work_id
            };
            var ser_data = jQuery.param(params);
            $.ajax({
                url: `{{ route('task.detail_task') }}`,
                type: 'GET',
                data: ser_data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
            }).done(function(res) {
                console.log(res);
                if (res.status == 'success') {
                    $_updateNameDetail();
                    $_updateDeription();
                    sendMessage();
                    var $option = "";
                    var $priority = "";
                    var $fileupload = "";
                    var $imgupload = "";

                    res.task.attachment.forEach(Fileupload);
                    var $checkactive = "";
                    if (res.task.status == 0) {
                        $checkactive = `<div class="btn-group mb-4 mr-2 w-100" role="group" id="checkactive">
                                                    <button id="activeComplete" type="button" class="btn btn-primary dropdown-toggle"
                                                        ><i class='bx bx-check'></i>Hoàn thành</button>
                                                    <div class="dropdown-menu menu-date" aria-labelledby="btnDate"
                                                        style="will-change: transform;">
                                                        
                                                    </div>
                                                </div>`
                    } else {
                        $checkactive = `<div class="btn-group mb-4 mr-2 w-100" role="group" id="checkactive">
                                                    <button id="unActiveComplete" type="button" class="btn btn-outline-primary dropdown-toggle"
                                                        ><i class='bx bx-x'></i></i>Hủy hoàn thành</button>
                                                    <div class="dropdown-menu menu-date" aria-labelledby="btnDate"
                                                        style="will-change: transform;">
                                                        
                                                    </div>
                                                </div>`
                    }

                    function Fileupload(item) {
                        if (item.type == "file") {
                            $imgupload += `
                                    <div class="item-upload" id="file-${item.id}">
                                        <div class="image-preview" style="text-align:center; font-size:50px;color:#009688;">
                                            <a download="${item.name}" href="{{ asset('assets/images/task/${item.url}') }}"><i class='bx bxs-file' style="color:#009688;"></i> </a>   
                                        </div>
                                        <div class="content-preview">
                                            <p class="name-file">${item.name}</p>
                                            <div class="des-preview" data-idfile="${item.id}" data-filecommemt="[${item.name}]({{ asset('assets/images/task/${item.url}') }})">
                                                <p class="date">${item.created_at}</p>
                                                <a href="#" class="button-link file-image">Bình luận</a>
                                                <a href="#" class="button-link delete-file-image">Xóa</a>
                                            </div>
                                            
                                        </div>
                                    </div>
                                            `
                        } else {
                            $imgupload += `
                                    <div class="item-upload" id="file-${item.id}">
                                        <div class="image-preview">
                                            <a href="{{ asset('assets/images/task/${item.url}') }}"><img src="{{ asset('assets/images/task/${item.url}') }}" alt=""/></a> 
                                        </div>
                                        <div class="content-preview">
                                            <p class="name-file">${item.name}</p>
                                            <div class="des-preview" data-idfile="${item.id}" data-filecommemt="[${item.name}]({{ asset('assets/images/task/${item.url}') }})">
                                                <p class="date">${item.created_at}</p>
                                                <a href="#" class="button-link file-image">Bình luận</a>
                                                <a href="" class="button-link delete-file-image">Xóa</a>
                                            </div>
                                            
                                        </div>
                                    </div>`
                        }

                    }

                    if (!isEmpty(res.task.priority)) {
                        $color = `style="background-color:${res.task.priority.code}"`;
                    } else {
                        $color = `style="background-color:#009688"`;

                    }
                    res.Priority.forEach(Priority);

                    function Priority(item) {
                        if (res.task.priority_id == item.id) {
                            $priority += `
                                            <div data-priority="0" style="  display: inline-block;">
                                            <button class="active js-theme-color-item theme__button priority-color"  style="background-color:${item.code}">
                                                <i class="bx bx-check"></i>
                                            </button>
                                            </div>
                                            `
                        } else {
                            $priority += `
                                            <div data-priority="${item.id}" style="display: inline-block;">
                                            <button class="js-theme-color-item theme__button priority-color" id="priority-${item.id}" style="background-color:${item.code}">
                                                <i class="bx bx-check"></i>
                                            </button>
                                            </div>`
                        }

                    }
                    res.userWork.forEach(Opption);

                    function Opption(item) {
                        $option +=
                            `<option value="${item.user.id}">${item.user.fullname} (${item.user.code})</option>`
                    }
                    var $html3 = "";

                    res.task.assign.forEach(Assign);

                    function Assign(item) {
                        $html3 += `<li class="item js-member-item selected" id="assign-${item.id}"><a class="name js-select-member"
                                                idmember="62a47f6d8eefda1d0d27fc21"
                                                title="${item.user.fullname}" autocompletetext="${item.user.code}"><span
                                                    class="member js-member" style="background-color:transparent;"><img class="member-avatar" style="border-radius:50%"
                                                        height="30" width="30"
                                                        src="{{ asset('') }}${item.user.avatar}"
                                                        title="${item.user.fullname} (${item.user.code})"><span
                                                        id="62a47f6d8eefda1d0d27fc21-avatar"></span><span
                                                        class="member-gold-badge" title="This member has Trello Gold."
                                                        aria-label="This member has Trello Gold."></span></span><span
                                                    class="full-name" name="${item.user.fullname} (${item.user.code})"
                                                    aria-hidden="aria-hidden">
                                                    ${item.user.fullname} <span class="username">(${item.user.code})</span></span><span
                                                    class="icon-sm icon-check checked-icon"
                                                    aria-label="This member was added to card"></span><span
                                                    class="icon-sm icon-forward light option js-open-option" data-assignuser="${item.user.id}"><button class="deleteAssign" style="background-color:white;border:none;color:black"><i class='bx bx-x'></i></button></span></a>
                                            </li>`
                    }
                    var $html2 = "";
                    res.comment.forEach(myFunction);

                    function myFunction(item) {
                        var User_id = "{{ Auth::user()->id }}";
                        var $htmlComment = "";
                        var $file = "";
                        if (item.status == 1 && item.user_id == User_id) {
                            $htmlComment = ` <input class="comment-box-input1 js-new-comment-input is-focused" aria-label="Write a comment"
                                                        placeholder="Nhập bình luận" id="comment_id-${item.id}" value="${item.content}" disabled name="message" style="width:100%;font-size:13px">
                                                        <div class="container-button1" id="btn-${item.id}" style="display:none">
                                                            <div class="comment-controls u-clearfix" data-sendcommentid= ${item.id}>
                                                                <button
                                                                    class="nch-button btn btn-primary btn-message"
                                                                    type="button">Gửi</button>
                                                            </div>
                                                        </div>
                                                        <div class="comment-footer">
                                                            <span class="action-icons">
                                                                <a href="#" class="edit-comment " data-editcommentid=${item.id}><i
                                                                        class="bx bx-edit-alt editComment"></i></a>
                                                                <a href="#" data-commentid= ${item.id} data-abc="true"><i
                                                                        class="bx bx-trash delete-comment "></i></a>
                                                            </span>
                                                        </div>`
                        } else {
                            $htmlComment =
                                ` <p class="m-b-5 m-t-10 des" > ${item.content} </p>`
                        }
                        if (item.file != null && item.file.type == "image") {
                            $file = `<div class="image-upload">
                                                        <img src="{{ asset('assets/images/task/${item.file.url}') }}" alt=""/>    
                                                    </div>`
                        }
                        $html2 += `<div class="d-flex comment-row" id="comment-delete-${item.id}">
                                                <div class="p-2">
                                                    <span class="round"><img
                                                            src="{{ asset('${item.user.avatar}') }}" alt="user"
                                                            style="width:50px;height:50px" /></span>
                                                </div>
                                                <div class="comment-text w-100">
                                                    <div class="title">
                                                        <h5>${item.user.fullname}</h5>
                                                    <span class="date">${item.created_at}</span>
                                                    </div>
                                                    <div class="comment-user">
                                                        <input type="hidden" name="user_id" id="username_input" value="1">
                                                        <input type="hidden" name="task_id" id="task_input" value="1">
                                                        <textarea class="comment-edit js-new-comment-input is-focused" contenteditable="true" name="message" id="messages_input1">${item.content}</textarea>
                                                    <div class="container-button active-button">
                                                            <div class="comment-controls u-clearfix">
                                                                <button class="nch-button btn btn-primary" type="button" id="message_send1">Gửi</button>
                                                                <div class="icon-close"><i class='bx bx-x'></i></div>
                                                            </div>
                                                            <div class="comment-box-options"><a class="comment-box-options-item js-comment-add-attachment" href="#" title="Add an attachment…">
                                                                    <span class="icon-sm icon-attachment"><i class="bx bx-link-alt"></i></span></a><a class="comment-box-options-item js-comment-mention-member" href="#" title="Mention a member…"><span class="icon-sm icon-mention">@</span></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    ${$htmlComment}
                                                    ${$file}
                                                    
                                                </div>
                                            </div>`;
                    }
                    $hoanThanh = "";
                    if (res.task.status == 1) {
                        $hoanThanh =
                            `<button class="btn-cover btn btn-primary"><i class='bx bx-check'></i>Hoàn thành </button>`;
                    }
                    $html = `<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog task">
                                        <div class="modal-content content">
                                            <div class="modal-header custom-header">
                                                <div class="cover w-100" id="taskdetail-${res.task.id}" ${$color}>
                                                    <button type="button" class="btn-close float-right close-modal" data-dismiss="modal"
                                                        aria-label="Close">X</button>
                                                    <div id="activeCompleteHeader">
                                                    ${$hoanThanh}
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-body body-task">
                                                <div class="row">

                                                    <div class="col-md-9">
                                                        <div class="title-task mb-2">
                                                            <div class="icon-task">
                                                                <i class="bx bxs-credit-card"></i>
                                                            </div>
                                                            <textarea class="mod-card-back-title js-card-detail-title-input" dir="auto" data-autosize="true"
                                                                style="overflow: hidden; overflow-wrap: break-word; height: 32.8px" id="taskNameDetail">${res.task.title}</textarea>
                                                        </div>
                                                        <p class="in-list">Thuộc danh sách ${res.task.level.name}</p>
                                                        <div class="title-task mb-2">
                                                            <div class="icon-task">
                                                                <i class="bx bx-align-left"></i>
                                                            </div>
                                                            <h4>Mô tả</h4>
                                                        </div>
                                                        <div class="description mb-2">
                                                            <textarea placeholder="Thêm mô tả ở đây..."
                                                                class="field field-autosave js-description-draft description card-description" data-autosize="true"
                                                                style="overflow: hidden; overflow-wrap: break-word; resize: none; height: 108px" id="descriptionDetail">${res.task.detail?res.task.detail.description:''}</textarea>
                                                        </div>
                                                        <div class="title-task mb-2">
                                                            <div class="icon-task">
                                                                <i class="bx bx-link-alt"></i>
                                                            </div>
                                                            <h4>Tệp đính kèm</h4>
                                                        </div>
                                                        <div class="preview-upload">
                                                            ${$imgupload}                                                                 
                                                            </div>
                                                        <div class="upload-file mb-2">
                                                            <form action="" class="form" method="post" id="form">
                                                                <input type="file" name="Image" id="image" multiple="" class="custom-file-container__custom-file__custom-file-input" onchange="imageSelect()">
                                                                <span class="custom-file-container__custom-file__custom-file-control">Chọn tệp
                                                                    <span class="custom-file-container__custom-file__custom-file-control__button" onclick="document.getElementById('image').click()"> Tải lên </span></span>
                                                            </form>
                                                            <div id="img-preview">
                                                                
                                                            </div>
                                                            
                                                            <button class="btn btn-primary mb-2 btn__save" id="btn-save-attra"><i class='bx bxs-save icon__save'></i>Lưu</button>
                                                        </div>
                                                        <div class="comment-list">
                                                            <div class="title-task mb-2">
                                                                <div class="icon-task">
                                                                    <i class="bx bx-box"></i>
                                                                </div>
                                                                <h4>Bình luận</h4>
                                                            </div>
                                                            <a class="subtle button js-show-details" href="#">Hiện thị</a>
                                                        </div>
                                                        <div class="content-comment">
                                                            <div class="avatar-user">
                                                                <img src="{{ asset(Auth::user()->avatar) }}" alt=""  style="width:50px;height:50px"/>
                                                            </div>
                                                            <form>
                                                                <div class="comment-frame">
                                                                    <div class="comment-box">
                                                                        <form id="message_form">
                                                                            <input type="hidden" name="user_id" id="username_input"
                                                                                value="{{ Auth::user()->id }}">
                                                                                <input type="hidden" name="task_id" id="task_input"
                                                                                value="${res.task.id}">
                                                                            <input class="comment-box-input js-new-comment-input is-focused" aria-label="Write a comment"
                                                                                placeholder="Nhập bình luận" dir="auto" data-autosize="true"
                                                                                style="overflow: hidden; overflow-wrap: break-word; height: 20px;" name="message" id="messages_input">
                                                                            <div class="container-button" id="showbtn">
                                                                                <div class="comment-controls u-clearfix">
                                                                                    <button
                                                                                        class="nch-button btn btn-primary"
                                                                                        type="button" id="message_send">Gửi</button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="row clear-both recent-comment">
                                                            <div class="col-md-12 p-0">
                                                                <div class="card1">
                                                                        <div class="comment-widgets m-b-20">
                                                                            ${$html2}
                                                                    </div>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 add-to-card">
                                                            <div class="btn-group mb-4 mr-2 w-100" role="group">
                                                                
                                                                <button id="btnOutline" type="button" class="btn btn-outline-primary dropdown-toggle"
                                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                                                        class='bx bxs-user-plus'></i>Thành viên</button>
                                                                <div class="dropdown-menu dropdown-card" aria-labelledby="btnOutline"
                                                                    style="will-change: transform;">
                                                                    <div class="title-member">
                                                                        <h4>Thành viên</h4>
                                                                    </div>
                                                                    <button type="button" class="btn-close float-right" data-dismiss="modal"
                                                                        aria-label="Close">X</button>
                                                                    <div class="invite-team">
                                                                        <select multiple="multiple" class="form-control select-option" id="fullname" name="fullname" >
                                                                            ${$option}
                                                                        </select>
                                                                        <button type="button" class="btn btn-primary" id="btn-save-assign"><i class='bx bx-save icon__save'></i>Lưu</button>
                                                                        </div>
                                                                    <div class="pop-over-section js-board-members">
                                                                        <h4>Thành viên</h4>
                                                                        <div class="js-loading hide">
                                                                            <p class="empty" style="padding: 24px 6px">Loading…</p>
                                                                        </div>
                                                                        <div class="js-no-results hide">
                                                                            <p class="empty" style="padding: 24px 6px">Không có dữ liệu
                                                                            </p>
                                                                        </div>
                                                                        <ul class="pop-over-member-list checkable u-clearfix js-mem-list" style="height: 110px;overflow: auto;"> 
                                                                            ${$html3}
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="btn-group mb-4 mr-2 w-100" role="group">
                                                                <button id="btnLabel" type="button" class="btn btn-outline-primary dropdown-toggle"
                                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class='bx bx-purchase-tag-alt'></i>Nhãn</button>
                                                                <div class="dropdown-menu menu-label" aria-labelledby="btnLabel"
                                                                    style="will-change: transform;">
                                                                    <div class="title-member">
                                                                        <h4>Nhãn</h4>
                                                                    </div>
                                                                    <button type="button" class="btn-close float-right" data-dismiss="modal"
                                                                        aria-label="Close">X</button>
                                                                        <div class="theme__colors js-theme-colors" id="optionPriority">
                                                                            <div id="remove-prio" style="width:100%;">
                                                                            ${$priority}
                                                                            </div>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                            <div class="btn-group mb-4 mr-2 w-100" role="group">
                                                                <button id="btnDate" type="button" class="btn btn-outline-primary dropdown-toggle"
                                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class='bx bxs-calendar'></i>Ngày</button>
                                                                <div class="dropdown-menu menu-date" aria-labelledby="btnDate"
                                                                    style="will-change: transform;">
                                                                    <div class="title-member">
                                                                        <h4>Ngày</h4>
                                                                    </div>
                                                                    <button type="button" class="btn-close float-right" data-dismiss="modal"
                                                                        aria-label="Close">X</button>
                                                                    <div class="date-container">
                                                                    <div class="item">
                                                                        <label class="form-label"  for="start-date">Ngày bắt đầu</label>
                                                                            <input class="form-control" id="timeStart" type="datetime-local" value="${res.task.timeStart}"/>
                                                                        </div>
                                                                        <div class="item">
                                                                            <label class="form-label"  for="end-date">Ngày kết thúc</label>
                                                                                <input class="form-control" id="timeOut" type="datetime-local" value="${res.task.timeOut}"/>
                                                                        </div>
                                                                            <div class="button-date">
                                                                                <button class="btn btn-primary mb-2 btn-save-date" id="saveDeadline"><i class='bx bxs-save icon__save'></i>Lưu</button>
                                                                                <button class="btn btn-light mb-2"><i class='bx bx-x'></i>Hủy bỏ</button>    
                                                                            </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            ${$checkactive}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                            `
                    console.log($html);
                    $("#detail_modal").append($html);
                    sendMessage(res.task.id);
                    $_updateNameDetail();
                    saveAttra(res.task.id);
                    editComment();
                    deleteAssign(task_id, work_id)
                    activeComplete(task_id)
                    unActiveComplete(task_id)
                    saveDeadline(task_id)
                    checkpriority(task_id)
                    sendEditComment()
                    $(".file-image").click(function() {
                        var getParentElement = $(this).parents().attr('data-filecommemt');
                        $("#messages_input").val(getParentElement);
                        $("#messages_input").focus();
                    })
                    $('.delete-file-image').off('click').on('click', function(event) {
                        event.preventDefault();
                        Swal.fire({
                            title: 'Bạn có chắc xóa tệp đính kèm ?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Confirm'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                var check = $(this);
                                var getParentElement = $(this).parents().attr(
                                    'data-idfile');
                                var formData = new FormData();
                                formData.append('id', getParentElement);
                                $.ajax({
                                    url: "{{ route('task.delete_file') }}",
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
                                            $("#file-" +
                                                    getParentElement)
                                                .remove();
                                            $("#comment-delete-" + res
                                                .id).remove();

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
                        })

                    })


                    saveAssign(task_id, work_id)
                    $_deleteComent();
                    $_updateDeription();
                    $("#fullname").multipleSelect({
                        placeholder: "Chọn thành viên",
                        filter: true,
                        showClear: true,
                        //placeholder: 'Chọn mã hợp đồng',
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
                    });
                    $('#exampleModal').modal('show');
                    $('#exampleModal').on('hidden.bs.modal', function(e) {
                        $('#detail_modal').html("");
                    })
                    $(".comment-box-input").click(function() {
                        $(".container-button").toggleClass("active-button");
                    })

                    $(".js-show-details").click(function() {
                        let x = $(this).text();
                        if (x == "Hiển thị") {
                            $(this).text("Ẩn bình luận");
                            $(".recent-comment").show().slideDown();
                        } else {
                            $(this).text("Hiển thị");
                            $(".recent-comment").hide().slideUp();
                        }
                    })
                    $('.theme__colors button').click(function() {
                        $('.menu-label').addClass('open-label')
                    })
                    $('.menu-label .btn-close').click(function() {
                        $('.menu-label').removeClass('open-label')
                    })
                    $('.btn-save-date').click(function() {
                        $('.menu-date').addClass('open-date');
                    })
                    $('.menu-date .btn-close').click(function() {
                        $('.menu-date').removeClass('open-date');
                    })
                    $('.ms-parent').on('click', function() {
                        $('.dropdown-menu.dropdown-card').addClass(
                            'open-ms');
                    })
                    $('.btn-close').on('click', function() {
                        $('.dropdown-card').removeClass('open-ms');
                    })
                    $(".icon-close").click(function() {
                        $(".comment-user").removeClass("active");
                        $(".des").show();
                        $(".comment-footer").show();
                    })
                    $(".close-modal").click(function() {
                        $("#exampleModal").hide();
                        $(".modal-backdrop").hide();
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
    function selectAssign() {
        $("#fullname").multipleSelect({
            placeholder: "Chọn thành viên",
            filter: true,
            showClear: true,
            //placeholder: 'Chọn mã hợp đồng',
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
        });
    }
</script>
{{-- add task --}}
<script>
    var level_old = [];
    var index_old = -1;

    function $_taskSortable() {
        $('[data-sortable="true"]').sortable({
            connectWith: '.connect-sorting-content',
            items: ".card",
            cursor: 'move',
            placeholder: "ui-state-highlight",
            refreshPosition: true,
            start: function(event, ui) {
                index_old = ui.item.index();
            },
            update: function(event, ui) {},
            stop: function(event, ui) {
                getParentElement = ui.item.parents('[data-connect="sorting"]').attr('data-section');
                var $_taskProgressValue = $('.check').attr('data-taskTitle');
                taskid = ui.item.find('h4').attr('data-taskid');
                var level = $(this).parents('[data-connect="sorting"]').attr('data-section');
                var formData = new FormData();
                formData.append('task_id', taskid);
                formData.append('level_old', level);
                formData.append('level_new', getParentElement);
                formData.append('index_value', ui.item.index());
                formData.append('index_old', index_old);
                $.ajax({
                    url: "{{ route('task.move') }}",
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                }).done(function(res) {
                    if (res.status == 'success') {} else {
                        Swal.fire({
                            title: res.message,
                            icon: 'error',
                            showCancelButton: false,
                            showConfirmButton: false,
                            position: 'center',
                            padding: '2em',
                            timer: 1500,
                        })
                        location.reload();
                    }
                });

            },
        });

    }

    function addTask() {
        $('.addTask').on('click', function(event) {
            event.preventDefault();
            getParentElement = $(this).parents('[data-connect="sorting"]').attr('data-section');
            $("#error-addtask").html("");
            $('.edit-task-title').hide();
            $('.add-task-title').show();
            $('[data-btnfn="addTask"]').show();
            $('[data-btnfn="editTask"]').hide();
            // $('.addTaskAccordion .collapse').collapse('hide');
            $('#addTaskModal').modal('show');
            $_taskAdd(getParentElement);
        });
        $(".btn-x").click(function() {
            $('#addListModal').modal('hide');
        })


    }

    function $_taskAdd(getParent) {
        $('[data-btnfn="addTask"]').off('click').on('click', function(event) {
            getAddBtnClass = $(this).attr('class').split(' ')[1];
            var $_getParent = getParent;
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth()); //January is 0!
            var yyyy = today.getFullYear();
            var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov",
                "Dec"
            ];
            today = dd + ' ' + monthNames[mm] + ', ' + yyyy;
            var work_id = "{{ $id }}";
            var $_task = document.getElementById('s-task').value;
            var $_taskText = document.getElementById('s-text').value;
            if ($_task == "" || $_taskText == "") {
                $("#error-addtask").html("Vui lòng nhập đầy đủ thông tin");
            } else {
                var formData = new FormData();
                formData.append('level_id', getParent);
                formData.append('title', $_task);
                formData.append('content', $_taskText);
                $.ajax({
                    url: "{{ route('task.store') }}",
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
                            var $_taskProgress = $('.range-count-number').attr(
                                'data-rangeCountNumber');
                            $html =
                                `<div data-draggable="true" class="card img-task ui-sortable-handle"
                                                data-toggle="modal" data-target="#exampleModal" style="">` +
                                '<div class="card-body" id="taskbody-' + res.task_id +
                                '">&nbsp' +
                                '<div class="task-header">' +
                                '<div class="">' +
                                '<h4 class="" id="task-' + res.task_id + '" data-taskid="' + res
                                .task_id + '" data-taskTitle="' +
                                $_task + '">' + $_task +
                                '</h4>' +
                                '</div>' +
                                '</div>' +
                                '<div class="task-body">' +
                                '<div class="task-bottom">' +
                                '<div class="tb-section-1">' +
                                '<span data-taskDate="' + res.task.created_at +
                                '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg> ' +
                                res.task.created_at + '</span>' +
                                '</div>' +
                                '<div class="tb-section-2">' +
                                `<button class="feather feather-trash-2 s-task-delete" onclick="myFunction()"><i
                                                                        class='bx bx-trash' id="tasktra-${res.task_id}"></i></button>` +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>';
                            $("[data-section='" + $_getParent + "'] .connect-sorting-content")
                                .append($html);
                            $_taskDetail()
                            $_updateNameDetail();
                            $_updateDeription();
                            $_taskDelete();
                            $('#addTaskModal').modal('hide');
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
        $(".btn-closeAdd").click(function() {
            $('#addTaskModal').modal('hide');
        })
    }
</script>

{{-- xóa task --}}
<script>
    function $_taskDelete() {
        $('.card .s-task-delete').off('click').on('click', function(event) {
            event.preventDefault();
            var task_id = $(this).parents('.card').find('h4').attr('data-taskid');
            get_card_parent = $(this).parents('.card')
            Swal.fire({
                title: 'Bạn có chắc xóa công việc không ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Xác nhận',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    var formData = new FormData();
                    formData.append('id', task_id);
                    $.ajax({
                        url: "{{ route('task.destroy') }}",
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
                                get_card_parent.remove();
                                $('#deleteConformation').modal('hide');
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
            })
        })
    }
</script>
{{-- clear danh sách --}}
<script>
    function $_clearList() {
        $('.list-clear-all').off('click').on('click', function(event) {
            event.preventDefault();
            var check = $(this);
            getParentElement = $(this).parents('[data-connect="sorting"]').attr('data-section');
            Swal.fire({
                title: 'Bạn có chắc xóa công việc ?',
                text: "Sau khi chấp nhận công việc sẽ không còn tồn tại.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Xác nhận',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    var formData = new FormData();
                    formData.append('level_id', getParentElement);
                    $.ajax({
                        url: "{{ route('task.clear_all') }}",
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
                                check.parents('[data-connect="sorting"]').find(
                                    '.connect-sorting-content .card').remove();
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
            })

        })
    }
</script>
{{-- Sửa danh sách --}}
<script>
    function $_editList() {
        $('.list-edit').off('click').on('click', function(event) {
            event.preventDefault();
            var $_outerThis = $(this);
            $('.add-list').hide();
            $('.edit-list').show();
            $('.add-list-title').hide();
            $('.edit-list-title').show();
            var getParentElement = $(this).parents('[data-connect="sorting"]').attr('data-section');
            var $_listTitle = $_outerThis.parents('[data-connect="sorting"]').find('.s-heading').attr(
                'data-listTitle');
            $('#s-list-name').val($_listTitle);
            $('.edit-list').off('click').on('click', function(event) {
                var $_innerThis = $(this);
                var $_getListTitle = document.getElementById('s-list-name').value;
                var formData = new FormData();
                formData.append('level_id', getParentElement);
                formData.append('name', $_getListTitle);
                $.ajax({
                    url: "{{ route('task.edit_list') }}",
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                }).done(function(res) {
                    if (res.status == 'success') {
                        var $_editedListTitle = $_outerThis.parents('[data-connect="sorting"]')
                            .find(
                                '.s-heading').html($_getListTitle);
                        var $_editedListTitleDataAttr = $_outerThis.parents(
                            '[data-connect="sorting"]').find(
                            '.s-heading').attr('data-listTitle', $_getListTitle);
                        $('#addListModal').modal('hide');
                        $('#s-list-name').val('');
                    }
                });
            })
            $('#addListModal').modal('show');
            $('#addListModal').on('hidden.bs.modal', function(e) {
                $('#s-list-name').val('');
            })
        })
        $(".btn-x").click(function() {
            $('#addListModal').modal('hide');
        })

    }
</script>
{{-- Xóa danh sách --}}
<script>
    function $_deleteList() {

        $('.list-delete').off('click').on('click', function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Bạn có chắc xóa danh sách ?',
                text: "Sau khi chấp nhận danh sách sẽ không còn tồn tại.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Xác nhận',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    var check = $(this);
                    var getParentElement = $(this).parents('[data-connect="sorting"]').attr(
                        'data-section');
                    var formData = new FormData();
                    formData.append('level_id', getParentElement);
                    $.ajax({
                        url: "{{ route('task.destroy_list') }}",
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
                                check.parents('[data-connect]').remove();
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
            })

        })
    }
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
{{-- detail task --}}
<script>
    function isEmpty(str) {
        return (!str || str.length === 0);
    }

    function $_taskDetail() {
        $(document).ready(function() {

            $('.card .task-header').click(function(e) {
                var task_id = $(this).parents('.card').find('h4').attr('data-taskid');
                var work_id = "{{ $id }}";
                var params = {
                    "task_id": task_id,
                    "work_id": work_id
                };
                var ser_data = jQuery.param(params);
                $.ajax({
                    url: `{{ route('task.detail_task') }}`,
                    type: 'GET',
                    data: ser_data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                }).done(function(res) {
                    // console.log(res);
                    if (res.status == 'success') {
                        $_updateNameDetail();
                        $_updateDeription();
                        sendMessage();
                        var $option = "";
                        var $priority = "";
                        var $fileupload = "";
                        var $imgupload = "";

                        res.task.attachment.forEach(Fileupload);
                        var $checkactive = "";
                        if (res.task.status == 0) {
                            $checkactive = `<div class="btn-group mb-4 mr-2 w-100" role="group" id="checkactive">
                                                    <button id="activeComplete" type="button" class="btn btn-primary dropdown-toggle"
                                                        ><i class='bx bx-check'></i>Hoàn thành</button>
                                                    <div class="dropdown-menu menu-date" aria-labelledby="btnDate"
                                                        style="will-change: transform;">
                                                        
                                                    </div>
                                                </div>`
                        } else {
                            $checkactive = `<div class="btn-group mb-4 mr-2 w-100" role="group" id="checkactive">
                                                    <button id="unActiveComplete" type="button" class="btn btn-outline-primary dropdown-toggle"
                                                        ><i class='bx bx-x'></i></i>Hủy hoàn thành</button>
                                                    <div class="dropdown-menu menu-date" aria-labelledby="btnDate"
                                                        style="will-change: transform;">
                                                        
                                                    </div>
                                                </div>`
                        }

                        function Fileupload(item) {
                            if (item.type == "file") {
                                $imgupload += `
                                    <div class="item-upload" id="file-${item.id}">
                                        <div class="image-preview" style="text-align:center; font-size:50px;color:#009688;">
                                            <a download="${item.name}" href="{{ asset('assets/images/task/${item.url}') }}"><i class='bx bxs-file' style="color:#009688;"></i> </a>   
                                        </div>
                                        <div class="content-preview">
                                            <p class="name-file">${item.name}</p>
                                            <div class="des-preview" data-idfile="${item.id}" data-filecommemt="[${item.name}]({{ asset('assets/images/task/${item.url}') }})">
                                                <p class="date">${item.created_at}</p>
                                                <a href="#" class="button-link file-image">Bình luận</a>
                                                <a href="#" class="button-link delete-file-image">Xóa</a>
                                            </div>
                                            
                                        </div>
                                    </div>
                                            `
                            } else {
                                $imgupload += `
                                    <div class="item-upload" id="file-${item.id}">
                                        <div class="image-preview">
                                            <a href="{{ asset('assets/images/task/${item.url}') }}"><img src="{{ asset('assets/images/task/${item.url}') }}" alt=""/></a> 
                                        </div>
                                        <div class="content-preview">
                                            <p class="name-file">${item.name}</p>
                                            <div class="des-preview" data-idfile="${item.id}" data-filecommemt="[${item.name}]({{ asset('assets/images/task/${item.url}') }})">
                                                <p class="date">${item.created_at}</p>
                                                <a href="#" class="button-link file-image">Bình luận</a>
                                                <a href="" class="button-link delete-file-image">Xóa</a>
                                            </div>
                                            
                                        </div>
                                    </div>`
                            }

                        }

                        if (!isEmpty(res.task.priority)) {
                            $color = `style="background-color:${res.task.priority.code}"`;
                        } else {
                            $color = `style="background-color:#009688"`;

                        }
                        res.Priority.forEach(Priority);

                        function Priority(item) {
                            if (res.task.priority_id == item.id) {
                                $priority += `
                                            <div data-priority="0" style="  display: inline-block;">
                                            <button class="active js-theme-color-item theme__button priority-color"  style="background-color:${item.code}">
                                                <i class="bx bx-check"></i>
                                            </button>
                                            </div>
                                            `
                            } else {
                                $priority += `
                                            <div data-priority="${item.id}" style="display: inline-block;">
                                            <button class="js-theme-color-item theme__button priority-color" id="priority-${item.id}" style="background-color:${item.code}">
                                                <i class="bx bx-check"></i>
                                            </button>
                                            </div>`
                            }

                        }
                        res.userWork.forEach(Opption);

                        function Opption(item) {
                            $option +=
                                `<option value="${item.user.id}">${item.user.fullname} (${item.user.code})</option>`
                        }
                        var $html3 = "";

                        res.task.assign.forEach(Assign);

                        function Assign(item) {
                            $html3 += `<li class="item js-member-item selected" id="assign-${item.id}"><a class="name js-select-member"
                                                 idmember="62a47f6d8eefda1d0d27fc21"
                                                title="${item.user.fullname}" autocompletetext="${item.user.code}"><span
                                                    class="member js-member" style="background-color:transparent"><img class="member-avatar" style="border-radius:50%"
                                                        height="30" width="30"
                                                        src="{{ asset('') }}${item.user.avatar}"
                                                        title="${item.user.fullname} (${item.user.code})"><span
                                                        id="62a47f6d8eefda1d0d27fc21-avatar"></span><span
                                                        class="member-gold-badge" title="This member has Trello Gold."
                                                        aria-label="This member has Trello Gold."></span></span><span
                                                    class="full-name" name="${item.user.fullname} (${item.user.code})"
                                                    aria-hidden="aria-hidden">
                                                    ${item.user.fullname} <span class="username">(${item.user.code})</span></span><span
                                                    class="icon-sm icon-check checked-icon"
                                                    aria-label="This member was added to card"></span><span
                                                    class="icon-sm icon-forward light option js-open-option" data-assignuser="${item.user.id}"><button class="deleteAssign" style="background-color:white;border:none;color:black"><i class='bx bx-x'></i></button></span></a>
                                            </li>`
                        }
                        var $html2 = "";
                        res.comment.forEach(myFunction);

                        function myFunction(item) {
                            var User_id = "{{ Auth::user()->id }}";
                            var $htmlComment = "";
                            var $file = "";
                            if (item.status == 1 && item.user_id == User_id) {
                                $htmlComment = ` <input class="comment-box-input1 js-new-comment-input is-focused" aria-label="Write a comment"
                                                        placeholder="Nhập bình luận" id="comment_id-${item.id}" value="${item.content}" disabled name="message" style="width:100%;font-size:13px">
                                                        <div class="container-button1" id="btn-${item.id}" style="display:none">
                                                            <div class="comment-controls u-clearfix" data-sendcommentid= ${item.id}>
                                                                <button
                                                                    class="nch-button btn btn-primary btn-message"
                                                                    type="button">Gửi</button>
                                                            </div>
                                                        </div>
                                                        <div class="comment-footer">
                                                            <span class="action-icons">
                                                                <a href="#" class="edit-comment " data-editcommentid=${item.id}><i
                                                                        class="bx bx-edit-alt editComment"></i></a>
                                                                <a href="#" data-commentid= ${item.id} data-abc="true"><i
                                                                        class="bx bx-trash delete-comment "></i></a>
                                                            </span>
                                                        </div>`
                            } else {
                                $htmlComment =
                                    ` <p class="m-b-5 m-t-10 des" > ${item.content} </p>`
                            }
                            if (item.file != null && item.file.type == "image") {
                                $file = `<div class="image-upload">
                                                        <img src="{{ asset('assets/images/task/${item.file.url}') }}" alt=""/>    
                                                    </div>`
                            }
                            $html2 += `<div class="d-flex comment-row" id="comment-delete-${item.id}">
                                                <div class="p-2">
                                                    <span class="round"><img
                                                            src="{{ asset('${item.user.avatar}') }}" alt="user"
                                                            style="width:50px;height:50px" /></span>
                                                </div>
                                                <div class="comment-text w-100">
                                                    <div class="title">
                                                        <h5>${item.user.fullname}</h5>
                                                    <span class="date">${item.created_at}</span>
                                                    </div>
                                                    <div class="comment-user">
                                                        <input type="hidden" name="user_id" id="username_input" value="1">
                                                        <input type="hidden" name="task_id" id="task_input" value="1">
                                                        <textarea class="comment-edit js-new-comment-input is-focused" contenteditable="true" name="message" id="messages_input1">${item.content}</textarea>
                                                    <div class="container-button active-button">
                                                            <div class="comment-controls u-clearfix">
                                                                <button class="nch-button btn btn-primary" type="button" id="message_send1">Gửi</button>
                                                                <div class="icon-close"><i class='bx bx-x'></i></div>
                                                            </div>
                                                            <div class="comment-box-options"><a class="comment-box-options-item js-comment-add-attachment" href="#" title="Add an attachment…">
                                                                    <span class="icon-sm icon-attachment"><i class="bx bx-link-alt"></i></span></a><a class="comment-box-options-item js-comment-mention-member" href="#" title="Mention a member…"><span class="icon-sm icon-mention">@</span></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    ${$htmlComment}
                                                    ${$file}
                                                    
                                                </div>
                                            </div>`;
                        }
                        $hoanThanh = "";
                        if (res.task.status == 1) {
                            $hoanThanh =
                                `<button class="btn-cover btn btn-primary"><i class='bx bx-check'></i>Hoàn thành </button>`;
                        }
                        $html = `<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog task">
                                        <div class="modal-content content">
                                            <div class="modal-header custom-header">
                                                <div class="cover w-100" id="taskdetail-${res.task.id}" ${$color}>
                                                    <button type="button" class="btn-close float-right close-modal" data-dismiss="modal"
                                                        aria-label="Close">X</button>
                                                    <div id="activeCompleteHeader">
                                                    ${$hoanThanh}
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-body body-task">
                                                <div class="row">

                                                    <div class="col-md-9">
                                                        <div class="title-task mb-2">
                                                            <div class="icon-task">
                                                                <i class="bx bxs-credit-card"></i>
                                                            </div>
                                                            <textarea class="mod-card-back-title js-card-detail-title-input" dir="auto" data-autosize="true"
                                                                style="overflow: hidden; overflow-wrap: break-word; height: 32.8px" id="taskNameDetail">${res.task.title}</textarea>
                                                        </div>
                                                        <p class="in-list">Thuộc danh sách ${res.task.level.name}</p>
                                                        <div class="title-task mb-2">
                                                            <div class="icon-task">
                                                                <i class="bx bx-align-left"></i>
                                                            </div>
                                                            <h4>Mô tả</h4>
                                                        </div>
                                                        <div class="description mb-2">
                                                            <textarea placeholder="Thêm mô tả ở đây..."
                                                                class="field field-autosave js-description-draft description card-description" data-autosize="true"
                                                                style="overflow: hidden; overflow-wrap: break-word; resize: none; height: 108px" id="descriptionDetail">${res.task.detail?res.task.detail.description:''}</textarea>
                                                        </div>
                                                        <div class="title-task mb-2">
                                                            <div class="icon-task">
                                                                <i class="bx bx-link-alt"></i>
                                                            </div>
                                                            <h4>Tệp đính kèm</h4>
                                                        </div>
                                                        <div class="preview-upload">
                                                            ${$imgupload}                                                                 
                                                            </div>
                                                        <div class="upload-file mb-2">
                                                            <form action="" class="form" method="post" id="form">
                                                                <input type="file" name="Image" id="image" multiple="" class="custom-file-container__custom-file__custom-file-input" onchange="imageSelect()">
                                                                <span class="custom-file-container__custom-file__custom-file-control">Chọn tệp
                                                                    <span class="custom-file-container__custom-file__custom-file-control__button" onclick="document.getElementById('image').click()"> Tải lên </span></span>
                                                            </form>
                                                            <div id="img-preview">
                                                                
                                                            </div>
                                                            
                                                            <button class="btn btn-primary mb-2 btn__save" id="btn-save-attra"><i class='bx bxs-save icon__save'></i>Lưu</button>
                                                        </div>
                                                        <div class="comment-list">
                                                            <div class="title-task mb-2">
                                                                <div class="icon-task">
                                                                    <i class="bx bx-box"></i>
                                                                </div>
                                                                <h4>Bình luận</h4>
                                                            </div>
                                                            <a class="subtle button js-show-details" href="#">Hiển thị</a>
                                                        </div>
                                                        <div class="content-comment">
                                                            <div class="avatar-user">
                                                                <img src="{{ asset(Auth::user()->avatar) }}" alt=""  style="width:50px;height:50px"/>
                                                            </div>
                                                            <form>
                                                                <div class="comment-frame">
                                                                    <div class="comment-box">
                                                                        <form id="message_form">
                                                                            <input type="hidden" name="user_id" id="username_input"
                                                                                value="{{ Auth::user()->id }}">
                                                                                <input type="hidden" name="task_id" id="task_input"
                                                                                value="${res.task.id}">
                                                                            <input class="comment-box-input js-new-comment-input is-focused" aria-label="Write a comment"
                                                                                placeholder="Nhập bình luận" dir="auto" data-autosize="true"
                                                                                style="overflow: hidden; overflow-wrap: break-word; height: 20px;" name="message" id="messages_input">
                                                                            <div class="container-button" id="showbtn">
                                                                                <div class="comment-controls u-clearfix">
                                                                                    <button
                                                                                        class="nch-button btn btn-primary"
                                                                                        type="button" id="message_send">Gửi</button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="row clear-both recent-comment">
                                                            <div class="col-md-12 p-0">
                                                                <div class="card1">
                                                                        <div class="comment-widgets m-b-20">
                                                                            ${$html2}
                                                                    </div>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 add-to-card">
                                                            <div class="btn-group mb-4 mr-2 w-100" role="group">
                                                                
                                                                <button id="btnOutline" type="button" class="btn btn-outline-primary dropdown-toggle"
                                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                                                        class='bx bxs-user-plus'></i>Thành viên</button>
                                                                <div class="dropdown-menu dropdown-card" aria-labelledby="btnOutline"
                                                                    style="will-change: transform;">
                                                                    <div class="title-member">
                                                                        <h4>Thành viên</h4>
                                                                    </div>
                                                                    <button type="button" class="btn-close float-right" data-dismiss="modal"
                                                                        aria-label="Close">X</button>
                                                                       <div class="invite-team">
                                                                        <select multiple="multiple" class="form-control select-option" id="fullname" name="fullname" >
                                                                            ${$option}
                                                                        </select>
                                                                        <button type="button" class="btn btn-primary" id="btn-save-assign"><i class='bx bx-save icon__save'></i>Lưu</button>
                                                                        </div>
                                                                    <div class="pop-over-section js-board-members">
                                                                        <h4>Thành viên</h4>
                                                                        <div class="js-loading hide">
                                                                            <p class="empty" style="padding: 24px 6px">Loading…</p>
                                                                        </div>
                                                                        <div class="js-no-results hide">
                                                                            <p class="empty" style="padding: 24px 6px">Không có dữ liệu
                                                                            </p>
                                                                        </div>
                                                                        <ul class="pop-over-member-list checkable u-clearfix js-mem-list" style="height: 110px;overflow: auto;"> 
                                                                            ${$html3}
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="btn-group mb-4 mr-2 w-100" role="group">
                                                                <button id="btnLabel" type="button" class="btn btn-outline-primary dropdown-toggle"
                                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class='bx bx-purchase-tag-alt'></i>Nhãn</button>
                                                                <div class="dropdown-menu menu-label" aria-labelledby="btnLabel"
                                                                    style="will-change: transform;">
                                                                    <div class="title-member">
                                                                        <h4>Nhãn</h4>
                                                                    </div>
                                                                    <button type="button" class="btn-close float-right" data-dismiss="modal"
                                                                        aria-label="Close">X</button>
                                                                        <div class="theme__colors js-theme-colors" id="optionPriority">
                                                                            <div id="remove-prio" style="width:100%;">
                                                                            ${$priority}
                                                                            </div>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                            <div class="btn-group mb-4 mr-2 w-100" role="group">
                                                                <button id="btnDate" type="button" class="btn btn-outline-primary dropdown-toggle"
                                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class='bx bxs-calendar'></i>Ngày</button>
                                                                <div class="dropdown-menu menu-date" aria-labelledby="btnDate"
                                                                    style="will-change: transform;">
                                                                    <div class="title-member">
                                                                        <h4>Ngày</h4>
                                                                    </div>
                                                                    <button type="button" class="btn-close float-right" data-dismiss="modal"
                                                                        aria-label="Close">X</button>
                                                                    <div class="date-container">
                                                                       <div class="item">
                                                                        <label class="form-label"  for="start-date">Ngày bắt đầu</label>
                                                                            <input class="form-control" id="timeStart" type="datetime-local" value="${res.task.timeStart}"/>
                                                                        </div>
                                                                        <div class="item">
                                                                            <label class="form-label"  for="end-date">Ngày kết thúc</label>
                                                                                <input class="form-control" id="timeOut" type="datetime-local" value="${res.task.timeOut}"/>
                                                                        </div>
                                                                            <div class="button-date">
                                                                                <button class="btn btn-primary mb-2 btn-save-date" id="saveDeadline"><i class='bx bxs-save icon__save'></i>Lưu</button>
                                                                                <button class="btn btn-light mb-2"><i class='bx bx-x'></i>Hủy bỏ</button>    
                                                                            </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            ${$checkactive}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                            `
                        $("#detail_modal").append($html);
                        sendMessage(res.task.id);
                        $_updateNameDetail();
                        saveAttra(res.task.id);
                        editComment();
                        deleteAssign(task_id, work_id)
                        activeComplete(task_id)
                        unActiveComplete(task_id)
                        saveDeadline(task_id)
                        checkpriority(task_id)
                        sendEditComment()
                        $(".file-image").click(function() {
                            var getParentElement = $(this).parents().attr(
                                'data-filecommemt');
                            $("#messages_input").val(getParentElement);
                            $("#messages_input").focus();
                        })
                        $('.delete-file-image').off('click').on('click', function(event) {
                            event.preventDefault();
                            Swal.fire({
                                title: 'Bạn có chắc xóa tệp đính kèm ?',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Confirm'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    var check = $(this);
                                    var getParentElement = $(this).parents()
                                        .attr(
                                            'data-idfile');
                                    var formData = new FormData();
                                    formData.append('id', getParentElement);
                                    $.ajax({
                                        url: "{{ route('task.delete_file') }}",
                                        type: 'POST',
                                        data: formData,
                                        cache: false,
                                        contentType: false,
                                        processData: false,
                                        dataType: 'json',
                                    }).done(function(res) {
                                        if (res.status == 'success') {
                                            swal.fire({
                                                title: res
                                                    .message,
                                                icon: 'success',
                                                showCancelButton: false,
                                                showConfirmButton: false,
                                                position: 'center',
                                                padding: '2em',
                                                timer: 1500,
                                            }).then((result) => {
                                                $("#file-" +
                                                        getParentElement
                                                    )
                                                    .remove();
                                                $("#comment-delete-" +
                                                        res.id)
                                                    .remove();

                                            })
                                        } else {
                                            Swal.fire({
                                                title: res
                                                    .message,
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

                        })


                        saveAssign(task_id, work_id)
                        $_deleteComent();
                        $_updateDeription();
                        $("#fullname").multipleSelect({
                            placeholder: "Chọn thành viên",
                            filter: true,
                            showClear: true,
                            //placeholder: 'Chọn mã hợp đồng',
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
                        });
                        $('#exampleModal').modal('show');
                        $('#exampleModal').on('hidden.bs.modal', function(e) {
                            $('#detail_modal').html("");
                        })
                        $(".comment-box-input").click(function() {
                            $(".container-button").toggleClass("active-button");
                        })

                        $(".js-show-details").click(function() {
                            let x = $(this).text();
                            if (x == "Hiển thị") {
                                $(this).text("Ẩn bình luận");
                                $(".recent-comment").show().slideDown();
                            } else {
                                $(this).text("Hiển thị");
                                $(".recent-comment").hide().slideUp();
                            }
                        })
                        $('.theme__colors button').click(function() {
                            $('.menu-label').addClass('open-label')
                        })
                        $('.menu-label .btn-close').click(function() {
                            $('.menu-label').removeClass('open-label')
                        })
                        $('.btn-save-date').click(function() {
                            $('.menu-date').addClass('open-date');
                        })
                        $('.menu-date .btn-close').click(function() {
                            $('.menu-date').removeClass('open-date');
                        })
                        $('.ms-parent').on('click', function() {
                            $('.dropdown-menu.dropdown-card').addClass(
                                'open-ms');
                        })
                        $('.btn-close').on('click', function() {
                            $('.dropdown-card').removeClass('open-ms');
                        })
                        $(".icon-close").click(function() {
                            $(".comment-user").removeClass("active");
                            $(".des").show();
                            $(".comment-footer").show();
                        })
                        $(".close-modal").click(function() {
                            $("#exampleModal").hide();
                            $(".modal-backdrop").hide();
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
            });
        });
    }
</script>

{{-- cập nhật detail task --}}
<script>
    function $_updateDeription() {
        $("#descriptionDetail").change(function() {
            var value = $("#descriptionDetail").val();
            var task_id = $("#task_input").val();
            var formData = new FormData();
            formData.append('task_id', task_id);
            formData.append('description', value);
            $.ajax({
                url: "{{ route('task.update_deription_task') }}",
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
            }).done(function(res) {});
        });
    }

    function $_updateNameDetail() {
        $("#taskNameDetail").change(function() {
            var value = $("#taskNameDetail").val();
            var task_id = $("#task_input").val();
            var formData = new FormData();
            formData.append('task_id', task_id);
            formData.append('name', value);
            $.ajax({
                url: "{{ route('task.update_name_task') }}",
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
            }).done(function(res) {
                var task_id = '#task-' + res.task.id;
                $(task_id).html(res.task.title);
            });
        });
    }
</script>
{{-- add danh sách --}}
<script>
    $("#add-list").off('click').on('click', function(event) {
        event.preventDefault();
        $("#error-list").html("");
        $('.add-list').show();
        $('.edit-list').hide();
        $('.edit-list-title').hide();
        $('.add-list-title').show();
        $('#addListModal').modal('show');
        addTask();

    });
    $(".add-list").off('click').on('click', function(event) {
        var $_listTitle = document.getElementById('s-list-name').value;
        if ($_listTitle != '') {
            var formData = new FormData();
            formData.append('listTitle', $_listTitle);
            formData.append('work_id', {{ $id }});
            $.ajax({
                url: '{{ route('task.store_list') }}',
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
                        var $_listTitleLower = $_listTitle.toLowerCase();
                        var $_listTitleRemoveWhiteSpaces = $_listTitleLower.split(' ').join(
                            '_');
                        var $_listSectionDataAttr = $_listTitleRemoveWhiteSpaces;
                        $html = '<div data-section="' + res.level_id +
                            '" class="task-list-container  mb-4 " data-connect="sorting">' +
                            '<div class="connect-sorting">' +
                            '<div class="task-container-header">' +
                            '<h6 class="s-heading" data-listTitle="' + $_listTitle + '">' +
                            $_listTitle + '</h6>' +
                            '<div class="dropdown">' +
                            '<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">' +
                            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>' +
                            '</a>' +
                            '<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-4">' +
                            '<a class="dropdown-item list-edit" href="javascript:void(0);">Chỉnh sửa</a>' +
                            '<a class="dropdown-item list-delete" href="javascript:void(0);">Xóa danh sách</a>' +
                            '<a class="dropdown-item list-clear-all" href="javascript:void(0);">Xóa tất cả công việc</a>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="connect-sorting-content" data-sortable="true">' +
                            '</div>' +
                            '<div class="add-s-task">' +
                            '<a class="addTask"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg> Thêm mới</a>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                        $(".task-list-section").append($html);
                        $('#addListModal').modal('hide');
                        $_taskSortable();
                        $_editList()
                        $_deleteList();
                        $_clearList();
                        $_taskDetail()
                        addTask();
                        $_taskEdit();
                        $_taskDelete();
                        $('#s-list-name').val('');

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
        } else {
            $("#error-list").html("Vui lòng nhập tên danh sách");
        }
    })
</script>
{{-- Gửi tin nhắn --}}
<script>
    function sendMessage() {
        $('#message_send').click(function() {

            var messages_input = $("#messages_input").val();
            var task_id = $("#task_input").val();
            var formData = new FormData();
            formData.append('task_id', task_id);
            formData.append('messages_input', messages_input);
            $.ajax({
                url: "{{ route('task.comment') }}",
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
            }).done(function(res) {
                var reload = $('.comment-widgets').html();
                var $html = `<div class="d-flex comment-row">
                                    <div class="p-2">
                                        <span class="round"><img
                                                src="{{ asset('${res.comment.user.avatar}') }}" alt="user"
                                                style="width:50px;height:50px" /></span>
                                    </div>
                                    <div class="comment-text w-100">
                                        <div class="title">
                                            <h5>${res.comment.user.fullname}</h5>
                                        <span class="date">${res.comment.created_at}</span>
                                        </div>
                                        <div class="comment-user">
                                            <input type="hidden" name="user_id" id="username_input" value="1">
                                            <input type="hidden" name="task_id" id="task_input" value="1">
                                            <textarea class="comment-edit js-new-comment-input is-focused" contenteditable="true" name="message" id="messages_input1">${res.comment.content}</textarea>
                                        <div class="container-button active-button">
                                                <div class="comment-controls u-clearfix">
                                                    <button class="nch-button btn btn-primary" type="button" id="message_send1">Gửi</button>
                                                    <div class="icon-close"><i class='bx bx-x'></i></div>
                                                </div>
                                                <div class="comment-box-options"><a class="comment-box-options-item js-comment-add-attachment" href="#" title="Add an attachment…">
                                                        <span class="icon-sm icon-attachment"><i class="bx bx-link-alt"></i></span></a><a class="comment-box-options-item js-comment-mention-member" href="#" title="Mention a member…"><span class="icon-sm icon-mention">@</span></a>
                                                </div>
                                            </div>
                                        </div>
                                        <input class="comment-box-input1 js-new-comment-input is-focused" aria-label="Write a comment"
                                        placeholder="Nhập bình luận" id="comment_id-${res.comment.id}" value="${res.comment.content}" disabled name="message" style="width:100%;font-size:13px">
                                        <div class="container-button1" id="btn-${res.comment.id}" style="display:none">
                                            <div class="comment-controls u-clearfix" data-sendcommentid= ${res.comment.id}>
                                                <button
                                                    class="nch-button btn btn-primary btn-message"
                                                    type="button">Gửi</button>
                                            </div>
                                        </div>
                                        <div class="comment-footer">
                                            <span class="action-icons">
                                                <a href="#" data-abc="true" class="edit-comment" data-editcommentid=${res.comment.id}><i
                                                        class="bx bx-edit-alt editComment"></i></a>
                                                <a href="#" data-commentid= ${res.comment.id} data-abc="true"><i
                                                        class="bx bx-trash delete-comment"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                </div>`;
                $('.comment-widgets').html($html + reload);
                $("#messages_input").val('');
                $_deleteComent();
                editComment();
                sendEditComment()

            });
        })
    }
</script>
{{-- Xóa tin nhắn --}}
<script>
    function $_deleteComent() {

        $('.delete-comment').off('click').on('click', function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Bạn có chắc xóa tin nhắn ?',
                text: "Sau khi chấp nhận tin nhắn sẽ không còn tồn tại.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirm'
            }).then((result) => {
                if (result.isConfirmed) {
                    var check = $(this);
                    var getParentElement = $(this).parents().attr(
                        'data-commentid');
                    var formData = new FormData();
                    formData.append('id', getParentElement);
                    $.ajax({
                        url: "{{ route('task.delete_comment') }}",
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
                                check.parents('.comment-row').remove();
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
            })

        })
    }
</script>
{{-- edit tin nhắn --}}
<script>
    function editComment() {
        $('.editComment').off('click').on('click', function(event) {
            event.preventDefault();
            var comment_id = $(this).parents().attr('data-editcommentid');
            $("#comment_id-" + comment_id).prop('disabled', false);
            $("#btn-" + comment_id).show();
        })
    }
</script>
{{-- send tin nhắn edit --}}
<script>
    function sendEditComment() {
        $('.btn-message').off('click').on('click', function(event) {
            event.preventDefault();
            var comment_id = $(this).parents().attr('data-sendcommentid');
            var content = $("#comment_id-" + comment_id).val();
            var formData = new FormData();
            formData.append('comment_id', comment_id);
            formData.append('content', content);
            $.ajax({
                url: "{{ route('task.edit_comment') }}",
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
                    })
                    $("#comment_id-" + comment_id).prop('disabled', true);
                    $("#btn-" + comment_id).hide();
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
        })
    }
</script>
{{-- save assign --}}
<script>
    function saveAssign(task_id, work_id) {
        $("#btn-save-assign").click(function() {
            var user = $("#fullname").val();
            var formData = new FormData();
            formData.append('user', user);
            formData.append('task_id', task_id);
            formData.append('work_id', work_id);


            $.ajax({
                url: "{{ route('task.assign') }}",
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
                    })
                    var reloadAssign = $(".checkable").html();
                    var $ajaxAssign = '';
                    var $imageAssign = '';
                    res.users.forEach(function(item) {
                        $ajaxAssign += `<li class="item js-member-item selected" id="assign-${item.assign.id}"><a class="name js-select-member"
                                             idmember="62a47f6d8eefda1d0d27fc21"
                                            title="${item.user.fullname}" autocompletetext="${item.user.code}"><span
                                                class="member js-member" style="background-color:transparent"><img class="member-avatar" style="border-radius:50%"
                                                    height="30" width="30"
                                                    src="{{ asset('') }}${item.user.avatar}"
                                                    title="${item.user.fullname} (${item.user.code})"><span
                                                    id="62a47f6d8eefda1d0d27fc21-avatar"></span><span
                                                    class="member-gold-badge" title="This member has Trello Gold."
                                                    aria-label="This member has Trello Gold."></span></span><span
                                                class="full-name" name="${item.user.fullname} (${item.user.code})"
                                                aria-hidden="aria-hidden">
                                                ${item.user.fullname} <span class="username">(${item.user.code})</span></span><span
                                                class="icon-sm icon-check checked-icon"
                                                aria-label="This member was added to card"></span><span
                                                class="icon-sm icon-forward light option js-open-option" data-assignuser="${item.user.id}"><button class="deleteAssign" style="background-color:white;border:none;color:black"><i class='bx bx-x'></i></button></span></a>
                                        </li>`;
                        $imageAssign += `<li style="display: inline-block;margin: 5px -10px" id="image-assign-${task_id}-${item.assign.id}" idmember="62a47f6d8eefda1d0d27fc21"
                                                                title="${item.user.fullname}">
                                                                <img
                                                                    class="rounded-circle"
                                                                    src="{{ asset('') }}${item.user.avatar}" style="width:25px;height:25px"
                                                                    alt="" >
                                                            </li>`;
                    })
                    var resetImage = $("#list-assign-" + task_id).html();
                    $("#list-assign-" + task_id).html("");
                    $("#list-assign-" + task_id).html(resetImage + $imageAssign);
                    $(".checkable").html($ajaxAssign + reloadAssign);
                    deleteAssign(task_id, work_id);
                    $(".select-option").remove();
                    var $ajaxOption = "";
                    res.userWork.forEach(function(item) {
                        $ajaxOption +=
                            `<option value="${item.user.id}">${item.user.fullname} (${item.user.code})</option>`
                    });
                    var $ajaxdata = `<select multiple="multiple" class="form-control select-option" id="fullname" name="fullname" >
                                        ${$ajaxOption}
                                    </select>`
                    var resetSelect = $(".invite-team").html();
                    $(".invite-team").html($ajaxdata + resetSelect);
                    selectAssign()

                    var $ajaxcomment = "";
                    res.comments.forEach(function(item) {
                        var $ajaxfile = "";
                        $ajaxcomment += `<div class="d-flex comment-row" id="comment-delete-${item.id}">
                                        <div class="p-2">
                                            <span class="round"><img
                                                    src="{{ asset(Auth::user()->avatar) }}" alt="user"
                                                    style="width:50px;height:50px" /></span>
                                        </div>
                                        <div class="comment-text w-100">
                                            <div class="title">
                                                <h5>{{ Auth::user()->fullname }}</h5>
                                            <span class="date">${item.created_at}</span>
                                            </div>
                                            <div class="comment-user">
                                                <input type="hidden" name="user_id" id="username_input" value="1">
                                                <input type="hidden" name="task_id" id="task_input" value="1">
                                                <textarea class="comment-edit js-new-comment-input is-focused" contenteditable="true" name="message" id="messages_input1">${item.content}</textarea>
                                            <div class="container-button active-button">
                                                    <div class="comment-controls u-clearfix">
                                                        <button class="nch-button btn btn-primary" type="button" id="message_send1">Gửi</button>
                                                        <div class="icon-close"><i class='bx bx-x'></i></div>
                                                    </div>
                                                    <div class="comment-box-options"><a class="comment-box-options-item js-comment-add-attachment" href="#" title="Add an attachment…">
                                                            <span class="icon-sm icon-attachment"><i class="bx bx-link-alt"></i></span></a><a class="comment-box-options-item js-comment-mention-member" href="#" title="Mention a member…"><span class="icon-sm icon-mention">@</span></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="m-b-5 m-t-10 des" > ${item.content} </p>                                            
                                        </div>
                                    </div>`;

                    })

                    var resset_commet = $(".comment-widgets").html();
                    $(".comment-widgets").html($ajaxcomment + resset_commet);

                    saveAssign(task_id, work_id)
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
        })
    }
</script>
{{-- check mức độ --}}
<script>
    function checkpriority(task_id) {
        $('.priority-color').off('click').on('click', function(event) {
            event.preventDefault();
            var priority = $(this).parents().attr('data-priority');
            var formData = new FormData();
            formData.append('priority', priority);
            formData.append('task_id', task_id);

            $.ajax({
                url: "{{ route('task.change_priority') }}",
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
            }).done(function(res) {
                if (res.status == 'success') {
                    if (res.color != 0) {
                        $("#taskdetail-" + task_id).css("background-color", res.color);
                        $("#taskbody-" + task_id).css("background-color", res.color);
                        $("#taskbody-" + task_id).css("color", "white");
                        $("#task-" + task_id).css("color", "white");
                        $("#tasktra-" + task_id).css("color", "white");
                        $('.priority-color').removeClass('active');
                        $('#priority-' + res.id).addClass('active');
                    } else {
                        $("#taskdetail-" + task_id).css("background-color", "#009688");
                        $("#taskbody-" + task_id).css("background-color", "white");
                        $("#taskbody-" + task_id).css("color", "#888ea8");
                        $("#task-" + task_id).css("color", "##3b3f5c");
                        $("#tasktra-" + task_id).css("color", "#e7515a");
                        $('.priority-color').removeClass('active');
                    }
                    $('#remove-prio').remove();
                    var $priority = `<div id="remove-prio" style="  width:100%">`;
                    res.allPriority.forEach(Priority);

                    function Priority(item) {
                        if (res.id == item.id) {
                            $priority += `
                                            <div data-priority="0" style="  display: inline-block;">
                                            <button class="active js-theme-color-item theme__button priority-color"  style="background-color:${item.code}">
                                                <i class="bx bx-check"></i>
                                            </button>
                                            </div>
                                            `
                        } else {
                            $priority += `
                                            <div data-priority="${item.id}" style="  display: inline-block;">
                                            <button class="js-theme-color-item theme__button priority-color" id="priority-${item.id}" style="background-color:${item.code}">
                                                <i class="bx bx-check"></i>
                                            </button>
                                            </div>`
                        }

                    }
                    $priority += `</div>`
                    $('#optionPriority').append($priority);
                    checkpriority(task_id);


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

        })
    }
</script>
{{-- save tệp đính kèm --}}
<script>
    function saveAttra(task_id) {
        $('#btn-save-attra').off('click').on('click', function(event) {
            var formData = new FormData();
            images.forEach(function(item) {
                formData.append('upload[]', item.file);
            })
            formData.append('task_id', task_id);
            $.ajax({
                url: "{{ route('task.upload_file') }}",
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
                    })
                    var $ajaxUpload = "";
                    res.arr_task_attra.forEach(function(item) {
                        if (item.type == "file") {
                            $ajaxUpload += `
                                    <div class="item-upload" id="file-${item.id}">
                                        <div class="image-preview" style="text-align:center; font-size:50px;color:#009688;">
                                            <a download="${item.name}" href="{{ asset('assets/images/task/${item.url}') }}"><i class='bx bxs-file' style="color:#009688;"></i> </a>   
                                        </div>
                                        <div class="content-preview">
                                            <p class="name-file">${item.name}</p>
                                            <div class="des-preview" data-idfile="${item.id}" data-filecommemt="[${item.name}]({{ asset('assets/images/task/${item.url}') }})">
                                                <p class="date">${item.created_at}</p>
                                                <a href="#" class="button-link file-image">Bình luận</a>
                                                <a href="#" class="button-link delete-file-image">Xóa</a>
                                            </div>
                                            
                                        </div>
                                    </div>
                                            `
                        } else {
                            $ajaxUpload += `
                                    <div class="item-upload" id="file-${item.id}">
                                        <div class="image-preview">
                                            <a href="{{ asset('assets/images/task/${item.url}') }}"><img src="{{ asset('assets/images/task/${item.url}') }}" alt=""/></a> 
                                        </div>
                                        <div class="content-preview">
                                            <p class="name-file">${item.name}</p>
                                            <div class="des-preview" data-idfile="${item.id}" data-filecommemt="[${item.name}]({{ asset('assets/images/task/${item.url}') }})">
                                                <p class="date">${item.created_at}</p>
                                                <a href="#" class="button-link file-image">Bình luận</a>
                                                <a href="" class="button-link delete-file-image">Xóa</a>
                                            </div>
                                            
                                        </div>
                                    </div>`
                        }
                    })
                    var reset_upload = $(".preview-upload").html();
                    $(".preview-upload").html($ajaxUpload + reset_upload);
                    var $ajaxcomment = "";
                    res.arr_comment.forEach(function(item) {
                        var $ajaxfile = "";
                        if (item.attra.type == "image") {
                            $ajaxfile = `<div class="image-upload">
                                                <img src="{{ asset('assets/images/task/${item.attra.url}') }}" alt=""/>    
                                            </div>`
                        }
                        $ajaxcomment += `<div class="d-flex comment-row" id="comment-delete-${item.comment.id}">
                                        <div class="p-2">
                                            <span class="round"><img
                                                    src="{{ asset(Auth::user()->avatar) }}" alt="user"
                                                    style="width:50px;height:50px" /></span>
                                        </div>
                                        <div class="comment-text w-100">
                                            <div class="title">
                                                <h5>{{ Auth::user()->fullname }}</h5>
                                            <span class="date">${item.comment.created_at}</span>
                                            </div>
                                            <div class="comment-user">
                                                <input type="hidden" name="user_id" id="username_input" value="1">
                                                <input type="hidden" name="task_id" id="task_input" value="1">
                                                <textarea class="comment-edit js-new-comment-input is-focused" contenteditable="true" name="message" id="messages_input1">${item.comment.content}</textarea>
                                            <div class="container-button active-button">
                                                    <div class="comment-controls u-clearfix">
                                                        <button class="nch-button btn btn-primary" type="button" id="message_send1">Gửi</button>
                                                        <div class="icon-close"><i class='bx bx-x'></i></div>
                                                    </div>
                                                    <div class="comment-box-options"><a class="comment-box-options-item js-comment-add-attachment" href="#" title="Add an attachment…">
                                                            <span class="icon-sm icon-attachment"><i class="bx bx-link-alt"></i></span></a><a class="comment-box-options-item js-comment-mention-member" href="#" title="Mention a member…"><span class="icon-sm icon-mention">@</span></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="m-b-5 m-t-10 des" > ${item.comment.content} </p>
                                            ${$ajaxfile}
                                            
                                        </div>
                                    </div>`;

                    })

                    var resset_commet = "";
                    resset_commet = $(".comment-widgets").html();
                    $(".comment-widgets").html($ajaxcomment + resset_commet);
                    $(".image_container").remove();
                    images = [];
                    $(".file-image").click(function() {
                        var getParentElement = $(this).parents().attr('data-filecommemt');
                        $("#messages_input").val(getParentElement);
                        $("#messages_input").focus();
                    })
                    $('.delete-file-image').off('click').on('click', function(event) {
                        event.preventDefault();
                        Swal.fire({
                            title: 'Bạn có chắc xóa tệp đính kèm ?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Confirm'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                var check = $(this);
                                var getParentElement = $(this).parents().attr(
                                    'data-idfile');
                                var formData = new FormData();
                                formData.append('id', getParentElement);
                                $.ajax({
                                    url: "{{ route('task.delete_file') }}",
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
                                            $("#file-" +
                                                    getParentElement)
                                                .remove();
                                            $("#comment-delete-" + res
                                                .id).remove();

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
                        })

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

        })
    }
</script>
<script>
    function saveDeadline(task_id) {
        $("#saveDeadline").click(function() {
            console.log(task_id);
            var formData = new FormData();
            formData.append('task_id', task_id);
            formData.append('timeStart', $("#timeStart").val());
            formData.append('timeOut', $("#timeOut").val());
            $.ajax({
                url: "{{ route('task.save_deadline') }}",
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
            }).done(function(res) {
                console.log(res);
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
        })
    }
</script>
<script>
    function activeComplete(task_id) {
        $("#activeComplete").click(function() {
            Swal.fire({
                title: 'Bạn có chắc đánh dấu hoàn thành không ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Xác nhận',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    var formData = new FormData();
                    formData.append('task_id', task_id);
                    $.ajax({
                        url: "{{ route('task.change_status_task') }}",
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
                            })
                            var $ajaxAcive =
                                `<button class="btn-cover btn btn-primary"><i class='bx bx-check'></i>Hoàn thành </button>`
                            $("#activeCompleteHeader").html($ajaxAcive);
                            var $ajaxUnActive = `<button id="unActiveComplete" type="button" class="btn btn-outline-primary dropdown-toggle"
                                                        ><i class='bx bx-x'></i></i>Hủy hoàn thành</button>
                                                    <div class="dropdown-menu menu-date" aria-labelledby="btnDate"
                                                        style="will-change: transform;">
                                                        
                                                    </div>`
                            $("#checkactive").html("");
                            $("#checkactive").html($ajaxUnActive);
                            unActiveComplete(task_id)
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
        })
    }
</script>

<script>
    function unActiveComplete(task_id) {
        $("#unActiveComplete").click(function() {
            Swal.fire({
                title: 'Bạn có chắc đánh dấu hủy hoàn thành không ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Xác nhận',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    var formData = new FormData();
                    formData.append('task_id', task_id);
                    $.ajax({
                        url: "{{ route('task.change_status_task') }}",
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
                            })
                            $("#activeCompleteHeader").html('');
                            var $ajaxActive = `<button id="activeComplete" type="button" class="btn btn-primary dropdown-toggle"
                                                        ><i class='bx bx-check'></i>Hoàn thành</button>
                                                    <div class="dropdown-menu menu-date" aria-labelledby="btnDate"
                                                        style="will-change: transform;">
                                                        
                                                    </div>`
                            $("#checkactive").html("");
                            $("#checkactive").html($ajaxActive);
                            activeComplete(task_id);
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
        })
    }
</script>
<script>
    function deleteAssign(task_id, work_id) {
        $(".deleteAssign").click(function() {
            Swal.fire({
                title: 'Bạn có chắc xóa thành viên không ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Xác nhận',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    var getParentElement = $(this).parents().attr('data-assignuser');
                    var formData = new FormData();
                    formData.append('task_id', task_id);
                    formData.append('work_id', work_id);
                    formData.append('user_id', getParentElement);
                    $.ajax({
                        url: "{{ route('task.delete_assign') }}",
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
                            })
                            $("#assign-" + res.assign.id).remove();
                            var $ajaxcomment = `<div class="d-flex comment-row" id="comment-delete-${res.comment.id}">
                                        <div class="p-2">
                                            <span class="round"><img
                                                    src="{{ asset(Auth::user()->avatar) }}" alt="user"
                                                    style="width:50px;height:50px" /></span>
                                        </div>
                                        <div class="comment-text w-100">
                                            <div class="title">
                                                <h5>{{ Auth::user()->fullname }}</h5>
                                            <span class="date">${res.comment.created_at}</span>
                                            </div>
                                            <div class="comment-user">
                                                <input type="hidden" name="user_id" id="username_input" value="1">
                                                <input type="hidden" name="task_id" id="task_input" value="1">
                                                <textarea class="comment-edit js-new-comment-input is-focused" contenteditable="true" name="message" id="messages_input1">${res.comment.content}</textarea>
                                            <div class="container-button active-button">
                                                    <div class="comment-controls u-clearfix">
                                                        <button class="nch-button btn btn-primary" type="button" id="message_send1">Gửi</button>
                                                        <div class="icon-close"><i class='bx bx-x'></i></div>
                                                    </div>
                                                    <div class="comment-box-options"><a class="comment-box-options-item js-comment-add-attachment" href="#" title="Add an attachment…">
                                                            <span class="icon-sm icon-attachment"><i class="bx bx-link-alt"></i></span></a><a class="comment-box-options-item js-comment-mention-member" href="#" title="Mention a member…"><span class="icon-sm icon-mention">@</span></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="m-b-5 m-t-10 des" > ${res.comment.content} </p>                                            
                                        </div>
                                    </div>`;
                            var resset_commet = $(".comment-widgets").html();
                            $(".comment-widgets").html($ajaxcomment + resset_commet);
                            $(".select-option").remove();
                            $("#image-assign-" + task_id + "-" + res.assign.id).remove();

                            var $ajaxOption = "";
                            res.userWork.forEach(function(item) {
                                $ajaxOption +=
                                    `<option value="${item.user.id}">${item.user.fullname} (${item.user.code})</option>`
                            });
                            var $ajaxdata = `<select multiple="multiple" class="form-control select-option" id="fullname" name="fullname" >
                                            ${$ajaxOption}
                                        </select>`
                            var resetSelect = $(".invite-team").html();
                            $(".invite-team").html($ajaxdata + resetSelect);
                            selectAssign()
                            deleteAssign(task_id, work_id)
                            saveAssign(task_id, work_id)
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
        })
    }
</script>
@endsection
