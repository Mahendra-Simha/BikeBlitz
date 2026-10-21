<?php
session_start();

// 1. Include your central database connection
require_once 'db.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Safely grab the POST variables
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    try {
        // 2. PDO Prepared Statement
        $stmt = $pdo->prepare("SELECT id, name, email, password FROM accounts WHERE email = ?");
        $stmt->execute([$email]);
        
        // 3. Fetch the user data as an associative array
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // 4. Check if the user exists AND the password matches
        if ($user && password_verify($password, $user['password'])) {
            // Login successful! Set the session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email']; 
            
            // Redirect to the welcome page
            header("Location: welcome.php");
            exit();
        } else {
            // UX Upgrade: Show an alert and send them back to the login page
            echo '<script>alert("Invalid email or password."); window.location.href="login.html";</script>';
            exit();
        }
    } catch (PDOException $e) {
        // Handle database errors gracefully without breaking the UI
        echo '<script>alert("Database Error: ' . $e->getMessage() . '"); window.location.href="login.html";</script>';
        exit();
    }
}
?>