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
$stmt = $pdo->prepare("SELECT COUNT(*) AS count FROM follows WHERE `followed_user_username` = ?");
$stmt->execute([$profile_username]);
$following = $stmt->fetch(PDO::FETCH_ASSOC)["count"];

// Followers
$stmt = $pdo->prepare("SELECT COUNT(*) AS count FROM follows WHERE `following_user_username` = ?");
$stmt->execute([$profile_username]);
$followers = $stmt->fetch(PDO::FETCH_ASSOC)["count"];
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
             <div class="d-flex flex-row align-items-end">
                <?php
            $displayName = $user['displayname'] ? $user['displayname'] : '@' . $user['username'];
            echo '<div class="me-2 fs-5 fw-semibold">' . htmlspecialchars( $displayName ) . '</div>';
            ?>
            <?php
            if ($user['pronouns']) {
                echo '<small>('. htmlspecialchars( $user['pronouns'] ) . ')</small>';
            }
            ?>
            </div>
            <?php
            if ('@'.$user['username'] != $displayName) {
                echo '<div class="fs-6">@'. htmlspecialchars( $user['username'] ) . '</div>';
            }
            ?>
            <div class="row">
                <div class="col">
                    <h6>Followers</h6>
                    <h6 id="followerCount" class="fw-bold"><?php echo $followers; ?></h6>
                </div>
                <div class="col">
                    <h6>Following</h6>
                    <h6 class="fw-bold"><?php echo $following; ?></h6>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex flex-row mt-3 align-items-end <?php if ($username == $profile_username) {echo 'd-none';}?>">
        <div>
            <button id="followButton" class="btn btn-primary" onclick="onFollowAction('<?php echo $profile_username; ?>')">Follow</button>
        </div>
        
    </div>
    <div class="d-flex flex-row mt-3 align-items-end <?php if ($username != $profile_username) {echo 'd-none';}?>">
        <a href="/settings">
            <button class="btn btn-primary">Settings</button>
        </a>
    </div>
</div>

<script>
    const followButton = document.getElementById("followButton")
    const followerCount = document.getElementById("followerCount")
function onFollowAction(username) {
    followButton.disabled = true;
    $.ajax({
            type: "POST",
            url: '/actions/follow_action.php',
            data: { id: username },
            success: function(response) {
                followButton.disabled = false;
                if (response == 'followed') {
                    followButton.innerText = "Unfollow";
                    followerCount.innerText = Number(followerCount.innerText) + 1;
                } else {
                    followButton.innerHTML = "Follow";
                    followerCount.innerText = Number(followerCount.innerText) - 1;
                }

                //location.reload();
            }
        });
}
</script>