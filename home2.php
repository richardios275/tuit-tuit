<?php
session_start();
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("Location: login.php");
}
$username = $_SESSION['user_id'];
?>

<!doctype html>
<html lang="en">

<head>
    <title>Home | Tuit Tuit</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-sm navbar-light bg-light">
            <div class="container">

                <div>
                    <button class="btn btn-outline-success my-2 my-sm-0" data-bs-toggle="collapse" href="#sidebar"
                        aria-expanded="false" aria-controls="sidebar">
                        🍔
                    </button>
                    <a class="navbar-brand mx-2" href="#">Tuit Tuit</a>
                </div>

                <div class="navbar-nav">
                    <input class="form-control me-sm-2" type="text" placeholder="Search" />
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
                        🔎
                    </button>
                </div>
                <div class="navbar-nav">
                    <form class="d-flex my-2 my-lg-0">

                        <!-- Modal trigger button -->
                        <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
                            data-bs-target="#uploadModal">
                            Upload
                        </button>
                    </form>
                </div>
            </div>
        </nav>

    </header>
    <main>
        <!-- Upload modal -->
        <div class="modal fade" id="uploadModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
            role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">
                            Upload
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="postUploadForm" method="POST" action="actions/post_action.php">
                            <div class="mb-3">
                                <label for="postBody" class="form-label">Post Content</label>
                                <textarea class="form-control" id="postBody" name="body" rows="5"
                                    placeholder="What's on your mind?" required></textarea>
                            </div>

                            <input type="hidden" id="parentId" name="parent_id" value="0">

                            <input type="hidden" id="postStatus" name="status" value="active">

                            <div class="mb-3">
                                <label for="postImage" class="form-label">Add Image (Optional)</label>
                                <input class="form-control" type="file" id="postImage" name="image" accept="image/*">
                                <div class="form-text">Max file size: 5MB</div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" form="postUploadForm" class="btn btn-primary">Post</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Container with Flex -->
        <div class="container-fluid">
            <div class="row">

                <!-- Sidebar Column (Collapsible) -->
                <div class="col-auto p-0">
                    <div class="collapse collapse-horizontal show" id="sidebar"
                        style="background-color: rgb(164, 103, 41); min-height: 100vh;">
                        <div class="sidebar-content p-3" style="width: 300px;">
                            <!-- Sidebar Header -->
                            <div class="sidebar-header mb-4">
                                <h2 id="username" class="text-white"><?php echo $username ?></h2>
                                <a href="/actions/logout_action.php"> <button class="btn btn-primary">Logout</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section style="background-color: rgb(124, 240, 139);">
            <!-- Post area -->
            <div class="m-1 container">
                <div>

                </div>

            </div>
        </section>

    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>