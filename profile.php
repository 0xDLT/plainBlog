<?php
session_start();
require_once 'database.php';
require_once 'users.class.php';
require_once 'posts.class.php';

// Make sure user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: sign-in.php");
    exit();
}

// Fetch the user ID from URL, and ensure it exists
$userId = isset($_GET['id']) ? (int)$_GET['id'] : null;
if (!$userId) {
    echo "No user ID provided.";
    exit();
}

// Fetch the user from the database by ID
$stmt = $db->prepare("SELECT username, avatar FROM users WHERE id = :id");
$stmt->execute(['id' => $userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "User not found.";
    exit();
}

// Fetch the user's posts
$stmt = $db->prepare("SELECT * FROM posts WHERE user_id = :user_id");
$stmt->execute(['user_id' => $userId]);
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title><?php echo htmlspecialchars($user['username']); ?>'s Profile</title>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4"><?php echo htmlspecialchars($user['username']); ?>'s Profile</h1>
        
        <!-- User Information -->
        <div class="mb-4">
            <h2 class="text-xl font-bold">User Information</h2>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
            
            <!-- Avatar Display -->
            <?php if ($user['avatar']): ?>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($user['avatar']); ?>" class="w-12 h-12 rounded-full">
            <?php else: ?>
                <!-- Fallback SVG if no avatar exists -->
                <img src="data:image/svg+xml;base64,<?php echo base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48"><circle cx="24" cy="24" r="20" fill="#ccc" /><text x="24" y="24" font-size="18" text-anchor="middle" fill="white" dy=".3em">?</text></svg>'); ?>" class="w-12 h-12 rounded-full">
            <?php endif; ?>
        </div>

        <!-- User Posts -->
        <div>
            <h2 class="text-xl font-bold">User Posts</h2>
            <?php foreach ($posts as $post): ?>
                <div class="border p-4 mb-4">
                    <h3 class="text-2xl font-bold"><?php echo htmlspecialchars($post['title']); ?></h3>
                    <p><?php echo nl2br(htmlspecialchars($post['body'])); ?></p>
                    
                    <?php if ($post['image_data']): ?>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($post['image_data']); ?>" class="my-4 w-64 h-64 object-cover">
                    <?php endif; ?>
                    
                    <p class="text-sm text-gray-500"><?php echo date('F j, Y, g:i a', strtotime($post['created_at'])); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
