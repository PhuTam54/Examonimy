<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="admin/admin-dashboard" class="brand-link navbar-brand d-flex align-items-center px-4 px-lg-5" style="margin-right: -8px">
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
                <li class="nav-item {{ request()->is('admin/admin-dashboard') ? 'menu-open' : '' }}">
                    <a
                        href="admin/admin-dashboard"
                        class="nav-link
                                {{request()->is('admin/admin-dashboard') ? 'active' : '' }}"
                    >
                        <i class="fa fa-chart-bar nav-icon"></i>
                        <p>My Dashboard</p>
                    </a>
                </li>
                <li class="nav-item {{request()->is('admin/exam-add') || request()->is('admin/admin-exam') || request()->is('admin/exam-trash') ? 'menu-open' : '' }}">
                    <a
                        href="admin/admin-dashboard"
                        class="nav-link
                        {{request()->is('admin/exam-add') || request()->is('admin/admin-exam') || request()->is('admin/exam-trash') ? 'active' : '' }}"
                    >
                        <i class="nav-icon fas fa-graduation-cap"></i>
                        <p>
                            Exam management
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="admin/admin-exam" class="nav-link {{request()->is('admin/admin-exam') ? 'active' : '' }}">
                                <i class="fa fa-eye nav-icon"></i>
                                <p>View all exams</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="admin/exam-add" class="nav-link {{ request()->is('admin/exam-add') ? 'active' : '' }}">
                                <i class="fa fa-plus nav-icon"></i>
                                <p>Add a new exam</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="admin/admin-result" class="nav-link {{request()->is('admin/admin-result') ? 'active' : '' }}">
                        <i class="fa fa-clipboard nav-icon"></i>
                        <p>Results</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="admin/admin-enrollment" class="nav-link {{ request()->is('admin/admin-enrollment') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-graduation-cap"></i>
                        <p>Enrollments</p>
                    </a>
                </li>
                <li class="nav-item {{request()->is('admin/user-add') || request()->is('admin/admin-user') || request()->is('admin/user-trash') ? 'menu-open' : '' }}">
                    <a
                        href="admin/admin-dashboard"
                        class="nav-link
                        {{request()->is('admin/user-add') || request()->is('admin/admin-user') || request()->is('admin/user-trash') ? 'active' : '' }}"
                    >
                        <i class="fa fa-user-astronaut nav-icon"></i>
                        <p>
                            User management
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="admin/admin-user" class="nav-link {{request()->is('admin/admin-user') ? 'active' : '' }}">
                                <i class="fa fa-eye nav-icon"></i>
                                <p>View all users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="admin/user-add" class="nav-link {{ request()->is('admin/user-add') ? 'active' : '' }}">
                                <i class="fa fa-plus nav-icon"></i>
                                <p>Add a new user</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{request()->is('admin/examquestion-add') || request()->is('admin/admin-examquestion') || request()->is('admin/examquestion-trash') ? 'menu-open' : '' }}">
                    <a
                        href="admin/admin-dashboard"
                        class="nav-link
                        {{request()->is('admin/examquestion-add') || request()->is('admin/admin-examquestion') || request()->is('admin/examquestion-trash') ? 'active' : '' }}"
                    >
                        <i class="fa fa-folder nav-icon"></i>
                        <p>
                            Exam Questions
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="admin/admin-examquestion" class="nav-link {{request()->is('admin/admin-examquestion') ? 'active' : '' }}">
                                <i class="fa fa-eye nav-icon"></i>
                                <p>View all Exam Questions</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="admin/examquestion-add" class="nav-link {{ request()->is('admin/examquestion-add') ? 'active' : '' }}">
                                <i class="fa fa-plus nav-icon"></i>
                                <p>Add a new ExamQuestion</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{request()->is('admin/question-add') || request()->is('admin/admin-question') || request()->is('admin/question-trash') ? 'menu-open' : '' }}">
                    <a
                        href="admin/admin-dashboard"
                        class="nav-link
                        {{request()->is('admin/question-add') || request()->is('admin/admin-question') || request()->is('admin/question-trash') ? 'active' : '' }}"
                    >
                        <i class="fa fa-question-circle nav-icon"></i>
                        <p>
                            Q&A management
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="admin/admin-question" class="nav-link {{request()->is('admin/admin-question') ? 'active' : '' }}">
                                <i class="fa fa-eye nav-icon"></i>
                                <p>View all Q&A</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="admin/question-add" class="nav-link {{ request()->is('admin/question-add') ? 'active' : '' }}">
                                <i class="fa fa-plus nav-icon"></i>
                                <p>Add a new Q&A</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{request()->is('admin/subject-add') || request()->is('admin/admin-subject') || request()->is('admin/subject-trash') ? 'menu-open' : '' }}">
                    <a
                        href="admin/admin-dashboard"
                        class="nav-link
                        {{request()->is('admin/subject-add') || request()->is('admin/admin-subject') || request()->is('admin/subject-trash') ? 'active' : '' }}"
                    >
                        <i class="fa fa-book nav-icon"></i>
                        <p>
                            Subject management
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="admin/admin-subject" class="nav-link {{request()->is('admin/admin-subject') ? 'active' : '' }}">
                                <i class="fa fa-eye nav-icon"></i>
                                <p>View all subjects</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="admin/subject-add" class="nav-link {{ request()->is('admin/subject-add') ? 'active' : '' }}">
                                <i class="fa fa-plus nav-icon"></i>
                                <p>Add a new subject</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{request()->is('admin/course-add') || request()->is('admin/admin-courses') || request()->is('admin/course-trash') ? 'menu-open' : '' }}">
                    <a
                        href="admin/admin-dashboard"
                        class="nav-link
                        {{request()->is('admin/course-add') || request()->is('admin/admin-courses') || request()->is('admin/course-trash') ? 'active' : '' }}"
                    >
                        <i class="fa fa-bookmark nav-icon"></i>
                        <p>
                            Course management
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="admin/admin-courses" class="nav-link {{request()->is('admin/admin-courses') ? 'active' : '' }}">
                                <i class="fa fa-eye nav-icon"></i>
                                <p>View all courses</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="admin/course-add" class="nav-link {{ request()->is('admin/course-add') ? 'active' : '' }}">
                                <i class="fa fa-plus nav-icon"></i>
                                <p>Add a new course</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{request()->is('admin/classroom-add') || request()->is('admin/admin-classroom') || request()->is('admin/classroom-trash') ? 'menu-open' : '' }}">
                    <a
                        href="admin/admin-dashboard"
                        class="nav-link
                        {{request()->is('admin/classroom-add') || request()->is('admin/admin-classroom') || request()->is('admin/classroom-trash') ? 'active' : '' }}"
                    >
                        <i class="fa fa-house-user nav-icon"></i>
                        <p>
                            Class management
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="admin/admin-classroom" class="nav-link {{request()->is('admin/admin-classroom') ? 'active' : '' }}">
                                <i class="fa fa-eye nav-icon"></i>
                                <p>View all classes</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="admin/classroom-add" class="nav-link {{ request()->is('admin/classroom-add') ? 'active' : '' }}">
                                <i class="fa fa-plus nav-icon"></i>
                                <p>Add a new class</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-header text-center" style="margin-left: -10px"><br><br><br><br>Phu Tam 54</li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
