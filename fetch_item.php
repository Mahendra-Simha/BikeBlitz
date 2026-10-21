<?php
header('Content-Type: application/json');

// 1. Bring in your central database connection
require_once 'db.php';

$id = $_GET['id'] ?? '';

// 2. Validate the ID to ensure it is a valid number before querying the database
if (empty($id) || !is_numeric($id)) {
    echo json_encode(['error' => 'Invalid or missing ID']);
    exit;
}

try {
    // 3. Prepare and execute the query using PDO
    $stmt = $pdo->prepare("SELECT * FROM items WHERE id = ?");
    $stmt->execute([$id]);
    
    // 4. Fetch a single row (fetch instead of fetchAll)
    $item = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Check if the item actually exists before returning it
    if ($item) {
        echo json_encode($item);
    } else {
        // Return a clean error if the ID doesn't exist in the database
        echo json_encode(['error' => 'Item not found']);
    }

} catch (PDOException $e) {
    // Safely output database errors as JSON
    echo json_encode(['error' => 'Database Error: ' . $e->getMessage()]);
}
?>