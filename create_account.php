<?php
session_start();

// 1. Include the new PDO connection file
require_once 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $name = $_POST['name'];
    $age = $_POST['age'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate inputs
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script>alert("Invalid email format"); window.location.href="create_account.html";</script>';
        exit();
    }

    try {
        // 2. PDO Prepared statement to check if email/phone exists
        $check_stmt = $pdo->prepare("SELECT id FROM accounts WHERE email = ? OR phone = ?");
        // PDO lets you pass the variables directly into the execute() array!
        $check_stmt->execute([$email, $phone]);

        // PDO uses rowCount() instead of num_rows
        if ($check_stmt->rowCount() > 0) {
            echo '<script>alert("An account with this email or phone number already exists."); window.location.href="user.html";</script>';
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // 3. PDO Prepared statement to insert the new user
            $insert_stmt = $pdo->prepare("INSERT INTO accounts (name, age, phone, email, password) VALUES (?, ?, ?, ?, ?)");
            
            // Execute the insert
            if ($insert_stmt->execute([$name, $age, $phone, $email, $hashed_password])) {
                echo '<script>alert("Account created successfully!"); window.location.href="login.html";</script>';
            } else {
                echo '<script>alert("Error creating account."); window.location.href="create_account.html";</script>';
            }
        }
    } catch (PDOException $e) {
        // Because you set PDO to throw exceptions in db.php, we can catch any database errors here safely
        echo '<script>alert("Database Error: ' . $e->getMessage() . '"); window.location.href="create_account.html";</script>';
    }
}
// Note: PDO closes connections automatically when the script ends, so no need for $conn->close()
?>