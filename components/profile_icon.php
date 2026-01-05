<style>
    .profile-frame {
        width: <?php echo $iconSize;?>px;
        height: <?php echo $iconSize;?>px;
        border-radius: 100%;
        overflow: hidden;
    }

    .profile-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>

<div class="profile-frame <?php echo $iconClass?>">
    <image class="profile-image" id="userIcon" src=<?php echo $iconSource;?> </image></image>
</div>