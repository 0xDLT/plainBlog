<?php include 'header.php';
?>

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

            $stmt = $db->query("SELECT posts.*, users.username, posts.image_data, users.avatar, posts.created_at FROM posts JOIN users ON posts.user_id = users.id");
            $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($posts as $post) {
                echo '<div class="border p-4">';
                    echo '<div class="mb-4 flex items-center">';
                        echo '<a href="profile.php?id=' . $post['user_id'] . '">';
                            if ($post['avatar']) {
                                echo '<img src="data:image/jpeg;base64,' . base64_encode($post['avatar']) . '" class="w-12 h-12 rounded-full mr-4">';
                            } else {
                                // Inline SVG as default avatar
                                echo '<img src="data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48"><circle cx="24" cy="24" r="20" fill="#ccc" /><text x="24" y="24" font-size="18" text-anchor="middle" fill="white" dy=".3em">?</text></svg>') . '" class="w-12 h-12 rounded-full mr-4">';
                            }
                        echo '</a>';
                        echo '<div>';
                            echo '<a href="profile.php?id=' . $post['user_id'] . '" class="text-xl font-bold">' . $post['username'] . '</a>';
                        echo '</div>';
                    echo '</div>'; 
                
                
                    echo '<h2 class="text-2xl font-bold mb-2">' . $post['title'] . '</h2>';
                    echo '<p class="mt-2">' . $post['body'] . '</p>';
                    if (!empty($post['image_data'])) {
                        echo '<img src="data:image/jpeg;base64,' . base64_encode($post['image_data']) . '" class="my-4 w-64 h-64 object-cover">';
                    }                
                    
                    echo '<p class="text-sm text-gray-500 mt-4">' . date('F j, Y, g:i a', strtotime($post['created_at'])) . '</p>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</body>
</html>
