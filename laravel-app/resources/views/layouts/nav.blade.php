<nav class="navbar navbar-expand-lg bg-body-tertiary" style="background-color: #e3f2fd;">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Navbar</a>
        <!--        <a class="navbar-brand" href="#">-->
        <!--            <img src="/docs/5.3/assets/brand/bootstrap-logo.svg" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">-->
        <!--            Bootstrap-->
        <!--        </a>-->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Dropdown
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                </li>

                <?php
                if (isset($_SESSION['auth'])) :
                    ?>
                <li class="nav-item">
                    <a class="nav-link" href="?page=product&action=logout">Logout</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?page=product&action=changePassword">Change password</a>
                </li>
                <?php else:?>
                <li class="nav-item">
                    <a class="nav-link" href="?page=product&action=login">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?page=product&action=registration">Registration</a>
                </li>
                <?php endif;?>
                <li class="nav-item">
                    <a class="nav-link" href="#">Cart<span class="badge text-bg-secondary">0</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/about-us">About us</a>
                </li>
            </ul>
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>
