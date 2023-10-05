<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/admin-dashboard" class="brand-link">
        <img src="storage/img/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Examonimy</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="storage/img/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="admin/admin-dashboard" class="d-block">Phú Tâm</a>
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
                    {{request()->is('admin/admin-table1') || request()->is('admin/admin-table2') || request()->is('admin/admin-table3') ? 'menu-open' : '' }}"
                >
                    <a
                        href="admin/admin-dashboard"
                        class="nav-link
                        {{request()->is('admin/admin-table1') || request()->is('admin/admin-table2') || request()->is('admin/admin-table3') ? 'active' : '' }}"
                    >
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Tables
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="admin/admin-table1" class="nav-link {{request()->is('admin/admin-table1') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Orders</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="admin/admin-table2" class="nav-link {{request()->is('admin/admin-table2') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Products</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="admin/admin-table3" class="nav-link {{request()->is('admin/admin-table3') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Categories</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-header">EXAMPLES</li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
