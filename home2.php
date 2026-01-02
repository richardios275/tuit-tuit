<?php
session_start();
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("Location: login.php");
}
$username = $_SESSION['user_id'];

if(isset($_SESSION["search"])){
    $search=$_SESSION["search"];
}else{
    echo("this is empty line");
    $search="";
}
unset($_SESSION["search"]);
echo("your search: ".$search);

$pdo=new PDO('mysql:host=localhost;port=3306;dbname=tuituit','root', '');
$stmt = $pdo->query("SELECT * FROM posts");
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->query("Select * from post_media");
$medias = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!doctype html>
<html lang="en">

<head>
    <title>Home | Tuit Tuit</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.3.2 -->
    <link rel="stylesheet" href="public/css/bootstrap.css">


    <!-- Bootstrap Icons v1.31.1 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- TuitTuit CSS -->
    <link rel="stylesheet" href="public/css/tuituit.css">
</head>

<style>
    .post-squares {
        height: fit-content;
        margin: 20px;
        padding: 10px;
        background-color: white;
        box-sizing: border-box;
    }

    .image-preview {
        height: 200px;
        margin: 10px;

    }

    .image-preview-container {
        overflow-x: scroll;
        overflow-y: hidden;
        white-space: nowrap;
        contain: size;
        height: 235px;
        margin-top: 10px;
    }
</style>

<body>
    <header>
        <nav class="navbar navbar-expand-sm navbar-light bg-light sticky-top" tabindex="-1">
            <div class="container-fluid">

                <div>
                    <button class="btn btn-outline-success my-2 my-sm-0" data-bs-toggle="offcanvas" data-bs-target="#tuittuit-sidebar">
                        <i class="bi bi-list"></i>
                    </button>
                    <a class="navbar-brand mx-2" href="#">
                        <img src="public/svg/logo.svg" alt="Tuit Tuit" height="30" background-color="">
                    </a>
                </div>

                <form class="navbar-nav" method="post">

                    <!-- search bar -->
                    <input class="form-control me-sm-2" type="text" placeholder="Search" name="key" value=""/>
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

    </header>
    <main>
        <!-- Sidebar -->
        <div class="offcanvas offcanvas-start show mt-5" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1"
            id="tuittuit-sidebar">
            <div class="tuittuit-sidenav-bg offcanvas-body">
                <div class="d-flex flex-column flex-shrink-0 justify-content-between h-100">
                    <!-- Content -->

                    <div>
                        <ul class="nav nav-pills flex-column pt-5">
                            <li class="nav-item">
                                <a class="nav-link fs-5 active" aria-current="page" href="#"><i class="bi bi-calendar"></i> Recent</a>
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
                            <image class="me-2 rounded-circle" id="userIcon" src="public/images/default_user.jpg"
                                style="width: 40px; height: 40px;"></image>
                            <h6 class="d-inline-block text-truncate fw-semibold mb-0" id="userName">
                                OnlyTwentyCharacters
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        </div>
        <!-- Upload modal -->
        <div class="modal fade" id="uploadModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
            role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">
                            Post
                        </h5>
                    </div>
                    <div class="modal-body">
                        <form id="postUploadForm" method="POST" action="actions/post_action.php">
                            <div class="mb-3">
                                <textarea class="form-control" name="body" rows="5"
                                    placeholder="What's on your mind?" required></textarea>
                                    <div class="form-text">0/300</div>
                            </div>

                            <input type="hidden" id="parentId" name="parent_id" value="0">

                            <input type="hidden" id="postStatus" name="status" value="active">

                            <div class="mb-3">
                                <label for="postImage" class="form-label">Add Image (Not working)</label>
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

        <section style="background-color: rgb(124, 240, 139);">
            <!-- Post area -->
            <div class="m-1 container">
                <div>
                 
                    <img src="public/uploads/posts/mc.png" alt="">
                    <?php
                        foreach($posts as $post){
                            echo("<div class=\"post-squares\">");

                            echo("<div>");
                            echo($post['body']);
                            echo("</div>");

                            echo("<div class=\"image-preview-container\">");
                            foreach($medias as $media){
                                if($post['id']==$media['post_id']){
                                    echo("<img src=\"".$media['file_url']."\" alt=\"\" class=\"image-preview\">");
                                }
                            }
                            echo("</div>");

                            echo("</div>");
                        }




                    ?>
                    
                </div>

            </div>
        </section>

    </main>
    <footer>
        <!-- place footer here -->
    </footer>



    <script src="home2.js"></script>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

<?php
    $_SESSION["search"]=$_POST["key"];

?>
</html>