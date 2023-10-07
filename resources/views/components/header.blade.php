<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
    <a href="/" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
        <h2 class="m-0 text-primary"><i class="fa fa-book me-3"></i>Examonimy</h2>
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            <a href="/"
               class="nav-item nav-link {{request()->is('/')? 'active' : '' }}"
            >Home</a>
            <a href="/about"
               class="nav-item nav-link {{request()->is('about')? 'active' : '' }}"
            >About</a>
            <a href="/courses"
               class="nav-item nav-link {{request()->is('courses')? 'active' : '' }}"
            >Courses</a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                <div class="dropdown-menu fade-down m-0">
                    <a href="/team"
                       class="dropdown-item {{request()->is('team')? 'active' : '' }}"
                    >Our Team</a>
                    <a href="/testimonial"
                       class="dropdown-item {{request()->is('testimonial')? 'active' : '' }}"
                    >Testimonial</a>
                    <a href="/404"
                       class="dropdown-item {{request()->is('404')? 'active' : '' }}"
                    >404 Page</a>
                </div>
            </div>
            <a href="/contact"
               class="nav-item nav-link {{request()->is('contact')? 'active' : '' }}"
            >Contact</a>
        @auth()
            <a href="admin/admin-dashboard" class="nav-item nav-link">ADMIN</a>
        </div>
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fa fa-user"></i> {{auth()->user()->name}}
            </a>
            <div class="dropdown-menu fade-down m-0">
                <form id="form-logout" action="{{route("logout")}}" method="post">
                    @csrf
                </form>
                <a
                    href="javascript:void(0);"
                    onclick="$('#form-logout').submit();"
                    class="dropdown-item"
                    style="color:var(--dark)"
                >
                    <i class="fa fa-arrow-circle-o-right"></i>Logout</a>
                <a href="404" class="dropdown-item">404 Page</a>
            </div>
        </div>
        @endauth
        </div>
        @guest()
{{--                <a href=""><i class="fa fa-user"></i> Login</a>--}}
{{--                <a href="{{ route("register") }}"><i class="fa fa-user"></i> Register</a>--}}
        <a href="{{ route("login") }}" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Join Now<i class="fa fa-arrow-right ms-3"></i></a>
        @endguest
    </div>
</nav>
