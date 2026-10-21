<?php
header('Content-Type: application/json');

// 1. Include your central database connection
require_once 'db.php';

$categoryName = $_GET['category'] ?? '';

// Validate that a category was actually passed in the URL
if (empty($categoryName)) {
    echo json_encode(['error' => 'Category name is required']);
    exit;
}

try {
    // 2. The Upgrade: Use a JOIN to fetch items by category name in one single query!
    $sql = "
        SELECT items.* 
        FROM items 
        JOIN categories ON items.category_id = categories.id 
        WHERE categories.name = ?
    ";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$categoryName]);
    
    // 3. Fetch all matching items at once
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Output the results (it will safely output an empty array [] if no items match)
    echo json_encode($items);

} catch (PDOException $e) {
    // Catch any errors and return them cleanly as JSON
    echo json_encode(['error' => 'Database Error: ' . $e->getMessage()]);
}
?>