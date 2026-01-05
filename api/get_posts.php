<?php
session_start();
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sort = $_GET['sort']; // recent, popular
    $query = $_GET['query'];

    if (!empty($query)) {
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
                AND (body LIKE :query OR user_username LIKE :query)
            )
            ORDER BY 
                posts.created_at DESC,
                post_media.order_index DESC;
            ");
        $stmt->execute([':query' => '%' . $query . '%']);
    } else {
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
            )
            ORDER BY 
                posts.created_at DESC,
                post_media.order_index DESC;
            ");
        $stmt->execute();
    }

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
    //$posts = array_values($posts);
    echo json_encode($posts);
}