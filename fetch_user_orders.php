<?php
// 1. Tell the frontend to expect JSON data
header('Content-Type: application/json');

require_once 'db.php';
session_start();

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    // Optional: You can return an explicit error here instead of an empty array to help your frontend know WHY it failed
    echo json_encode(['error' => 'User not authenticated']);
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    $stmt = $pdo->prepare('SELECT * FROM orders WHERE user_id = ?');
    $stmt->execute([$user_id]);
    
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($orders);
} catch (PDOException $e) {
    // Optional: Return a clean error message for easier debugging
    echo json_encode(['error' => 'Failed to retrieve orders']);
    exit();
}
?>