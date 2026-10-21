<?php
// Ensure the frontend knows this is JSON data
header('Content-Type: application/json');

// 1. Include your central database connection
require_once 'db.php';

try {
    // 2. Your excellent JOIN query
    $sql = "SELECT items.*, categories.name AS category_name 
            FROM items 
            JOIN categories ON items.category_id = categories.id";
            
    // 3. Execute the query
    $stmt = $pdo->query($sql);
    
    // 4. Fetch all results at once
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Output the results as JSON
    echo json_encode($items);

} catch (PDOException $e) {
    // Safely handle any database errors
    echo json_encode(['error' => 'Database Error: ' . $e->getMessage()]);
}
?>