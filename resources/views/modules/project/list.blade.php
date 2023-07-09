@extends('master')
@section('main-content')
@section('title', 'Danh sách dự án')
    <div class="admin-data-content layout-top-spacing">
        <div class="row project-cards">
            <div class="col-md-12">
                <div class="card">
                    <div class="d-flex justify-content-between">
                        <div class="col-md-6 p-0">
                            <ul class="nav nav-tabs border-tab" id="top-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="top-project-all" data-toggle="tab" href="#top-home"
                                        role="tab" aria-controls="top-home" aria-selected="true"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-target">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <circle cx="12" cy="12" r="6"></circle>
                                            <circle cx="12" cy="12" r="2"></circle>
                                        </svg>Tất cả</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-top-tab" data-toggle="tab" href="#top-profile"
                                        role="tab" aria-controls="top-profile" aria-selected="false"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-info">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="12" y1="16" x2="12" y2="12"></line>
                                            <line x1="12" y1="8" x2="12" y2="8"></line>
                                        </svg>Đang thực hiện</a>

                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="contact-top-tab" data-toggle="tab" href="#top-contact"
                                        role="tab" aria-controls="top-contact" aria-selected="false"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-check-circle">
                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                        </svg>Hoàn thành</a>
                                </li>
                            </ul>
                        </div>
                        <div class="button-add">
                            {{-- <div class="form-group mb-0 me-0"></div> --}}
                            @if(Auth::user()->hasPermissionTo("Thêm dự án"))
                            <a class="btn btn-primary btn-add" href="{{ route('project.create_project') }}"> <svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-plus-square">
                                    <rect x="3" y="3" width="18" height="18" rx="2"
                                        ry="2"></rect>
                                    <line x1="12" y1="8" x2="12" y2="16"></line>
                                    <line x1="8" y1="12" x2="16" y2="12"></line>
                                </svg>Thêm mới</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content" id="top-tabContent">
                            <div class="tab-pane fade show active " id="top-home" role="tabpanel"
                                aria-labelledby="top-home-tab">
                                <div class="row all">
                                    @foreach ($projectAll->Works as $project)
                                        @if ($project->status == 'Doing')
                                            <div class="col-md-4">
                                                <div class="project-box">
                                                    <div class="container-option">
                                                        <span class="badge badge-primary">Đang thực hiện</span>
                                                        <div class="dropdown d-inline-block show">
                                                            <a class="dropdown-toggle" href="#" role="button"
                                                                id="pendingTask" data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="true">
                                                                <i class='bx bx-dots-horizontal-rounded'></i>
                                                            </a>

                                                            <div class="dropdown-menu right" aria-labelledby="pendingTask"
                                                                style="will-change: transform; position: absolute; transform: translate3d(0px, -109px, 0px); top: 0px; left: 0px;"
                                                                x-placement="top-start">
                                                                <a class="dropdown-item"
                                                                    href="{{ route('project.setting', ['id' => $project->id]) }}"><i
                                                                        class='bx bx-cog'></i> Cài đặt </a><a
                                                                    class="dropdown-item"
                                                                    @if(Auth::user()->hasPermissionTo("Cập nhật dự án"))
                                                                        href="{{ route('project.edit', ['id' => $project->id]) }}"><i
                                                                            class='bx bx-pencil'></i> Chỉnh sửa</a>
                                                                    @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a @if(Auth::user()->hasPermissionTo('Danh sách công việc')) href="{{ route('task.list', ['id' => $project->id]) }}" @endif>
                                                        <h6>{{ $project->name }}</h6>
                                                        <div class="media">
                                                            <img class=" rounded-circle"
                                                                src="{{asset($project->User->avatar)}}"
                                                                alt="" data-original-title="" title="" style="width: 40px;height:40px;">
                                                            <div class="media-body">
                                                                <p>{{ $project->User->name }}</p>
                                                            </div>
                                                        </div>
                                                        <p>{{ $project->detail }}</p>
                                                        <div class="row details">
                                                            <div class="col-6"><span>Danh sách </span></div>
                                                            <div class="col-6 font-primary">{{count($project->level)}}</div>
                                                            <div class="col-6"><span>Thành viên</span></div>
                                                            <div class="col-6 font-primary">{{count($project->dsUser)}}</div>
                                                        </div>
                                                        <div class="customers">
                                                            <ul>
                                                                @php $index=0;@endphp
                                                                @foreach($project->dsUser as $user)
                                                                @php $index++;@endphp
                                                                <li style="display: inline-block">
                                                                    <img
                                                                        class="img-30 rounded-circle"
                                                                        src="{{asset($user->avatar)}}" style="width:30px;height:30px"
                                                                        alt="" >
                                                                </li>
                                                                @if($index == 4)
                                                                    @break
                                                                @endif
                                                                @endforeach
                                                                @php $count=count($project->dsUser) @endphp
                                                                @if($count > 4 )
                                                                <li class="ml-3" style="display: inline-block">
                                                                    <p>+ {{$count-4}} Thành viên</p>
                                                                </li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                        <div class="project-status mt-4">
                                                            <div class="media mb-0">
                                                                <p>{{$project->progress}}%</p>
                                                                <div class="media-body text-end"><span>done</span></div>

                                                            </div>
                                                            <div class="progress" style="height: 5px;">
                                                                
                                                                <div class="progress-bar-animated bg-primary progress-bar-striped"
                                                                    role="progressbar" style="width:{{$project->progress}}%;"
                                                                    aria-valuenow="10" aria-valuemin="0"
                                                                    aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-md-4">
                                                <div class="project-box">
                                                    <div class="container-option">
                                                        <span class="badge badge-primary">Hoàn thành</span>
                                                        <div class="dropdown d-inline-block show">
                                                            <a class="dropdown-toggle" href="#" role="button"
                                                                id="pendingTask" data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="true">
                                                                <i class='bx bx-dots-horizontal-rounded'></i>
                                                            </a>

                                                            <div class="dropdown-menu right" aria-labelledby="pendingTask"
                                                                style="will-change: transform; position: absolute; transform: translate3d(0px, -109px, 0px); top: 0px; left: 0px;"
                                                                x-placement="top-start">
                                                                <a class="dropdown-item"
                                                                    href="{{ route('project.setting', ['id' => $project->id]) }}"><i
                                                                        class='bx bx-cog'></i> Cài đặt </a><a
                                                                    class="dropdown-item"
                                                                    href="{{ route('project.edit', ['id' => $project->id]) }}"><i
                                                                        class='bx bx-pencil'></i> Chỉnh sửa</a>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a @if(Auth::user()->hasPermissionTo("Danh sách công việc")) href="{{ route('task.list', ['id' => $project->id]) }}" @endif>
                                                        <h6>{{ $project->name }}</h6>
                                                        <div class="media">
                                                            <img class=" rounded-circle"
                                                                src="{{asset($project->User->avatar)}}"
                                                                alt="" data-original-title="" title="" style="width: 40px;height:40px;">
                                                            <div class="media-body">
                                                                <p>{{ $project->User->name }}</p>
                                                            </div>
                                                        </div>
                                                        <p>{{ $project->detail }}</p>
                                                        <div class="row details">
                                                            <div class="col-6"><span>Danh sách </span></div>
                                                            <div class="col-6 font-primary">{{count($project->level)}}</div>
                                                            <div class="col-6"><span>Thành viên</span></div>
                                                            <div class="col-6 font-primary">{{count($project->dsUser)}}</div>
                                                        </div>
                                                        <div class="customers">
                                                            <ul>
                                                                @php $index=0;@endphp
                                                                @foreach($project->dsUser as $user)
                                                                @php $index++;@endphp
                                                                <li style="display: inline-block">
                                                                    <img
                                                                        class="img-30 rounded-circle"
                                                                        src="{{asset($user->avatar)}}" style="width:30px;height:30px"
                                                                        alt="" >
                                                                </li>
                                                                @if($index == 4)
                                                                    @break
                                                                @endif
                                                                @endforeach
                                                                @php $count=count($project->dsUser) @endphp
                                                                @if($count > 4 )
                                                                <li class="ml-3" style="display: inline-block">
                                                                    <p>+ {{$count-4}} Thành viên</p>
                                                                </li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                        <div class="project-status mt-4">
                                                            <div class="media mb-0">
                                                                <p>{{$project->progress}}%</p>
                                                                <div class="media-body text-end"><span>done</span></div>

                                                            </div>
                                                            <div class="progress" style="height: 5px;">
                                                                
                                                                <div class="progress-bar-animated bg-primary progress-bar-striped"
                                                                    role="progressbar" style="width:{{$project->progress}}%;"
                                                                    aria-valuenow="10" aria-valuemin="0"
                                                                    aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="tab-pane fade" id="top-profile" role="tabpanel"
                                aria-labelledby="profile-top-tab">
                                <div class="row doing">
                                    @foreach ($projectAll->Works as $project)
                                        @if ($project->status == 'Doing')
                                            <div class="col-md-4">
                                                <div class="project-box">
                                                    <div class="container-option">
                                                        <span class="badge badge-primary">Đang thực hiện</span>
                                                        <div class="dropdown d-inline-block show">
                                                            <a class="dropdown-toggle" href="#" role="button"
                                                                id="pendingTask" data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="true">
                                                                <i class='bx bx-dots-horizontal-rounded'></i>
                                                            </a>

                                                            <div class="dropdown-menu right" aria-labelledby="pendingTask"
                                                                style="will-change: transform; position: absolute; transform: translate3d(0px, -109px, 0px); top: 0px; left: 0px;"
                                                                x-placement="top-start">
                                                                <a class="dropdown-item"
                                                                    href="{{ route('project.setting', ['id' => $project->id]) }}"><i
                                                                        class='bx bx-cog'></i> Cài đặt </a><a
                                                                    class="dropdown-item"
                                                                    href="{{ route('project.edit', ['id' => $project->id]) }}"><i
                                                                        class='bx bx-pencil'></i> Chỉnh sửa</a>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a @if(Auth::user()->hasPermissionTo("Danh sách công việc")) href="{{ route('task.list', ['id' => $project->id]) }}" @endif>
                                                        <h6>{{ $project->name }}</h6>
                                                        <div class="media">
                                                            <img class=" rounded-circle"
                                                                src="{{asset($project->User->avatar)}}"
                                                                alt="" data-original-title="" title="" style="width: 40px;height:40px;">
                                                            <div class="media-body">
                                                                <p>{{ $project->User->name }}</p>
                                                            </div>
                                                        </div>
                                                        <p>{{ $project->detail }}</p>
                                                        <div class="row details">
                                                            <div class="col-6"><span>Danh sách </span></div>
                                                            <div class="col-6 font-primary">{{count($project->level)}}</div>
                                                            <div class="col-6"><span>Thành viên</span></div>
                                                            <div class="col-6 font-primary">{{count($project->dsUser)}}</div>
                                                        </div>
                                                        <div class="customers">
                                                            <ul>
                                                                @php $index=0;@endphp
                                                                @foreach($project->dsUser as $user)
                                                                @php $index++;@endphp
                                                                <li style="display: inline-block">
                                                                    <img
                                                                        class="img-30 rounded-circle"
                                                                        src="{{asset($user->avatar)}}" style="width:30px;height:30px"
                                                                        alt="" >
                                                                </li>
                                                                @if($index == 4)
                                                                    @break
                                                                @endif
                                                                @endforeach
                                                                @php $count=count($project->dsUser) @endphp
                                                                @if($count > 4 )
                                                                <li class="ml-3" style="display: inline-block">
                                                                    <p>+ {{$count-4}} Thành viên</p>
                                                                </li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                        <div class="project-status mt-4">
                                                            <div class="media mb-0">
                                                                <p>{{$project->progress}}%</p>
                                                                <div class="media-body text-end"><span>done</span></div>

                                                            </div>
                                                            <div class="progress" style="height: 5px;">
                                                                
                                                                <div class="progress-bar-animated bg-primary progress-bar-striped"
                                                                    role="progressbar" style="width:{{$project->progress}}%;"
                                                                    aria-valuenow="10" aria-valuemin="0"
                                                                    aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach

                                </div>
                            </div>
                            <div class="tab-pane fade" id="top-contact" role="tabpanel"
                                aria-labelledby="contact-top-tab">
                                <div class="row done">
                                    @foreach ($projectAll->Works as $project)
                                        @if ($project->status == 'Done')
                                            <div class="col-md-4">
                                                <div class="project-box">
                                                    <div class="container-option">
                                                        <span class="badge badge-primary">Hoàn thành</span>
                                                        <div class="dropdown d-inline-block show">
                                                            <a class="dropdown-toggle" href="#" role="button"
                                                                id="pendingTask" data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="true">
                                                                <i class='bx bx-dots-horizontal-rounded'></i>
                                                            </a>
                                                            <div class="dropdown-menu right" aria-labelledby="pendingTask"
                                                                style="will-change: transform; position: absolute; transform: translate3d(0px, -109px, 0px); top: 0px; left: 0px;"
                                                                x-placement="top-start">
                                                                <a class="dropdown-item"
                                                                    href="{{ route('project.setting', ['id' => $project->id]) }}"><i
                                                                        class='bx bx-cog'></i> Cài đặt </a><a
                                                                    class="dropdown-item"
                                                                    href="{{ route('project.edit', ['id' => $project->id]) }}"><i
                                                                        class='bx bx-pencil'></i> Chỉnh sửa</a>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a @if(Auth::user()->hasPermissionTo("Danh sách công việc")) href="{{ route('task.list', ['id' => $project->id]) }}" @endif>
                                                        <h6>{{ $project->name }}</h6>
                                                        <div class="media">
                                                            <img class=" rounded-circle"
                                                                src="{{asset($project->User->avatar)}}"
                                                                alt="" data-original-title="" title="" style="width: 40px;height:40px;">
                                                            <div class="media-body">
                                                                <p>{{ $project->User->name }}</p>
                                                            </div>
                                                        </div>
                                                        <p>{{ $project->detail }}</p>
                                                        <div class="row details">
                                                            <div class="col-6"><span>Danh sách </span></div>
                                                            <div class="col-6 font-primary">{{count($project->level)}}</div>
                                                            <div class="col-6"><span>Thành viên</span></div>
                                                            <div class="col-6 font-primary">{{count($project->dsUser)}}</div>
                                                        </div>
                                                        <div class="customers">
                                                            <ul>
                                                                @php $index=0;@endphp
                                                                @foreach($project->dsUser as $user)
                                                                @php $index++;@endphp
                                                                <li style="display: inline-block">
                                                                    <img
                                                                        class="img-30 rounded-circle"
                                                                        src="{{asset($user->avatar)}}" style="width:30px;height:30px"
                                                                        alt="" >
                                                                </li>
                                                                @if($index == 4)
                                                                    @break
                                                                @endif
                                                                @endforeach
                                                                @php $count=count($project->dsUser) @endphp
                                                                @if($count > 4 )
                                                                <li class="ml-3" style="display: inline-block">
                                                                    <p>+ {{$count-4}} Thành viên</p>
                                                                </li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                        <div class="project-status mt-4">
                                                            <div class="media mb-0">
                                                                <p>{{$project->progress}}%</p>
                                                                <div class="media-body text-end"><span>done</span></div>

                                                            </div>
                                                            <div class="progress" style="height: 5px;">
                                                                
                                                                <div class="progress-bar-animated bg-primary progress-bar-striped"
                                                                    role="progressbar" style="width:{{$project->progress}}%;"
                                                                    aria-valuenow="10" aria-valuemin="0"
                                                                    aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('page-js')
<script>
    var path = "{{ route('project.autoComplete') }}";
    $('input.typeahead').typeahead({
        source: function(terms, process) {
            return $.get(path, {
                terms: terms
            }, function(data) {
                return process(data);
            })
        }
    });
</script>
<script>
    $("#search").on('keypress', function(e) {
            if (e.which == 13) {
                e.preventDefault();
                $(".search").click();
            }
        });
        $("#search").keyup(function(event) {
            if (event.keyCode === 13) {
                $(".search").click();
            }
        });
</script>
<script>
    $(".search").click(function(){
        var formData = new FormData();
        $("#search").map(function(){ formData.append('search', this.value)}).get();
            $.ajax({
                url: "{{ route('project.search') }}",
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
            }).done(function(res) {
                var $_html1 = "";
                var $_html2 = "";
                var $_html3 = ""; 
                res.forEach(function(item) {
                    var url_tasklist = `./du-an/${item.id}/cong-viec`
                    var url_setting = `./du-an/cai-dat/${item.id}`
                    var url_edit = `./du-an/chinh-sua/${item.id}`
                    $avatar = "";
                    var count = 0;
                    item.ds_user.forEach(function(user){
                        $avatar+=`
                        <li style="display: inline-block">
                            <img
                                class="img-30 rounded-circle"
                                src="{{asset('')}}${user.avatar}" style="width:30px;height:30px"
                                alt="" >
                        </li>
                        `;
                    })
                    if(item.status == "Doing"){
                        $_html1 += `
                        <div class="col-md-4">
                            <div class="project-box">
                                <div class="container-option">
                                    <span class="badge badge-primary">Đang thực hiện</span>
                                    <div class="dropdown d-inline-block show">
                                        <a class="dropdown-toggle" href="#" role="button"
                                            id="pendingTask" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="true">
                                            <i class='bx bx-dots-horizontal-rounded'></i>
                                        </a>

                                        <div class="dropdown-menu right" aria-labelledby="pendingTask"
                                            style="will-change: transform; position: absolute; transform: translate3d(0px, -109px, 0px); top: 0px; left: 0px;"
                                            x-placement="top-start">
                                            <a class="dropdown-item"
                                                href="${url_setting}"><i
                                                    class='bx bx-cog'></i> Cài đặt </a><a
                                                class="dropdown-item"
                                                @if(Auth::user()->hasPermissionTo("Cập nhật dự án"))
                                                    href="${url_edit}"><i
                                                        class='bx bx-pencil'></i> Chỉnh sửa</a>
                                                @endif
                                        </div>
                                    </div>
                                </div>
                                <a @if(Auth::user()->hasPermissionTo('Danh sách công việc')) href="${url_tasklist}" @endif>
                                    <h6>${item.name}</h6>
                                    <div class="media">
                                        <img class=" rounded-circle"
                                            src="{{asset('')}}${item.user.avatar}"
                                            alt="" data-original-title="" title="" style="width: 40px;height:40px;">
                                        <div class="media-body">
                                        </div>
                                    </div>
                                    <p>${item.detail}</p>
                                    <div class="row details">
                                        <div class="col-6"><span>Danh sách </span></div>
                                        <div class="col-6 font-primary">${item.level_count}</div>
                                        <div class="col-6"><span>Thành viên</span></div>
                                        <div class="col-6 font-primary">${item.ds_user_count}</div>
                                    </div>
                                    <div class="customers">
                                        <ul>
                                            ${$avatar}
                                        </ul>
                                    </div>
                                    <div class="project-status mt-4">
                                        <div class="media mb-0">
                                            <p>${item.progress}%</p>
                                            <div class="media-body text-end"><span>done</span></div>

                                        </div>
                                        <div class="progress" style="height: 5px;">
                                            
                                            <div class="progress-bar-animated bg-primary progress-bar-striped"
                                                role="progressbar" style="width:${item.progress}%;"
                                                aria-valuenow="10" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        `
                        $_html2+=`<div class="col-md-4">
                            <div class="project-box">
                                <div class="container-option">
                                    <span class="badge badge-primary">Đang thực hiện</span>
                                    <div class="dropdown d-inline-block show">
                                        <a class="dropdown-toggle" href="#" role="button"
                                            id="pendingTask" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="true">
                                            <i class='bx bx-dots-horizontal-rounded'></i>
                                        </a>

                                        <div class="dropdown-menu right" aria-labelledby="pendingTask"
                                            style="will-change: transform; position: absolute; transform: translate3d(0px, -109px, 0px); top: 0px; left: 0px;"
                                            x-placement="top-start">
                                            <a class="dropdown-item"
                                                href="${url_setting}"><i
                                                    class='bx bx-cog'></i> Cài đặt </a><a
                                                class="dropdown-item"
                                                @if(Auth::user()->hasPermissionTo("Cập nhật dự án"))
                                                    href="${url_edit}"><i
                                                        class='bx bx-pencil'></i> Chỉnh sửa</a>
                                                @endif
                                        </div>
                                    </div>
                                </div>
                                <a @if(Auth::user()->hasPermissionTo('Danh sách công việc')) href="${url_tasklist}" @endif>
                                    <h6>${item.name}</h6>
                                    <div class="media">
                                        <img class=" rounded-circle"
                                            src="{{asset('')}}${item.user.avatar}"
                                            alt="" data-original-title="" title="" style="width: 40px;height:40px;">
                                        <div class="media-body">
                                        </div>
                                    </div>
                                    <p>${item.detail}</p>
                                    <div class="row details">
                                        <div class="col-6"><span>Danh sách </span></div>
                                        <div class="col-6 font-primary">${item.level_count}</div>
                                        <div class="col-6"><span>Thành viên</span></div>
                                        <div class="col-6 font-primary">${item.ds_user_count}</div>
                                    </div>
                                    <div class="customers">
                                        <ul>
                                            ${$avatar}
                                        </ul>
                                    </div>
                                    <div class="project-status mt-4">
                                        <div class="media mb-0">
                                            <p>${item.progress}%</p>
                                            <div class="media-body text-end"><span>done</span></div>

                                        </div>
                                        <div class="progress" style="height: 5px;">
                                            
                                            <div class="progress-bar-animated bg-primary progress-bar-striped"
                                                role="progressbar" style="width:${item.progress}%;"
                                                aria-valuenow="10" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>`
                    }else{
                        $_html1 += `
                        <div class="col-md-4">
                            <div class="project-box">
                                <div class="container-option">
                                    <span class="badge badge-primary">Hoàn thành</span>
                                    <div class="dropdown d-inline-block show">
                                        <a class="dropdown-toggle" href="#" role="button"
                                            id="pendingTask" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="true">
                                            <i class='bx bx-dots-horizontal-rounded'></i>
                                        </a>

                                        <div class="dropdown-menu right" aria-labelledby="pendingTask"
                                            style="will-change: transform; position: absolute; transform: translate3d(0px, -109px, 0px); top: 0px; left: 0px;"
                                            x-placement="top-start">
                                            <a class="dropdown-item"
                                                href="${url_setting}"><i
                                                    class='bx bx-cog'></i> Cài đặt </a><a
                                                class="dropdown-item"
                                                @if(Auth::user()->hasPermissionTo("Cập nhật dự án"))
                                                    href="${url_edit}"><i
                                                        class='bx bx-pencil'></i> Chỉnh sửa</a>
                                                @endif
                                        </div>
                                    </div>
                                </div>
                                <a @if(Auth::user()->hasPermissionTo('Danh sách công việc')) href="${url_tasklist}" @endif>
                                    <h6>${item.name}</h6>
                                    <div class="media">
                                        <img class=" rounded-circle"
                                            src="{{asset('')}}${item.user.avatar}"
                                            alt="" data-original-title="" title="" style="width: 40px;height:40px;">
                                        <div class="media-body">
                                        </div>
                                    </div>
                                    <p>${item.detail}</p>
                                    <div class="row details">
                                        <div class="col-6"><span>Danh sách </span></div>
                                        <div class="col-6 font-primary">${item.level_count}</div>
                                        <div class="col-6"><span>Thành viên</span></div>
                                        <div class="col-6 font-primary">${item.ds_user_count}</div>
                                    </div>
                                    <div class="customers">
                                        <ul>
                                            ${$avatar}
                                        </ul>
                                    </div>
                                    <div class="project-status mt-4">
                                        <div class="media mb-0">
                                            <p>${item.progress}%</p>
                                            <div class="media-body text-end"><span>done</span></div>

                                        </div>
                                        <div class="progress" style="height: 5px;">
                                            
                                            <div class="progress-bar-animated bg-primary progress-bar-striped"
                                                role="progressbar" style="width:${item.progress}%;"
                                                aria-valuenow="10" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>`
                        $_html3 += `<div class="col-md-4">
                            <div class="project-box">
                                <div class="container-option">
                                    <span class="badge badge-primary">Hoàn thành</span>
                                    <div class="dropdown d-inline-block show">
                                        <a class="dropdown-toggle" href="#" role="button"
                                            id="pendingTask" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="true">
                                            <i class='bx bx-dots-horizontal-rounded'></i>
                                        </a>

                                        <div class="dropdown-menu right" aria-labelledby="pendingTask"
                                            style="will-change: transform; position: absolute; transform: translate3d(0px, -109px, 0px); top: 0px; left: 0px;"
                                            x-placement="top-start">
                                            <a class="dropdown-item"
                                                href="${url_setting}"><i
                                                    class='bx bx-cog'></i> Cài đặt </a><a
                                                class="dropdown-item"
                                                @if(Auth::user()->hasPermissionTo("Cập nhật dự án"))
                                                    href="${url_edit}"><i
                                                        class='bx bx-pencil'></i> Chỉnh sửa</a>
                                                @endif
                                        </div>
                                    </div>
                                </div>
                                <a @if(Auth::user()->hasPermissionTo('Danh sách công việc')) href="${url_tasklist}" @endif>
                                    <h6>${item.name}</h6>
                                    <div class="media">
                                        <img class=" rounded-circle"
                                            src="{{asset('')}}${item.user.avatar}"
                                            alt="" data-original-title="" title="" style="width: 40px;height:40px;">
                                        <div class="media-body">
                                        </div>
                                    </div>
                                    <p>${item.detail}</p>
                                    <div class="row details">
                                        <div class="col-6"><span>Danh sách </span></div>
                                        <div class="col-6 font-primary">${item.level_count}</div>
                                        <div class="col-6"><span>Thành viên</span></div>
                                        <div class="col-6 font-primary">${item.ds_user_count}</div>
                                    </div>
                                    <div class="customers">
                                        <ul>
                                            ${$avatar}
                                        </ul>
                                    </div>
                                    <div class="project-status mt-4">
                                        <div class="media mb-0">
                                            <p>${item.progress}%</p>
                                            <div class="media-body text-end"><span>done</span></div>

                                        </div>
                                        <div class="progress" style="height: 5px;">
                                            
                                            <div class="progress-bar-animated bg-primary progress-bar-striped"
                                                role="progressbar" style="width:${item.progress}%;"
                                                aria-valuenow="10" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>`
                    }
                    
                });
                $(".all").html("");
                $(".all").html($_html1);
                $(".doing").html("");
                $(".doing").html($_html2);
                $(".done").html("");
                $(".done").html($_html3);
                
            });
    })
</script>
    @include('modules.project.js')
@endsection
@endsection
