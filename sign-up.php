<?php
session_start();
require_once 'users.class.php'; 
require_once 'database.php';  

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize user input
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];

    // Create a new User object
    $user = new User($username, $password);
    $user->setPasswordHash($password);
    
    // Check if username already exists
    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $user->getUsername()]);
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingUser) {
        echo "Username already taken!";
    } else {
        // Insert the user into the database
        $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $stmt->execute([
            'username' => $user->getUsername(),
            'password' => $user->getPassword(),  
        ]);

        echo "User registered successfully!";
        header("Location: sign-in.php");  
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>
<body>
    <h2>Sign Up</h2>
    <form method="POST" action="sign-up.php">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Sign Up</button>
    </form>

    <a href="sign-in.php">Already have an account? Sign In</a>
</body>
</html>
