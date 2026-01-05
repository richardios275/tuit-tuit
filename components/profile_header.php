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

    .profile-frame {
        width: 60px;
        height: 60px;
        border-radius: 100%;
        overflow: hidden;
    }

    .profile-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>

<div class="header-body p-4 d-flex flex-row justify-content-between">
    <div class="d-flex flex-row">
        <div class="profile-frame me-3">
            <image class="profile-image" id="userIcon" src="/public/images/default_user.jpg"</image></image>
        </div>
        
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
        <button class="btn btn-primary">Settings</button>
    </div>
</div>