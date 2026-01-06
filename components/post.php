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
    <a href="/profile/<?php echo htmlspecialchars($post['user_username']); ?>" class="fs-5 text-decoration-none"><?php echo htmlspecialchars($post['user_username']); ?></a>
    <div id="post-<?php echo $post["id"] ?>-body"><?php echo htmlspecialchars($post['body']); ?></div>

    <?php
    if (!empty($post["media"])) {
        echo ("<div class=\"image-preview-container\">");
        foreach ($post["media"] as $media) {
            echo ("<img src=\"/" . $media['file_url'] . "\" alt=\"\" class=\"image-preview\">");
        }
        echo ("</div>");
    }

    echo ("<div style=\"margin-to:10px; margin-bottom:10px;\"> <i class=\"bi bi-heart\"></i> " . $post['likes_count'] . "</div>");

    if ($post['user_username'] == $_SESSION['user_id']) {
        echo ("<div style=\"margin-top: 10px;\">");
        echo ("<button class=\"btn btn-primary me-2\" data-bs-toggle=\"modal\" data-bs-target=\"#updateModal\" data-bs-postid=" . $post['id'] . ">update</button>");
        echo ("<button class=\"btn btn-primary\" onclick=\"delete_post('" . $post['id'] . "')\">delete</button>");
        echo ("</div>");
    }
    ?>
</div>

<script>
    function delete_post(id) {

        $.ajax({
            type: "POST",
            url: 'actions/delete_action.php',
            data: { input: id },
            success: function(response) {
                alert("your post has been deleted.")
        location.reload()
            }
        });
    }

</script>