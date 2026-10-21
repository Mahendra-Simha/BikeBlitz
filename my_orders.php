<?php
require_once 'db.php';
session_start();

// 1. FIXED: Redirect unauthorized users back to login instead of killing the page
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    $stmt = $pdo->prepare('SELECT * FROM orders WHERE user_id = ?');
    $stmt->execute([$user_id]);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Graceful error handling
    die('<script>alert("Error loading orders. Please try again later."); window.location.href="home.html";</script>');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders - BikeBlitz</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mukta:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="Bg remove.png">
    <style>
        /* General Body Styling */
        body {
            font-family: 'Mukta', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        /* Header Styling */
        h1 {
            text-align: center;
            color: #333;
            margin-top: 30px;
            margin-bottom: 20px;
        }

        /* Table Styling */
        table {
            width: 95%;
            border-collapse: collapse;
            margin: 0 auto 40px auto; /* Added bottom margin for spacing */
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #007BFF;
            color: #fff;
            font-weight: bold;
        }

        td {
            background-color: #f9f9f9;
        }

        tr:nth-child(even) td {
            background-color: #f2f2f2;
        }

        tr:hover td {
            background-color: #e9ecef;
        }

        .navbar {
            border-bottom: 1px solid black;
            background-color: #111111;
            width: 100%;
            height: 115px;
            text-align: center;
            /* 2. FIXED: Added top and z-index to make sticky actually work */
            position: sticky;
            top: 0;
            z-index: 1000;
            padding-top: 8px;
        }

        .logo img {
            width: 15%;
        }

        /* 3. FIXED: Styled the empty state */
        .empty-state {
            text-align: center;
            font-size: 1.2rem;
            color: #666;
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="logo">
            <a href="home.html"><img src="Bg remove.png" alt="Logo"></a>
        </div>
    </nav>
    
    <h1>My Orders</h1>
    
    <?php if (count($orders) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Insurance Type</th>
                    <th>Insurance Price</th>
                    <th>Total Price</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Payment Method</th>
                    <th>Starting Point</th>
                    <th>Dropping Point</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                        <td>₹<?php echo htmlspecialchars($order['price']); ?></td> <!-- Added Rupee symbol -->
                        <td><?php echo htmlspecialchars($order['insurance_type']) ?: 'N/A'; ?></td>
                        <td>₹<?php echo htmlspecialchars($order['insurance_price']); ?></td>
                        <td>₹<?php echo htmlspecialchars($order['total_price']); ?></td>
                        <td><?php echo htmlspecialchars($order['address']); ?></td>
                        <td><?php echo htmlspecialchars($order['phone']); ?></td>
                        <td><?php echo htmlspecialchars($order['payment_method']); ?></td>
                        <td><?php echo htmlspecialchars($order['starting_point']); ?></td>
                        <td><?php echo htmlspecialchars($order['dropping_point']); ?></td>
                        <td><?php echo htmlspecialchars(date('d M Y', strtotime($order['created_at']))); ?></td> <!-- Formatted Date -->
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="empty-state">You haven't placed any orders yet.</p>
    <?php endif; ?>
</body>
</html>