<?php
// Always explicitly state that you are returning JSON so the frontend knows how to read it
header('Content-Type: application/json');

// 1. Include your central database connection
require_once 'db.php';

try {
    // 2. Prepare and execute the query using PDO
    $stmt = $pdo->query("SELECT * FROM categories");
    
    // 3. PDO has a super handy function called fetchAll() that grabs everything at once!
    // FETCH_ASSOC tells it to return an associative array (just like fetch_assoc in mysqli)
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Output the JSON
    echo json_encode($categories);

} catch (PDOException $e) {
    // Safely return the error as JSON if the query fails
    echo json_encode(['error' => 'Database Error: ' . $e->getMessage()]);
}
?>