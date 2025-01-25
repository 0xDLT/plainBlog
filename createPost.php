<?php
session_start();
require_once 'database.php';
require_once 'posts.class.php';

print_r($_SESSION);

if(!isset($_SESSION['id'])){
    header("Location: sign-in.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = htmlspecialchars($_POST['title']);
    $body = $_POST['body'];

    if (empty($title) || empty($body)) {
        echo "Title and body are required!";
        exit; 
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_data = file_get_contents($_FILES['image']['tmp_name']);
    } else {
        $image_data = NULL; // No image uploaded, set to NULL
    }

    $post = new Post();
    $post->setUserId($_SESSION['id']);
    $post->setTitle($title);
    $post->setBody($body);
    if ($image_data !== NULL) {
        $post->setImageData($image_data);
    }
    
    if($post->save()){
        echo "Post created successfully!";
    } else {
        echo "Error creating post!";
    }
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
</head>
<body>
    <h1>Create a New Post</h1>

    <!-- Post creation form -->
    <form action="createpost.php" method="POST" enctype="multipart/form-data">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" required><br><br>

        <label for="body">Body:</label><br>
        <textarea id="body" name="body" required></textarea><br><br>

        <label for="image">Image (optional):</label><br>
        <input type="file" id="image" name="image"><br><br>

        <input type="submit" value="Create Post">
    </form>
</body>
</html>