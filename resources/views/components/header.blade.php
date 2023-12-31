<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
    <a href="/" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
        <h2 class="m-0 text-primary">
            <img class="rounded-3" style="width: 80px; color: pink" src="{{ asset('storage/img/main-img/logo-examonimy.png') }}" alt="">
            </i>Examonimy</h2>
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            <a href="/"
               class="nav-item nav-link {{request()->is('/')? 'active' : '' }}"
            >Home</a>
            <div class="nav-item dropdown">
                <a
                    href="#"
                    class="nav-link dropdown-toggle
                    {{request()->is('my-exam') ||
                    request()->is('my-result') ? 'active' : '' }}"
                    data-bs-toggle="dropdown"
                >Exams</a>
                <div class="dropdown-menu fade-down m-0">
                    <a href="/my-exam"
                       class="dropdown-item {{request()->is('my-exam')? 'active' : '' }}"
                    >My Exam</a>
                    <a href="/my-result"
                       class="dropdown-item {{request()->is('my-result')? 'active' : '' }}"
                    >My Result</a>
{{--                    <a--}}
{{--                        href="#"--}}
{{--                        class="dropdown-item"--}}
{{--                        data-bs-toggle="dropdown"--}}
{{--                    >Mock tests</a>--}}
{{--                    <div class="dropdown-menu dropdown-submenu">--}}
{{--                            <a href="#"--}}
{{--                               class="dropdown-item"--}}
{{--                            >Toeic</a>--}}
{{--                            <a href="#"--}}
{{--                               class="dropdown-item"--}}
{{--                            >Listening</a>--}}
{{--                            <a href="#"--}}
{{--                               class="dropdown-item"--}}
{{--                            >Reading</a>--}}
{{--                    </div>--}}
                </div>
            </div>
            <a href="/contact"
               class="nav-item nav-link {{request()->is('contact')? 'active' : '' }}"
            >Courses</a>
        @auth()
            @if(auth()->user()->role == 3 || auth()->user()->role == 2)
                <a href="admin/admin-dashboard" class="nav-item nav-link">ADMIN</a>
            @endif
        </div>
        <div class="nav-item dropdown">
            {{-- Avatvar start --}}
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <img src="{{ auth()->user()->avatar ?? asset('storage/img/main-img/team-1.jpg')}}" style="width: 40px; height: 40px; object-fit: cover;" class="rounded-circle shadow-4"
                     alt="Avatar"/> {{auth()->user()->name }}
            </a>
            <div class="dropdown-menu fade-down m-0">
                <a class="dropdown-item" href="/my-result"><i class="fa fa-user"></i> My result</a>
                <form id="form-logout" action="{{route("logout")}}" method="post">
                    @csrf
                </form>
                <a
                    href="javascript:void(0);"
                    onclick="$('#form-logout').submit();"
                    class="dropdown-item"
                    style="color:var(--dark)"
                ><i class="fa fa-arrow-alt-circle-right"></i> Logout</a>
            </div>
            {{-- Avatvar end --}}
        </div>
        @endauth
        </div>
        @guest()
        <a href="{{ route("login") }}" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Join Now<i class="fa fa-arrow-right ms-3"></i></a>
        @endguest
</nav>
