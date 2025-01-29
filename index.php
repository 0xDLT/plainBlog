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
            $stmt = $db->query("SELECT posts.*, users.username, posts.image_data, users.avatar, posts.created_at FROM posts JOIN users ON posts.user_id = users.id");
            $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($posts as $post) {
                echo '<div class="border p-4">';
                
                // Create flex container for username and avatar
                echo '<div class="mb-4 flex items-center">';
                
                // Display avatar if available
                if ($post['avatar']) {
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($post['avatar']) . '" class="w-12 h-12 rounded-full mr-4">';
                } else {
                    // Inline SVG as default avatar
                    echo '<img src="data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48"><circle cx="24" cy="24" r="20" fill="#ccc" /><text x="24" y="24" font-size="18" text-anchor="middle" fill="white" dy=".3em">?</text></svg>') . '" class="w-12 h-12 rounded-full mr-4">';
                }
                
                // Display username beside the avatar
                echo '<div>';
                echo '<p class="text-xl font-bold">' . $post['username'] . '</p>';
                echo '</div>';
                echo '</div>'; // End of flex container
                
                // Display title and body below the username and avatar
                echo '<h2 class="text-2xl font-bold mb-2">' . $post['title'] . '</h2>';
                echo '<p class="mt-2">' . $post['body'] . '</p>';
                
                // Display image if available
                if (!empty($post['image_data'])) {
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($post['image_data']) . '" class="my-4 w-64 h-64 object-cover">';
                }                
                
                 $timezone = new DateTimeZone('UTC');
                $created_at = new DateTime($post['created_at'], $timezone);
                $now = new DateTime('now', $timezone);
                $interval = $created_at->diff($now); 

                if ($interval->y > 0) {
                    $time_ago = $interval->y . ' year' . ($interval->y > 1 ? 's' : '') . ' ago';
                } elseif ($interval->m > 0) {
                    $time_ago = $interval->m . ' month' . ($interval->m > 1 ? 's' : '') . ' ago';
                } elseif ($interval->d > 0) {
                    $time_ago = $interval->d . ' day' . ($interval->d > 1 ? 's' : '') . ' ago';
                } elseif ($interval->h > 0) {
                    $time_ago = $interval->h . ' hour' . ($interval->h > 1 ? 's' : '') . ' ago';
                } elseif ($interval->i > 0) {
                    $time_ago = $interval->i . ' minute' . ($interval->i > 1 ? 's' : '') . ' ago';
                } elseif ($interval->s >= 0) {
                    $time_ago = 'just now';
                } else {
                    $time_ago = 'just now';
                }

                echo '<p class="text-gray-600 text-sm mt-2">' . $time_ago . '</p>';
                echo '</div>'; 
            }
            ?>
        </div>
    </div>
</body>
</html>
