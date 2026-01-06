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
?>

<?php $title="Home"; include('components/main_header.php'); ?>

<body>
    <header>
        <?php include("components/navbar.php") ?>
    </header>
    <main>
        <!-- Sidebar -->
        <?php include('components/sidebar.php') ?>

        <!-- Upload modal -->
        <?php include('components/modals/upload.php') ?>
        <!-- Update modal -->
        <?php include('components/modals/update.php') ?>

        <section class="d-flex justify-content-center">
            <!-- Post area -->
            <div class="m-1 container">
                <div>
                    <?php
                    foreach ($posts as $post) {
                        include('components/post.php');
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

</html>