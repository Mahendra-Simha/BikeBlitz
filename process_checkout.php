<?php
require_once 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // FIXED: Redirect to login.html instead of login.php
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.html');
        exit();
    }

    // Retrieve form data safely
    $name = $_POST['name'] ?? '';
    $product_name = $_POST['product-name'] ?? '';
    $price = isset($_POST['price']) ? floatval($_POST['price']) : 0.0;
    $address = $_POST['address'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $payment_method = $_POST['payment-method'] ?? '';
    $starting_point = $_POST['starting-point'] ?? '';
    $dropping_point = $_POST['dropping-point'] ?? '';
    $insurance_type = $_POST['insurance-type'] ?? '';
    $insurance_price = isset($_POST['insurance-price']) ? floatval($_POST['insurance-price']) : 0.0;

    // Calculate total price
    $total_price = $price + $insurance_price;

    // SECURITY FIX: Safely handle payment details (PCI Compliance)
    $payment_details = '';
    
    if ($payment_method == 'credit-card' || $payment_method == 'debit-card') {
        $card_number = $_POST['card-number'] ?? '';
        
        // Mask the card number to only show the last 4 digits
        $last_four = substr($card_number, -4);
        $masked_card = str_repeat('*', 12) . $last_four;
        
        // We DO NOT save the CVV or Expiry Date to the database. 
        $payment_details = "Card Number: $masked_card";
        
    } elseif ($payment_method == 'paypal') {
        $paypal_email = $_POST['paypal-email'] ?? '';
        $payment_details = "PayPal Email: $paypal_email";
        
    } elseif ($payment_method == 'net-banking') {
        $bank_name = $_POST['bank-name'] ?? '';
        // It is also good practice to mask bank account numbers!
        $account_number = $_POST['account-number'] ?? '';
        $masked_account = str_repeat('*', max(0, strlen($account_number) - 4)) . substr($account_number, -4);
        $payment_details = "Bank Name: $bank_name, Account Number: $masked_account";
        
    } elseif ($payment_method == 'upi') {
        $upi_id = $_POST['upi-id'] ?? '';
        $payment_details = "UPI ID: $upi_id";
    }

    try {
        // Insert order into the database
        $stmt = $pdo->prepare('
            INSERT INTO orders 
            (user_id, name, product_name, price, insurance_type, insurance_price, total_price, address, phone, payment_method, payment_details, starting_point, dropping_point) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ');
        
        $stmt->execute([
            $_SESSION['user_id'],
            $name,
            $product_name,
            $price,
            $insurance_type,
            $insurance_price,
            $total_price,
            $address,
            $phone,
            $payment_method,
            $payment_details,
            $starting_point,
            $dropping_point
        ]);

        // Store order details in session for the summary page
        $_SESSION['orderDetails'] = [
            'name' => $name,
            'product_name' => $product_name,
            'price' => $price,
            'insurance_type' => $insurance_type,
            'insurance_price' => $insurance_price,
            'total_price' => $total_price,
            'address' => $address,
            'phone' => $phone,
            'payment_method' => $payment_method,
            'starting_point' => $starting_point,
            'dropping_point' => $dropping_point
        ];

        // Redirect to the order summary page
        header('Location: order_summary.php');
        exit();
        
    } catch (PDOException $e) {
        // Added error handling in case the insert fails
        die("Database Error: " . $e->getMessage());
    }
}
?>