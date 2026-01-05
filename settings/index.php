<?php
session_start();
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("Location: login");
}

$username = $_SESSION['user_id'];

include_once($_SERVER['DOCUMENT_ROOT'] . '/config/db.php');

$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

//$pdo=new PDO('mysql:host=localhost;port=3306;dbname=tuituit','root', '');

// Get the user's info
$stmt = $pdo->prepare("SELECT username, displayname, bio, profile_pic, created_at, pronouns FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<?php $title = "Settings";
include($_SERVER['DOCUMENT_ROOT'] . '/components/main_header.php'); ?>

<body>
    <header>
        <?php include($_SERVER['DOCUMENT_ROOT'] . "/components/navbar.php") ?>
    </header>
    <main>
        <!-- Sidebar -->
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/components/sidebar.php') ?>

        <!-- Upload modal -->
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/components/modals/upload.php') ?>

        <section class="d-flex justify-content-center">
            <!-- Post area -->
            <div class="m-1 container">
                <h2 class="fw-semibold">Settings</h2>
                <form class="mb-3">
                    <div class="mb-3">
                        <label class="form-label">Profile Icon</label>
                        <div class="row">
                            <div class="col-sm-2">
                                <?php $iconSize = 120;
                                $iconSource = "/public/images/default_user.jpg";
                                include $_SERVER['DOCUMENT_ROOT'] . '/components/profile_icon.php'; ?>

                            </div>
                            <div class="col-sm-6 mt-3">
                                <input type="file" class="form-control" id="profileUpload" name="profileIcon">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="displayNameInput" class="col-sm-2 col-form-label">Display Name</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="displayNameInput">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="pronounsInput" class="col-sm-2 col-form-label">Pronouns</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="pronounsInput">
                        </div>
                    </div>
                    <div class="row mb-5">
                        <label for="bioInput" class="col-sm-2 col-form-label">Bio</label>
                        <div class="col-sm-6">
                            <textarea type="text" class="form-control" id="displayNameInput" rows="3"></textarea>
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Change Password</label>
                        <div class="row mb-3">
                            <label for="oldPasswordInput" class="col-sm-2 col-form-label">Old Password</label>
                            <div class="col-sm-6">
                                <input type="password" class="form-control" id="oldPasswordInput">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="newPasswordInput" class="col-sm-2 col-form-label">New Password</label>
                            <div class="col-sm-6">
                                <input type="password" class="form-control" id="newPasswordInput">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Apply Changes</button>
                </form>
                <button class="btn btn-primary">Logout</button>
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