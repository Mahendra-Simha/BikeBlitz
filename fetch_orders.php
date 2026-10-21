<?php
// Always tell the browser and frontend that this is a JSON response
header('Content-Type: application/json');

// 1. Bring in your central database connection
require_once 'db.php';

try {
    // 2. Your specific query to grab the order details
    $sql = "SELECT id, name, product_name, price, insurance_type, insurance_price, total_price, address, phone, payment_method, starting_point, dropping_point, created_at FROM orders";
    
    // 3. Execute the query
    $stmt = $pdo->query($sql);
    
    // 4. Use fetchAll to grab all the orders in one go!
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Return the data as JSON
    echo json_encode($orders);

} catch (PDOException $e) {
    // Safely catch and return any database errors as JSON
    echo json_encode(['error' => 'Database Error: ' . $e->getMessage()]);
}
?>