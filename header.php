<?php 
require_once 'database.php'; 
require_once 'users.class.php';

$userId = $_SESSION['id'] ?? null;
if ($userId) {
  $stmt = $db->prepare('SELECT avatar FROM users WHERE id = ?');
  $stmt->execute([$userId]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script>
    function toggleMenu() {
      const menu = document.getElementById('menu');
      menu.classList.toggle('hidden');
    }
  </script>
</head>
<body class="bg-gray-100">

  <!-- Header -->
  <header class="bg-white p-4 shadow-md flex items-center justify-between">
    <!-- Left side - PlainBlog Text -->
    <div class="flex items-center space-x-4">
      <h1 class="text-xl font-bold text-gray-800">PlainBlog</h1>
    </div>

    <!-- Right side - Avatar, Recent, and Menu -->
    <div class="flex items-center space-x-4">

      <!-- Recent Posts Icon -->
      <a href="index.php" class="text-gray-600 hover:text-gray-800">
        <button>
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 6h14M5 18h14"></path>
          </svg>
        </button>
      </a>

      <!-- Avatar with Dropdown Menu -->
      <div class="relative">
        <button onclick="toggleMenu()" class="w-10 h-10 rounded-full overflow-hidden border-2 border-gray-300">
            <?php
            if (!empty($user['avatar'])) {
                echo '<img src="' . htmlspecialchars($user['avatar']) . '" alt="User Avatar" class="w-full h-full object-cover">';
            } else {
                // Fallback to default avatar if no user avatar exists
                echo '<img src="data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48"><circle cx="24" cy="24" r="20" fill="#ccc" /><text x="24" y="24" font-size="18" text-anchor="middle" fill="white" dy=".3em">?</text></svg>') . '" class="w-12 h-12 rounded-full mr-4">';
            }
            ?>
        </button>

        <!-- Dropdown Menu -->
        <div id="menu" class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-lg hidden z-10">
          <ul class="py-2 text-gray-700">
            <li>
              <a href="/profile" class="block px-4 py-2 hover:bg-gray-100">My Profile</a>
            </li>
            <li>
              <a href="/settings" class="block px-4 py-2 hover:bg-gray-100">Settings</a>
            </li>
            <li>
              <a href="sign-out.php" class="block px-4 py-2 hover:bg-gray-100">Sign Out</a>
            </li>
          </ul>
        </div>
      </div>

      <!-- Add Post Icon -->
      <a href="createpost.php" class="text-gray-600 hover:text-gray-800">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
      </a>
    </div>
  </header>

</body>
</html>
