<?php
header('Content-Type: application/json');

// 1. Include your new PDO connection file
require_once 'db.php';

$id = $_POST['id'] ?? '';

// 2. Quick Validation: Make sure the ID is not empty and is a valid number
if (empty($id) || !is_numeric($id)) {
    echo json_encode(['success' => false, 'message' => 'Invalid or missing ID']);
    exit;
}

try {
    // 3. PDO Prepared statement for deletion
    $stmt = $pdo->prepare("DELETE FROM items WHERE id = ?");
    
    // Execute the query
    if ($stmt->execute([$id])) {
        // rowCount() checks if an item was actually deleted (in case the ID didn't exist)
        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Item not found in database']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to execute delete query']);
    }
} catch (PDOException $e) {
    // Return database errors safely as JSON so your frontend JavaScript can read them
    echo json_encode(['success' => false, 'message' => 'Database Error: ' . $e->getMessage()]);
}
?>