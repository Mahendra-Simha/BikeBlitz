<?php
header('Content-Type: application/json');

// 1. Include your central database connection
require_once 'db.php';

// Safely retrieve POST data
$category = $_POST['category'] ?? '';
$name = $_POST['name'] ?? '';
$description = $_POST['description'] ?? '';
$price = $_POST['price'] ?? '';
$image = $_FILES['image'] ?? null;

// Basic validation to ensure required fields aren't empty
if (empty($category) || empty($name)) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

try {
    // 2. Get category_id from category name using PDO
    $stmt = $pdo->prepare("SELECT id FROM categories WHERE name = ?");
    $stmt->execute([$category]);
    $categoryIdRow = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$categoryIdRow) {
        echo json_encode(['success' => false, 'message' => 'Invalid category']);
        exit;
    }

    $categoryId = $categoryIdRow['id'];

    // 3. Check if the item already exists in this category using PDO
    $checkStmt = $pdo->prepare("SELECT id FROM items WHERE category_id = ? AND name = ?");
    $checkStmt->execute([$categoryId, $name]);
    
    if ($checkStmt->rowCount() > 0) {
        echo json_encode(['success' => false, 'message' => 'Item already exists']);
        exit;
    }

    // 4. Handle file upload safely (prevent overwrites and missing directories)
    $uploadDir = 'uploads/';
    $imagePath = '';
    
    if ($image && $image['error'] === UPLOAD_ERR_OK) {
        // Automatically create the uploads folder if it doesn't exist yet
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        // Add a timestamp to the filename so images never overwrite each other
        $uniqueFileName = time() . '_' . basename($image['name']);
        $newImagePath = $uploadDir . $uniqueFileName;
        
        if (move_uploaded_file($image['tmp_name'], $newImagePath)) {
            $imagePath = $newImagePath;
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to upload image to server directory']);
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'A valid image file is required']);
        exit;
    }

    // 5. Prepare and execute the insert query using PDO
    $insertQuery = "INSERT INTO items (category_id, name, description, price, image_path) VALUES (?, ?, ?, ?, ?)";
    $insertStmt = $pdo->prepare($insertQuery);
    
    if ($insertStmt->execute([$categoryId, $name, $description, $price, $imagePath])) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add item to database']);
    }

} catch (PDOException $e) {
    // Safely catch any database errors and return them as JSON
    echo json_encode(['success' => false, 'message' => 'Database Error: ' . $e->getMessage()]);
}
?>