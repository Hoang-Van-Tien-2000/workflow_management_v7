@php
$menuItems = [
    [
        'title' => 'DashBoard',
        'icon' => 'bx bxs-dashboard',
        'module' => 'dashboard',
        'link' => 'dashboard.list',
    ],
    [
        'title' => 'Thống kê',
        'icon' => 'bx-user',
        'module' => 'statistic',
        'sub-menu' => [
            [
                'title' => 'Công việc nhân viên',
                'module' => 'statistic.task',
                'link' => 'statistic.task.list',
                'sub-module' => 'statistic',
            ],
            [
                'title' => 'Thống kê khách hàng',
                'module' => 'statistic.customer',
                'link' => 'statistic.customer.list',
                'sub-module' => 'statistic',
            ],
        ],
    ],
    [
        'title' => 'Dự án',
        'icon' => 'bx bx-shape-square',
        'module' => 'project',
        'link' => 'project.list',
        'permission' => 'Danh sách dự án'
    ],
    [
        'title' => 'Quản lý hợp đồng',
        'icon' => 'bx bx-book-bookmark',
        'module' => 'contracts',
        'link' => 'contracts.list_user',
        'permission' => 'Danh sách hợp đồng của từng nhân viên'
    ],
    [
        'title' => 'Quản lý khách hàng',
        'icon' => 'bx bxs-user-account',
        'module' => 'customer',
        'link' => 'customer.list',
        'permission' => 'Danh sách khách hàng'
    ],
    [
        'title' => 'Quản lý nhân sự',
        'icon' => 'bx-group',
        'module' => 'user',
        'permission' => 'Danh sách nhân viên',
        'sub-menu' => [
            [
                'title' => 'Quản lý nhân viên',
                'link' => 'user.list',
                'sub-module' => 'user',
                'permission' => 'Danh sách nhân viên'
            ],
            [
                'title' => 'Phân Quyền',
                'link' => 'role.list',
                'sub-module' => 'role',
                'permission' => 'Danh sách chức vụ'
            ],
            [
                'title' => 'Phòng ban',
                'link' => 'department.list',
                'sub-module' => 'department',
                'permission' => 'Danh sách phòng ban'
            ],
        ],
    ],
    [
        'title' => 'Quản lý lương',
        'icon' => 'bx-money-withdraw',
        'module' => 'pay_salaries',
        'permission' => 'Danh sách bảng lương',
        'sub-menu' => [
            [
                'title' => 'Bảng lương',
                'link' => 'pay_salaries.list',
                'sub-module' => 'pay_salaries',
                'permission' => 'Danh sách bảng lương'
            ],
            [
                'title' => 'Tạm ứng và phụ cấp',
                'link' => 'advance_allowance.list',
                'sub-module' => 'advance_allowance',
                'permission' => 'Danh sách tạm ứng, phụ cấp'
            ],
            [
                'title' => 'Khen thưởng',
                'link' => 'bonus.list',
                'sub-module' => 'bonus',
                'permission' => 'Danh sách khen thưởng'
            ],
            [
                'title' => 'Xử phạt',
                'link' => 'discipline.list',
                'sub-module' => 'discipline',
                'permission' => 'Danh sách xử phạt'
            ],
        ],
    ],
    [
        'title' => 'Quản lý chấm công',
        'icon' => 'bx bx-notepad',
        'module' => 'Timesheet',
        'permission' => 'Danh sách chấm công',
        'sub-menu' => [
            [
                'title' => 'Danh sách chấm công',
                'link' => 'Timesheet.list',
                'sub-module' => 'Timesheet',
                'permission' => 'Danh sách chấm công'
            ],
            [
                'title' => 'Duyệt chấm công',
                'link' => 'Timesheet.list_timesheet',
                'sub-module' => 'Timesheet',
                'permission' => 'Duyệt chấm công'
            ],
        ],
    ],
    [
        'title' => 'Nghĩ phép',
        'icon' => 'bx bx-edit',
        'module' => 'annual_leave',
        'link' => 'annual_leave.list',
        'permission' => 'Danh sách nghĩ phép'
    ],
    [
        'title' => 'Cấu hình',
        'icon' => 'bx bx bx-cog',
        'module' => 'config',
        'link' => 'config.edit',
        'permission' => 'Quản lý cấu hình'
    ],
];
@endphp
<div class="overlay"></div>
<div class="search-overlay"></div>
<div class="sidebar-wrapper sidebar-theme">
    <div class="theme-logo">
        <a href="{{ route('dashboard.list') }}">
            <img @if(auth()->user()->avatar == null || file_exists(public_path(auth()->user()->avatar)) == false) src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg" @else src="{{URL::to('/')}}/{{auth()->user()->avatar}}" @endif class="navbar-logo" alt="logo">
            <span class="admin-logo"><span></span></span>
        </a>
    </div>
    <div class="sidebarCollapseFixed">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="feather feather-arrow-left">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
    </div>

    <nav id="compactSidebar">
        <ul class="menu-categories">
            @foreach ($menuItems as $menu)
                @if (empty($menu['sub-menu']))
                    @if(empty($menu['permission']))
                        <li class="menu menu-single">
                            <a href="{{ route($menu['link']) }}"
                                @if ($menu['module'] == $module) data-active="true" @endif class="menu-toggle">
                                <div class="base-menu">
                                    <div class="base-icons">
                                        <i class="bx {{ $menu['icon'] }}"></i>
                                    </div>
                                    <span>{{ $menu['title'] }}</span>
                                </div>
                            </a>
                        </li>
                    @elseif(Auth::user()->hasPermissionTo($menu['permission']))
                    {
                        <li class="menu menu-single">
                            <a href="{{ route($menu['link']) }}"
                                @if ($menu['module'] == $module) data-active="true" @endif class="menu-toggle">
                                <div class="base-menu">
                                    <div class="base-icons">
                                        <i class="bx {{ $menu['icon'] }}"></i>
                                    </div>
                                    <span>{{ $menu['title'] }}</span>
                                </div>
                            </a>
                        </li>
                    }
                    @endif
                @else
                    @if(!empty($menu['permission']) && $menu['permission'] == 'Danh sách nhân viên')
                        @if(Auth::user()->hasPermissionTo($menu['permission']) || Auth::user()->hasPermissionTo('Danh sách chức vụ') || Auth::user()->hasPermissionTo('Danh sách phòng ban'))
                        <li class="menu menu-single menu-dropdown">
                            <button @if ($menu['module'] == $module) data-active="true" @endif type="button"
                                class="btn dropdown-toggle btn-dropdown link " data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" style="border: none">
                                <div class="base-menu">
                                    <div class="base-icons">
                                        <i class="bx {{ $menu['icon'] }}"></i>
                                    </div>
                                    <span>{{ $menu['title'] }}</span>
                                    <div class="icon-dropdown">
                                        <i class='bx bx-chevron-down'></i>
                                    </div>
                                </div>
                            </button>
                            <ul class="submenu-dropdown">
                                @foreach ($menu['sub-menu'] as $sub)
                                @if(Auth::user()->hasPermissionTo($sub['permission']))
                                    <li @if (!empty($subModule) && $subModule == $sub['sub-module']) class="mm-active" @endif><a
                                            href="{{ route($sub['link']) }}"><i
                                                class='bx bx-right-arrow-alt'></i>{{ $sub['title'] }}</a></li>
                                @endif
                                @endforeach
                            </ul>
                        </li>
                        @endif
                    @elseif(!empty($menu['permission']) && $menu['permission'] == 'Danh sách bảng lương')
                        @if(Auth::user()->hasPermissionTo($menu['permission']) || Auth::user()->hasPermissionTo('Danh sách tạm ứng, phụ cấp') || Auth::user()->hasPermissionTo('Danh sách khen thưởng') || Auth::user()->hasPermissionTo('Danh sách xử phạt'))
                            <li class="menu menu-single menu-dropdown">
                                <button @if ($menu['module'] == $module) data-active="true" @endif type="button"
                                    class="btn dropdown-toggle btn-dropdown link " data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false" style="border: none">
                                    <div class="base-menu">
                                        <div class="base-icons">
                                            <i class="bx {{ $menu['icon'] }}"></i>
                                        </div>
                                        <span>{{ $menu['title'] }}</span>
                                        <div class="icon-dropdown">
                                            <i class='bx bx-chevron-down'></i>
                                        </div>
                                    </div>
                                </button>
                                <ul class="submenu-dropdown">
                                    @foreach ($menu['sub-menu'] as $sub)
                                    @if(Auth::user()->hasPermissionTo($sub['permission']))
                                        <li @if (!empty($subModule) && $subModule == $sub['sub-module']) class="mm-active" @endif><a
                                                href="{{ route($sub['link']) }}"><i
                                                    class='bx bx-right-arrow-alt'></i>{{ $sub['title'] }}</a></li>
                                    @endif
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @elseif( !empty($menu['permission']) && $menu['permission'] == 'Danh sách chấm công')
                        @if(Auth::user()->hasPermissionTo($menu['permission']) || Auth::user()->hasPermissionTo('Duyệt chấm công'))
                            <li class="menu menu-single menu-dropdown">
                                <button @if ($menu['module'] == $module) data-active="true" @endif type="button"
                                    class="btn dropdown-toggle btn-dropdown link " data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false" style="border: none">
                                    <div class="base-menu">
                                        <div class="base-icons">
                                            <i class="bx {{ $menu['icon'] }}"></i>
                                        </div>
                                        <span>{{ $menu['title'] }}</span>
                                        <div class="icon-dropdown">
                                            <i class='bx bx-chevron-down'></i>
                                        </div>
                                    </div>
                                </button>
                                <ul class="submenu-dropdown">
                                    @foreach ($menu['sub-menu'] as $sub)
                                    @if(Auth::user()->hasPermissionTo($sub['permission']))
                                        <li @if (!empty($subModule) && $subModule == $sub['sub-module']) class="mm-active" @endif><a
                                                href="{{ route($sub['link']) }}"><i
                                                    class='bx bx-right-arrow-alt'></i>{{ $sub['title'] }}</a></li>
                                    @endif
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @else
                        <li class="menu menu-single menu-dropdown">
                            <button @if ($menu['module'] == $module) data-active="true" @endif type="button"
                                class="btn dropdown-toggle btn-dropdown link " data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" style="border: none">
                                <div class="base-menu">
                                    <div class="base-icons">
                                        <i class="bx {{ $menu['icon'] }}"></i>
                                    </div>
                                    <span>{{ $menu['title'] }}</span>
                                    <div class="icon-dropdown">
                                        <i class='bx bx-chevron-down'></i>
                                    </div>
                                </div>
                            </button>
                            <ul class="submenu-dropdown">
                                @foreach ($menu['sub-menu'] as $sub)
                                    <li @if (!empty($subModule) && $subModule == $sub['sub-module']) class="mm-active" @endif><a
                                            href="{{ route($sub['link']) }}"><i
                                                class='bx bx-right-arrow-alt'></i>{{ $sub['title'] }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endif
            @endforeach
            <li class="menu menu-single">
                <button id="buttonCheckout" href="" class="menu-toggle">
                    <div class="base-menu">
                        <div class="base-icons">
                            <i class='bx bx-list-check'></i>
                        </div>
                        <span>Check out</span>
                    </div>
                </button>
            </li>

        </ul>
    </nav>
</div>
