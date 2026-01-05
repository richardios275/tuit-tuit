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