<nav class="navbar navbar-expand-sm navbar-light bg-light sticky-top" tabindex="-1">
    <div class="container-fluid">

        <div>
            <button class="btn btn-outline-success my-2 my-sm-0" data-bs-toggle="offcanvas"
                data-bs-target="#tuittuit-sidebar">
                <i class="bi bi-list"></i>
            </button>
            <a class="navbar-brand mx-2" href="#">
                <img src="/public/svg/logo.svg" alt="Tuit Tuit" height="30" background-color="">
            </a>
        </div>

        <form class="navbar-nav" method="GET" action="home2.php">

            <!-- search bar -->
            <input class="form-control me-sm-2" type="text" placeholder="Search" name="search" value="" />
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
                <i class="bi bi-search"></i>
            </button>

        </form>
        <div class="navbar-nav">
            <form class="d-flex my-2 my-lg-0">
                <!-- Post button -->
                <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
                    data-bs-target="#uploadModal">
                    Post
                </button>
            </form>
        </div>
    </div>
</nav>