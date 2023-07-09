<div class="header-container">
    <header class="header navbar navbar-expand-sm">
        <div class="d-flex">
            <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom">
                <div class="bt-menu-trigger">
                    <span></span>
                </div>
            </a>
            <div class="page-header">
                <div class="page-title">
                    <h3>{{ $breadcrumb['page'] }}</h3>
                </div>
            </div>
        </div>

        <div class="header-actions">
            @if($module == "project")
            <div class="row">
                <div class="col-md-12">
                    <form method="post">
                        <div class="form-group">
                            <input id="search" name="search" type="text" placeholder="Tìm kiếm dự án"
                                class="form-control typeahead" required="">
                            <button type="button" class="btn-primary search"><i
                                    class='bx bx-search-alt-2'></i></button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
            {{-- <div class="nav-item dropdown language-dropdown more-dropdown">
                <div class="dropdown custom-dropdown-icon">
                    <a class="dropdown-toggle btn" href="#" role="button" id="customDropdown"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img
                            src="{{ asset('assets/img/flag-ca2.svg') }}" class="flag-width"
                            alt="flag"><span>English</span> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg></a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="customDropdown">
                        <a class="dropdown-item" data-img-value="flag-de3" data-value="German"
                            href="javascript:void(0);"><img src="{{ asset('assets/img/flag-de3.svg') }}"
                                class="flag-width" alt="flag"> German</a>
                        <a class="dropdown-item" data-img-value="flag-sp" data-value="Spanish"
                            href="javascript:void(0);"><img src="{{ asset('assets/img/flag-sp.svg') }}"
                                class="flag-width" alt="flag"> Spanish</a>
                        <a class="dropdown-item" data-img-value="flag-fr3" data-value="French"
                            href="javascript:void(0);"><img src="{{ asset('assets/img/flag-fr3.svg') }}"
                                class="flag-width" alt="flag"> French</a>
                        <a class="dropdown-item" data-img-value="flag-ca2" data-value="English"
                            href="javascript:void(0);"><img src="{{ asset('assets/img/flag-ca2.svg') }}"
                                class="flag-width" alt="flag"> English</a>
                    </div>
                </div>
            </div> --}}

            <div class="toggle-notification-bar">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-bell">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                </svg>
            </div>
            <div class="dropdown d-inline-block show button-option">
                <a class="dropdown-toggle " href="#" role="button" id="pendingTask" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="true">
                    <i class='bx bxs-brightness'></i>
                </a>

                <div class="dropdown-menu right custom" aria-labelledby="pendingTask"
                    style="will-change: transform; position: absolute; transform: translate3d(0px, -109px, 0px); top: 0px; left: 0px;"
                    x-placement="top-start">
                    <a href="{{ route('profile.list') }}" class="dropdown-item"><i class='bx bx-user'></i>Thông tin
                        tài khoản</a>
                    <a href="{{ route('logout') }}" class="dropdown-item"><i class='bx bx-log-in'></i>Đăng xuất</a>
                </div>
            </div>
        </div>
    </header>
</div>
