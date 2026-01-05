<?php
session_start();
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("Location: login");
}
$username = $_SESSION['user_id'];

include_once('config/db.php');

$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

//$pdo=new PDO('mysql:host=localhost;port=3306;dbname=tuituit','root', '');

$stmt = $pdo->prepare("
    SELECT 
    posts.id as post_id,
    posts.parent_id,
    posts.body,
    posts.user_username,
    posts.status,
    posts.created_at,
    post_media.id as media_id,
    post_media.file_url,
    post_media.media_type,
    post_media.order_index
    FROM posts
    LEFT JOIN post_media ON posts.id = post_media.post_id
    WHERE posts.id IN (
        SELECT id 
        FROM posts 
        WHERE parent_id IS NULL
        AND (body LIKE :search OR user_username LIKE :search)
    )
    ORDER BY 
        posts.created_at DESC,
        post_media.order_index DESC;
    ");
$stmt->execute([':search' => '%' . $search . '%']);

$posts = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $postId = $row['post_id'];

    // Initialize post if not exists
    if (!isset($posts[$postId])) {
        $posts[$postId] = [
            'id' => $row['post_id'],
            'parent_id' => $row['parent_id'],
            'body' => $row['body'],
            'user_username' => $row['user_username'],
            'status' => $row['status'],
            'created_at' => $row['created_at'],
            'media' => []
        ];
    }

    // Add media if exists
    if ($row['media_id']) {
        $posts[$postId]['media'][] = [
            'id' => $row['media_id'],
            'file_url' => $row['file_url'],
            'media_type' => $row['media_type'],
            'order_index' => $row['order_index']
        ];
    }
}

// Convert to indexed array
$posts = array_values($posts);

// echo("<pre>\n");
// print_r($posts);
// echo("</pre>\n");
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

    <!-- Home CSS -->
    <link rel="stylesheet" href="home2.css">
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
        <?php include("components/navbar.php") ?>

    </header>
    <main>
        <!-- Sidebar -->
        <?php include('components/sidebar.php') ?>

        <!-- Upload modal -->
        <?php include('components/modals/upload.php') ?>

        <section class="d-flex justify-content-center">
            <!-- Post area -->
            <div class="m-1 container">
                <div>
                    <div class="post-squares">


                        <h5>
                            <?php
                            echo ($_SESSION['user_id']);
                            ?>
                        </h5>


                        <p style="margin-bottom: 20px;">testing text</p>

                        <button onclick="testing('67','update')" style="margin-right: 10px;">update</button>
                        <button onclick="testing('67','delete')">delete</button> <br>

                    </div>
                    <?php
                    foreach ($posts as $post) {
                        echo ("<div class=\"post-squares\">");

                        echo ("
                        <h5>" .
                            $post['user_username']
                            . "</h5>
                        ");

                        echo ("<div>");
                        echo ($post['body']);
                        echo ("</div>");

                        if (!empty($post["media"])) {
                            echo ("<div class=\"image-preview-container\">");
                            foreach ($post["media"] as $media) {

                                echo ("<img src=\"" . $media['file_url'] . "\" alt=\"\" class=\"image-preview\">");

                            }
                            echo ("</div>");
                        }

                        if ($post['user_username'] == $_SESSION['user_id']) {
                            echo ("<div style=\"margin-top: 10px;\">");
                            echo ("<button onclick=\"testing('" . $post['id'] . "','update')\" style=\"margin-right: 10px;\">update</button>");
                            echo ("<button onclick=\"testing('" . $post['id'] . "','delete')\">delete</button>");
                            echo ("</div>");
                        }

                        echo ("</div>");
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

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

</body>

<script>

    function testing(id, action) {
        $.ajax({
            type: "POST",
            url: 'actions/' + action + '_action.php',
            data: { input: id },


        });
        alert("your post has been deleted.")
        location.reload()
    }

</script>

</html>