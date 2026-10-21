<?php
session_start();

if (!isset($_SESSION['orderDetails'])) {
    echo "No order details available.";
    exit;
}

$orderDetails = $_SESSION['orderDetails'];

// SECURITY FIX: Sanitize all variables immediately upon extraction to prevent XSS
$name = htmlspecialchars($orderDetails['name']);
$product_name = htmlspecialchars($orderDetails['product_name']);
$price = htmlspecialchars($orderDetails['price']);
$insurance_type = htmlspecialchars($orderDetails['insurance_type']);
$insurance_price = htmlspecialchars($orderDetails['insurance_price']);
$total_price = htmlspecialchars($orderDetails['total_price']);
$address = htmlspecialchars($orderDetails['address']);
$phone = htmlspecialchars($orderDetails['phone']);
$payment_method = htmlspecialchars($orderDetails['payment_method']);
$starting_point = htmlspecialchars($orderDetails['starting_point']);
$dropping_point = htmlspecialchars($orderDetails['dropping_point']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Summary - BikeBlitz</title>
    <style>
        body { 
            font-family: 'Mukta', 'Arial', sans-serif; /* Matched your global font */
            background-color: #f4f4f4; 
            margin: 0; 
            padding: 0; 
        }
        .container { 
            width: 80%; 
            max-width: 800px; /* Added max-width so it doesn't stretch too far on huge screens */
            margin: 40px auto; 
            padding: 30px; 
            background-color: #fff; 
            border-radius: 8px; 
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2); 
            animation: fadeIn 1.5s ease-in-out;
            transform: translateY(0);
            transition: all 0.3s ease;
        }
        h1 { 
            text-align: center; 
            color: #333; 
            font-size: 2em;
            margin-bottom: 20px;
        }
        h2 {
            text-align: center;
            color: #28a745; /* Made the thank you text a nice success green */
            margin-bottom: 30px;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo img {
            width: 150px; /* Fixed width looks better than percentages for logos */
        }
        .order-summary { 
            padding: 20px; 
            font-size: 1.1em; 
            line-height: 1.6;
            color: #666; 
            background-color: #f9f9f9; /* Gave the receipt details a slight background contrast */
            border-radius: 8px;
        }
        .order-summary h3 { 
            color: #555; 
            margin-top: 0;
            margin-bottom: 15px; 
            font-size: 1.5em;
            text-transform: uppercase;
            border-bottom: 2px solid #333;
            padding-bottom: 5px;
        }
        .order-summary p { 
            margin: 10px 0; 
        }
        .order-summary p strong { 
            color: #333; 
            font-weight: 600;
        }
        .order-summary .total { 
            font-weight: bold; 
            font-size: 1.3em; 
            color: #000; 
            margin-top: 20px;
            border-top: 1px dashed #ccc;
            padding-top: 15px;
        }
        .redirect-msg {
            text-align: center;
            font-size: 0.9em;
            color: #888;
            margin-top: 30px;
        }
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(-20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
    </style>
    <script>
        // UX FIX: Let the user know they are being redirected
        setTimeout(function() {
            window.location.href = 'welcome.php';
        }, 10000); // 10 seconds
    </script>
</head>
<body>
    <div class='container'>
        <!-- Moved Logo and Header inside the container -->
        <div class="logo">
            <img src="Bg remove.png" alt="Company Logo">
        </div>
        
        <h2>Thanks for Booking! Your Bike is safe as a newborn baby.</h2>
        <h1>Order Summary</h1>
        
        <div class='order-summary'>
            <h3>Order Details</h3>
            <p><strong>Name:</strong> <?php echo $name; ?></p>
            <p><strong>Product Name:</strong> <?php echo $product_name; ?></p>
            <p><strong>Price:</strong> ₹<?php echo $price; ?></p>
            <p><strong>Insurance Type:</strong> <?php echo $insurance_type; ?></p>
            <p><strong>Insurance Price:</strong> ₹<?php echo $insurance_price; ?></p>
            <p class='total'><strong>Total Price:</strong> ₹<?php echo $total_price; ?></p>
            <p><strong>Address:</strong> <?php echo $address; ?></p>
            <p><strong>Phone:</strong> <?php echo $phone; ?></p>
            <p><strong>Payment Method:</strong> <?php echo $payment_method; ?></p>
            <p><strong>Starting Point:</strong> <?php echo $starting_point; ?></p>
            <p><strong>Dropping Point:</strong> <?php echo $dropping_point; ?></p>
        </div>
        
        <p class="redirect-msg">You will be redirected to your dashboard in 10 seconds...</p>
    </div>
</body>
</html>