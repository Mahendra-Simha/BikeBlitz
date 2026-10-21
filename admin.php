<?php
session_start();

// 1. Include your central database connection
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Safely grab the POST variables and trim whitespace
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    try {
        // 2. PDO Prepared Statement (Completely immune to SQL injection)
        $stmt = $pdo->prepare("SELECT id, password FROM admins WHERE username = ?");
        $stmt->execute([$username]);
        
        // 3. Fetch the admin data as an associative array
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        // 4. Verify the admin exists AND the password matches
        if ($admin && password_verify($password, $admin['password'])) {
            // Login successful! Set the session variables
            $_SESSION['admin_username'] = $username;
            $_SESSION['admin_id'] = $admin['id']; // Storing the ID is a great security habit
            
            // Redirect to the admin panel
            header('Location: admin_panel.html'); 
            exit();
        } else {
            // Invalid credentials UX
            echo '<script>alert("Invalid username or password"); window.location.href="admin_login.html";</script>';
            exit();
        }
    } catch (PDOException $e) {
        // Handle database errors gracefully without crashing the UI
        echo '<script>alert("Database Error: ' . addslashes($e->getMessage()) . '"); window.location.href="admin_login.html";</script>';
        exit();
    }
}
?>