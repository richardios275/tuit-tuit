<?php
session_start();
require_once '../config/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $body = htmlspecialchars(trim($_POST['body']));
    $user_username = $_SESSION['user_id'];
    $parent_id = isset($_POST['parent_id']) ? intval($_POST['parent_id']) : 0;
    $status = $_POST['status'] ?? 'active'; // Default to 'active' if status field exists

    // Validate input
    if (empty($body)) {
        $_SESSION['error'] = 'Post content cannot be empty';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    try {
        // Prepare the SQL statement
        $sql = "INSERT INTO posts (body, user_username, parent_id, status, created_at) 
                VALUES (:body, :user_username, :parent_id, :status, NOW())";

        $stmt = $pdo->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':body', $body);
        $stmt->bindParam(':user_username', $user_username);
        $stmt->bindParam(':parent_id', $parent_id);
        $stmt->bindParam(':status', $status);

        // Execute the query
        if ($stmt->execute()) {
            $_SESSION['success'] = 'Post uploaded successfully!';

            // Handle image upload if provided
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $post_id = $pdo->lastInsertId();
                handleImageUpload($post_id, $_FILES['image']);
            }
        } else {
            $_SESSION['error'] = 'Failed to upload post';
        }

    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        $_SESSION['error'] = 'An error occurred while uploading your post';
    }

    // Redirect back to previous page
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

function handleImageUpload($post_id, $file)
{
    // Configure upload directory
    $uploadDir = 'uploads/posts/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Validate file
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $maxFileSize = 5 * 1024 * 1024; // 5MB

    if (!in_array($file['type'], $allowedTypes)) {
        $_SESSION['error'] = 'Invalid file type. Only JPG, PNG, GIF, and WebP are allowed.';
        return;
    }

    if ($file['size'] > $maxFileSize) {
        $_SESSION['error'] = 'File is too large. Maximum size is 5MB.';
        return;
    }

    // Generate unique filename
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid('post_' . $post_id . '_') . '.' . $extension;
    $filepath = $uploadDir . $filename;

    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        // Save image path to database if you have a separate images table
        // Example: INSERT INTO post_images (post_id, image_path) VALUES (:post_id, :image_path)

        $_SESSION['success'] .= ' Image uploaded successfully!';
    } else {
        $_SESSION['error'] = 'Failed to upload image';
    }
}
?>