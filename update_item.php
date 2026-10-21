<?php
header('Content-Type: application/json');

// 1. Include your central database connection
require_once 'db.php';

// Retrieve POST data safely
$id = $_POST['id'] ?? '';
$category = $_POST['category'] ?? '';
$name = $_POST['name'] ?? '';
$description = $_POST['description'] ?? '';
$price = $_POST['price'] ?? '';
$existingImage = $_POST['existing_image'] ?? '';
$image = $_FILES['image'] ?? null;

// Basic validation
if (empty($id) || empty($category)) {
    echo json_encode(['success' => false, 'message' => 'Missing item ID or category name']);
    exit;
}

try {
    // 2. Get category_id from category name using PDO
    $stmt = $pdo->prepare("SELECT id FROM categories WHERE name = ?");
    $stmt->execute([$category]);
    $categoryIdRow = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if category is valid
    if (!$categoryIdRow) {
        echo json_encode(['success' => false, 'message' => 'Invalid category']);
        exit;
    }

    $categoryId = $categoryIdRow['id'];

    // 3. Handle file upload safely
    $uploadDir = 'uploads/';
    $imagePath = $existingImage; // Default to the existing image if no new one is uploaded

    if ($image && $image['error'] === UPLOAD_ERR_OK) {
        // Ensure the uploads directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        // FIX: Add a timestamp to the filename so images with the same name don't overwrite each other
        $uniqueFileName = time() . '_' . basename($image['name']);
        $newImagePath = $uploadDir . $uniqueFileName;
        
        if (move_uploaded_file($image['tmp_name'], $newImagePath)) {
            $imagePath = $newImagePath; // Update the path only if the upload succeeds
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to upload new image']);
            exit;
        }
    }

    // 4. Prepare and execute the update query using PDO
    $query = "UPDATE items SET category_id = ?, name = ?, description = ?, price = ?, image_path = ? WHERE id = ?";
    $updateStmt = $pdo->prepare($query);
    
    // Execute passes the array of values in the exact order of the ? placeholders
    $success = $updateStmt->execute([$categoryId, $name, $description, $price, $imagePath, $id]);

    if ($success) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update item in the database']);
    }

} catch (PDOException $e) {
    // Safely catch any database errors and return them as JSON
    echo json_encode(['success' => false, 'message' => 'Database Error: ' . $e->getMessage()]);
}
?>