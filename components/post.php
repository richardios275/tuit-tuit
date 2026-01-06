<style>
    .post-squares {
        height: fit-content;
        margin: 20px;
        padding: 10px;
        background-color: white;
        box-sizing: border-box;
        border-radius: 10px;
        box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.3);
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

<div id="post-<?php echo $post["id"] ?>" class="post-squares">
    <a href="/profile/<?php echo htmlspecialchars($post['user_username']); ?>"
        class="fs-5 text-decoration-none"><?php echo htmlspecialchars($post['user_username']); ?></a>
    <div id="post-<?php echo $post["id"] ?>-body"><?php echo htmlspecialchars($post['body']); ?></div>

    <?php
    if (!empty($post["media"])) {
        echo ("<div class=\"image-preview-container\">");
        foreach ($post["media"] as $media) {
            echo ("<img src=\"/" . $media['file_url'] . "\" alt=\"\" class=\"image-preview\">");
        }
        echo ("</div>");
    }
    ?>

    <div class="mt-2 d-flex flex-row justify-content-between">
        <div>
            <button id="post-<?php echo $post["id"]; ?>-likeButton" class="btn btn-danger d-flex flex-row" onclick="onLikeAction('<?php echo $post["id"]; ?>')">
                <i id="post-<?php echo $post["id"]; ?>-likeIcon" class="bi bi-heart me-2"></i>
                <div id="post-<?php echo $post["id"]; ?>-likeCount"><?php echo $post["likes_count"];?></div>
            </button>
        </div>
        <div>
            <?php
            if ($post['user_username'] == $_SESSION['user_id']) {
                echo ("<button class=\"btn btn-primary me-2\" data-bs-toggle=\"modal\" data-bs-target=\"#updateModal\" data-bs-postid=" . $post['id'] . ">update</button>");
                echo ("<button class=\"btn btn-primary\" onclick=\"delete_post('" . $post['id'] . "')\">delete</button>");
            }
            ?>
        </div>
    </div>
</div>

<script>
    function delete_post(id) {
        $.ajax({
            type: "POST",
            url: 'actions/delete_action.php',
            data: { input: id },
            success: function (response) {
                alert("your post has been deleted.")
                location.reload()
            }
        });
    }

    function onLikeAction(postId) {
        console.log("like button clicked for post ID: " + postId);
        const likeButton = document.getElementById("post-" + postId + "-likeButton");
        const likeIcon = document.getElementById("post-" + postId + "-likeIcon");
        const likeCount = document.getElementById("post-" + postId + "-likeCount");

        likeButton.disabled = true;
        $.ajax({
            type: "POST",
            url: '/actions/like_action.php',
            data: { id: postId },
            success: function (response) {
                likeButton.disabled = false;
                if (response == 'liked') {
                    //likeIcon. = "Unfollow";
                    likeCount.innerText = Number(likeCount.innerText) + 1;
                } else {
                    likeCount.innerText = Number(likeCount.innerText) - 1;
                }

                //location.reload();
            }
        });
    }
</script>