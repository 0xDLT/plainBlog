<?php include 'header.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Blogs</title>
</head>
<body>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Blogs</h1>
        <div class="space-y-4">
            <?php
            require_once 'database.php';
            require_once 'posts.class.php';
            require_once 'users.class.php';
            $stmt = $db->query("SELECT posts.*, users.username, posts.image_data FROM posts JOIN users ON posts.user_id = users.id");
            $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($posts as $post) {
                echo '<div class="border p-4">';
                echo '<div class="mb-4">';
                //if ($post['avatar']) {
                //    echo '<img src="data:image/jpeg;base64,' . base64_encode($post['avatar']) . '" class="w-12 h-12 rounded-full mr-4">';
                //}
                echo '<div>';
                echo '<h2 class="text-xl font-bold">' . $post['title'] . '</h2>';
                echo '<p class="text-gray-600">by ' . $post['username'] . '</p>';
                echo '</div>';
                echo '</div>';
                echo '<p>' . $post['body'] . '</p>';
                if (!empty($post['image_data'])) {
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($post['image_data']) . '" class="my-4">';
                }
                echo '<p class="text-gray-600">' . $post['created_at'] . '</p>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</body>
</html>
