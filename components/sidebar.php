<div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1"
             id="tuittuit-sidebar">
            <div class="tuittuit-sidenav-bg offcanvas-body">
                <div class="d-flex flex-column flex-shrink-0 justify-content-between h-100">
                    <!-- Content -->
                     <button class="btn btn-outline-success my-2 my-sm-0" data-bs-toggle="offcanvas"
                        data-bs-target="#tuittuit-sidebar">
                        <i class="bi bi-list"></i>
                    </button>
                    <div>
                        <ul class="nav nav-pills flex-column pt-5">
                            <li class="nav-item">
                                <a class="nav-link fs-5 active" aria-current="page" href="#"><i
                                        class="bi bi-calendar"></i> Recent</a>
                            </li>
                            <li class="nav-item fs-5">
                                <a class="nav-link" href="#"><i class="bi bi-arrow-up-right-square"></i> Trending</a>
                            </li>
                            <li class="nav-item fs-5">
                                <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                            </li>
                        </ul>
                    </div>
                    <!-- User -->
                    <div>
                        <div class="w-90 mb-2 tuittuit-sidenav-fg" style="height: 2px;"></div>
                        <div class="container d-flex flex-row align-items-center">
                            <image class="me-2 rounded-circle" id="userIcon" src="/public/images/default_user.jpg"
                                style="width: 40px; height: 40px;"></image>
                            <h6 class="d-inline-block text-truncate fw-semibold mb-0" id="userName">
                                <?php
                                echo ($_SESSION['user_id'])
                                    ?>
                            </h6>
                            <ul class="nav flex-row">
                                <li class="nav-item">
                                    <a href=<?php echo "/profile/" . $_SESSION['user_id']; ?> class="nav-link fs-3 fw-bold text-decoration-none"><i
                                            class="bi bi-person"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>