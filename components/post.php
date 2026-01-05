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

<div class="post-squares">
    <h5><?php echo htmlspecialchars($post['user_username']); ?></h5>
    <div><?php echo htmlspecialchars($post['body']); ?></div>

    <?php
    if (!empty($post["media"])) {
        echo ("<div class=\"image-preview-container\">");
        foreach ($post["media"] as $media) {
            echo ("<img src=\"" . $media['file_url'] . "\" alt=\"\" class=\"image-preview\">");
        }
        echo ("</div>");
    }

    if ($post['user_username'] == $_SESSION['user_id']) {
        echo ("<div style=\"margin-top: 10px;\">");
        echo ("<button class=\"btn btn-primary me-2\" onclick=\"testing('" . $post['id'] . "','update')\">update</button>");
        echo ("<button class=\"btn btn-primary\" onclick=\"testing('" . $post['id'] . "','delete')\">delete</button>");
        echo ("</div>");
    }
    ?>
</div>