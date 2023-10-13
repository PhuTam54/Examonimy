<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/admin-dashboard" class="brand-link navbar-brand d-flex align-items-center px-4 px-lg-5">
{{--        <img src="storage/img/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">--}}
{{--        <span class="brand-text font-weight-light">Examonimy</span>--}}
{{--        <h3 class="m-0" style="color: #c2c7d0"><i class="fa fa-book me-3" style="margin: 0 10px 0 -16px"></i>Examonimy</h3>--}}
        <h3 class="" style="color: #c2c7d0; margin: 0 0 0 -30px">
            <img class="rounded-3" style="width: 55px;" src="{{ asset('storage/img/main-img/logo-examonimy.png') }}" alt=""/>
            </i>Examonimy</h3>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{auth()->user()->avatar}}" style="width: 40px;" class="img-circle elevation-2" alt="User Image">
{{--                <img src="" class="rounded-3" style="width: 50px;"--}}
{{--                     alt="Avatar"/> {{auth()->user()->name }}--}}
            </div>
            <div class="info">
                <a href="admin/admin-dashboard" class="d-block">{{auth()->user()->name}}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li
                    class="nav-item
                    {{ request()->is('admin/admin-dashboard') ||
                      request()->is('admin/admin-dashboard2') ||
                      request()->is('admin/admin-dashboard3')
                      ? 'menu-open' : '' }}"
                >
                    <a
                        href="admin/admin-dashboard"
                        class="nav-link
                        {{request()->is('admin/admin-dashboard') || request()->is('admin/admin-dashboard2') || request()->is('admin/admin-dashboard') ? 'active' : '' }}"
                    >
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a
                                href="admin/admin-dashboard"
                                class="nav-link
                                {{request()->is('admin/admin-dashboard') || request()->is('admin/admin-dashboard2') || request()->is('admin/admin-dashboard3') ? 'active' : '' }}"
                            >
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dashboard v1</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="admin/admin-dashboard" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dashboard v2</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="admin/admin-dashboard" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dashboard v3</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li
                    class="nav-item
                    {{request()->is('admin/admin-exam') ||
                        request()->is('admin/admin-subject') ||
                        request()->is('admin/admin-courses') ||
                        request()->is('admin/admin-question') ||
                        request()->is('admin/admin-classroom') ||
                        request()->is('admin/admin-result') ||
                        request()->is('admin/admin-user') ? 'menu-open' : '' }}"
                >
                    <a
                        href="admin/admin-dashboard"
                        class="nav-link
                        {{request()->is('admin/admin-exam') ||
                        request()->is('admin/admin-subject') ||
                        request()->is('admin/admin-courses') ||
                        request()->is('admin/admin-question') ||
                        request()->is('admin/admin-classroom') ||
                        request()->is('admin/admin-result') ||
                        request()->is('admin/admin-user') ? 'active' : '' }}"
                    >
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Tables
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="admin/admin-exam" class="nav-link {{request()->is('admin/admin-exam') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Exams</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="admin/admin-subject" class="nav-link {{request()->is('admin/admin-subject') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Subjects</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="admin/admin-courses" class="nav-link {{request()->is('admin/admin-courses') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Courses</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="admin/admin-question" class="nav-link {{request()->is('admin/admin-question') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Questions</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="admin/admin-classroom" class="nav-link {{request()->is('admin/admin-classroom') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Classes</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="admin/admin-result" class="nav-link {{request()->is('admin/admin-result') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Exam Results</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="admin/admin-user" class="nav-link {{request()->is('admin/admin-user') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Users</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-header">Phu Tam 54</li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
