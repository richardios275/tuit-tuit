<?php
if (!defined('APP_INCLUDED')) {
    header('HTTP/1.0 403 Forbidden');
    die('Direct access forbidden');
}

// Get the profile user's info
$stmt = $pdo->prepare("SELECT username, displayname, bio, profile_pic, created_at, pronouns FROM users WHERE username = ?");
$stmt->execute([$profile_username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Get the profile user's follow count
// Following
$stmt = $pdo->prepare("SELECT COUNT(*) AS row_count FROM follows WHERE `followed_user_username` = ?");
$stmt->execute([$profile_username]);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$following = $stmt->fetch(PDO::FETCH_ASSOC);

// Followers
$stmt = $pdo->prepare("SELECT COUNT(*) AS row_count FROM follows WHERE `following_user_username` = ?");
$stmt->execute([$profile_username]);
$followers = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<style>
    .header-body {
        height: fit-content;
        margin: 20px;
        padding: 10px;
        background-color: white;
        box-sizing: border-box;
        border-radius: 10px;
        box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.3);
    }
</style>

<div class="header-body p-4 d-flex flex-row justify-content-between">
    <div class="d-flex flex-row">
        <?php $iconSize = 60; $iconSource = "/public/images/default_user.jpg"; $iconClass = "me-3"; include $_SERVER['DOCUMENT_ROOT'] . '/components/profile_icon.php';?>
        
        <div class="d-flex flex-column justify-content-center">
            <?php
            $displayName = $user['displayname'] ? $user['displayname'] : '@' . $user['username'];
            echo '<div class="fs-5 fw-semibold">' . htmlspecialchars( $displayName ) . '</div>';
            if ('@'.$user['username'] != $displayName) {
                echo '<div class="fs-6">@'. htmlspecialchars( $user['username'] ) . '</div>';
            }
            ?>
            <div class="row">
                <div class="col">
                    <h6>Followers</h6>
                    <h6 class="fw-bold"><?php echo $followers; ?></h6>
                </div>
                <div class="col">
                    <h6>Following</h6>
                    <h6 class="fw-bold"><?php echo $following; ?></h6>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex flex-row mt-3 <?php if ($username == $profile_username) {echo 'd-none';}?>">
        <button class="btn btn-primary">Follow</button>
    </div>
    <div class="d-flex flex-row mt-3 <?php if ($username != $profile_username) {echo 'd-none';}?>">
        <a href="/settings">
            <button class="btn btn-primary">Settings</button>
        </a>
    </div>
</div>