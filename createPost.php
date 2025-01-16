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
    $image_data = file_get_contents($_FILES['image']['tmp_name']);

    $post = new Post($_SESSION['id'], $title, $body, $image_data);
    $post->setId($id);
    $post->setUserId($user_id);
    $post->setTitle($title);
    $post->setBody($body);
    $post->setImageData($image_data);
    
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
    <form action="create.php" method="POST" enctype="multipart/form-data">
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