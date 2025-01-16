<?php
session_start();
require_once 'user.class.php'; 
require_once 'database.php';   

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize user input
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];

    // Create a new User object with the username and plaintext password
    $user = new User($username, $password);

    // Check if the user exists in the database
    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $user->getUsername()]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Use the plaintext password and the stored hashed password to verify
        if ($user && password_verify($password,$user['password'])) {
            // User exists and password is correct
            $_SESSION['id'] = $user['id'];  
            $_SESSION['username'] = $user['username'];  
            
            echo "Login successful!";
            header("Location: index.php");
            excit();
        } else {
            echo "Invalid username or password.";
        }
    } else {
        echo "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-In</title>
</head>
<body>
    <h2>Sign In</h2>
    <form method="POST" action="sign-in.php">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Sign In</button>
    </form>

    <a href="sign-up.php">Sign Up</a>
    <a href="sign-out.php">Sign Out</a>
</body>
</html>
