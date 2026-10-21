<?php
// 1. SECURITY UPGRADE: Securely fetch the item details using the ID from the URL
require_once 'db.php';
session_start();

// Ensure the user is logged in before checking out
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

$item_id = $_GET['item_id'] ?? '';
$product_name = '';
$price = '';

// Fetch the real, untampered price from the database
if (!empty($item_id) && is_numeric($item_id)) {
    $stmt = $pdo->prepare("SELECT name, price FROM items WHERE id = ?");
    $stmt->execute([$item_id]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($item) {
        $product_name = $item['name'];
        $price = $item['price'];
    } else {
        die("Invalid Item ID.");
    }
} else {
    die("No item selected for checkout.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - BikeBlitz</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mukta:wght@200;300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="Bg remove.png">
    <style>
        body {
            font-family: 'Mukta', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            margin-top: 130px;
            /* FIXED: Prevents overlap from fixed navbar */
        }

        .checkout-container {
            width: 900px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .checkout-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
            font-size: 24px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin: 10px 0 5px;
            font-weight: bold;
            color: #333;
            font-size: 16px;
        }

        input[type="text"],
        input[type="email"],
        select {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        select:focus {
            border-color: #007bff;
            outline: none;
        }

        button {
            background-color: #111111;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #00ccff;
        }

        #payment-details {
            margin-top: 20px;
        }

        .navbar {
            border-bottom: 1px solid black;
            background-color: #111111;
            width: 100%;
            height: 115px;
            text-align: center;
            position: fixed;
            /* Keep it fixed to the top */
            top: 0;
            left: 0;
            z-index: 1000;
            padding-top: 8px;
        }

        .logo img {
            width: 15%;
        }

        #otpInput {
            display: none;
            margin-top: 15px;
        }

        #resendOtpBtn {
            background-color: #28a745;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
            display: none;
            transition: background-color 0.3s ease;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="logo">
            <a href="home.html"><img src="Bg remove.png" alt="Logo"></a>
        </div>
    </nav>
    <div class="checkout-container">
        <h2>Checkout</h2>
        <form id="checkout-form" method="POST" action="process_checkout.php">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="product-name">Product Name:</label>
            <!-- Injected securely from PHP -->
            <input type="text" id="product-name" name="product-name"
                value="<?php echo htmlspecialchars($product_name); ?>" readonly>

            <label for="price">Price:</label>
            <!-- Injected securely from PHP -->
            <input type="text" id="price" name="price" value="<?php echo htmlspecialchars($price); ?>" readonly>

            <label for="pincode">Pincode:</label>
            <input type="text" id="pincode" name="pincode" required>

            <label for="placename">Place Name:</label>
            <input type="text" id="placename" name="placename" required>

            <label for="insurance-type">Insurance Type:</label>
            <select id="insurance-type" name="insurance-type">
                <option value="" disabled selected>Select Insurance Type</option>
                <option value="Carrier Insurance" data-price="750">Carrier Insurance - ₹750</option>
                <option value="Third-Party Insurance" data-price="1500">Third-Party Insurance - ₹1500</option>
                <option value="Declared Value Coverage" data-price="2500">Declared Value Coverage - ₹2500</option>
                <option value="Comprehensive Insurance" data-price="3500">Comprehensive Insurance - ₹3500</option>
            </select>
            <a href="insurance.html" style="margin-bottom: 15px; display: inline-block;">Click here to know about the
                insurance!</a>

            <label for="insurance-price">Insurance Price:</label>
            <input type="text" id="insurance-price" name="insurance-price" value="0" readonly>

            <label for="total-price">Total Price:</label>
            <input type="text" id="total-price" name="total-price" readonly>

            <label for="starting-point">Starting Point:</label>
            <select id="starting-point" name="starting-point" required>
                <option value="">Select Starting Point...</option>
                <option value="Bangalore">Bangalore</option>
                <option value="Mysore">Mysore</option>
                <option value="Mangalore">Mangalore</option>
                <option value="Davanagere">Davanagere</option>
                <option value="Bellary">Bellary</option>
                <option value="Harapanahalli">Harapanahalli</option>
                <option value="Mumbai">Mumbai</option>
                <option value="Delhi">Delhi</option>
                <option value="Haryana">Haryana</option>
                <option value="Jammu & Kashmir">Jammu & Kashmir</option>
                <option value="Ladakh">Ladakh</option>
                <option value="Manali">Manali</option>
                <option value="Srinagar">Srinagar</option>
            </select>

            <label for="dropping-point">Dropping Point:</label>
            <select id="dropping-point" name="dropping-point" required>
                <option value="">Select Dropping Point...</option>
                <option value="Bangalore">Bangalore</option>
                <option value="Mysore">Mysore</option>
                <option value="Mangalore">Mangalore</option>
                <option value="Davanagere">Davanagere</option>
                <option value="Bellary">Bellary</option>
                <option value="Harapanahalli">Harapanahalli</option>
                <option value="Mumbai">Mumbai</option>
                <option value="Delhi">Delhi</option>
                <option value="Haryana">Haryana</option>
                <option value="Jammu & Kashmir">Jammu & Kashmir</option>
                <option value="Ladakh">Ladakh</option>
                <option value="Manali">Manali</option>
                <option value="Srinagar">Srinagar</option>
            </select>

            <label for="address">Destination Address:</label>
            <input type="text" id="address" name="address" required>

            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phone" required>

            <label for="payment-method">Payment Method:</label>
            <select id="payment-method" name="payment-method" required>
                <option value="" disabled selected>Select Payment Method</option>
                <option value="credit-card">Credit Card</option>
                <option value="debit-card">Debit Card</option>
                <option value="paypal">PayPal</option>
                <option value="net-banking">Net Banking</option>
                <option value="upi">UPI</option>
            </select>

            <div id="payment-details"></div>

            <div id="otpSection" style="display: none; margin-top: 20px;">
                <label for="otpInput">Enter OTP:</label>
                <input type="text" id="otpInput" name="otp" required style="display: inline-block;" disabled>
                <!-- FIXED: Changed type="submit" to type="button" to prevent premature form submission -->
                <button type="button" id="submitOtpBtn" style="font-family: 'Mukta', sans-serif;" disabled>Submit
                    OTP</button>
                <button type="button" id="resendOtpBtn" style="display: none; font-family: 'Mukta', sans-serif;">Resend
                    OTP</button>
            </div>

            <button type="button" id="placeOrderBtn" style="font-family: 'Mukta', sans-serif; margin-top: 15px;">Place
                Order</button>

        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Insurance calculation logic
            const insuranceTypeSelect = document.getElementById('insurance-type');
            const insurancePriceInput = document.getElementById('insurance-price');
            const priceInput = document.getElementById('price');
            const totalPriceInput = document.getElementById('total-price');

            insuranceTypeSelect.addEventListener('change', function () {
                const basePrice = parseFloat(priceInput.value) || 0;
                const selectedOption = this.options[this.selectedIndex];
                const insurancePrice = parseFloat(selectedOption.getAttribute('data-price')) || 0;

                if (!isNaN(insurancePrice)) {
                    insurancePriceInput.value = insurancePrice.toFixed(2);
                    const totalPrice = basePrice + insurancePrice;
                    totalPriceInput.value = totalPrice.toFixed(2); // Removed inline ₹ so it passes cleanly to PHP
                } else {
                    insurancePriceInput.value = '0.00';
                    totalPriceInput.value = basePrice.toFixed(2);
                }
            });

            // Trigger calculation on page load
            insuranceTypeSelect.dispatchEvent(new Event('change'));

            // Payment Method Logic
            document.getElementById('payment-method').addEventListener('change', function () {
                const paymentDetailsDiv = document.getElementById('payment-details');
                const selectedMethod = this.value;
                paymentDetailsDiv.innerHTML = '';

                if (selectedMethod === 'credit-card' || selectedMethod === 'debit-card') {
                    paymentDetailsDiv.innerHTML = `
                    <label for="card-number">Card Number:</label>
                    <input type="text" id="card-number" name="card-number" required>
                    <label for="expiry-date">Expiry Date:</label>
                    <input type="text" id="expiry-date" name="expiry-date" required>
                    <label for="cvv">CVV:</label>
                    <input type="text" id="cvv" name="cvv" required>
                `;
                } else if (selectedMethod === 'paypal') {
                    paymentDetailsDiv.innerHTML = `
                    <label for="paypal-email">PayPal Email:</label>
                    <input type="email" id="paypal-email" name="paypal-email" required>
                `;
                } else if (selectedMethod === 'net-banking') {
                    paymentDetailsDiv.innerHTML = `
                    <label for="bank-name">Bank Name:</label>
                    <input type="text" id="bank-name" name="bank-name" required>
                    <label for="account-number">Account Number:</label>
                    <input type="text" id="account-number" name="account-number" required>
                `;
                } else if (selectedMethod === 'upi') {
                    paymentDetailsDiv.innerHTML = `
                    <label for="upi-id">UPI ID:</label>
                    <input type="text" id="upi-id" name="upi-id" required>
                `;
                }
            });

            // OTP Logic
            let currentOtp;
            let isOtpVerified = false;

            function generateAndDisplayOTP() {
                // Check if form is valid before generating OTP
                if (!document.getElementById('checkout-form').checkValidity()) {
                    document.getElementById('checkout-form').reportValidity();
                    return;
                }

                const otp = Math.floor(100000 + Math.random() * 900000);
                currentOtp = otp;
                isOtpVerified = false;
                alert("Your OTP is: " + otp);

                otpInput.disabled = false;
                otpInput.value = '';
                otpInput.focus();

                otpSection.style.display = 'block';
                submitOtpBtn.disabled = false;
                resendOtpBtn.style.display = 'inline-block';
                placeOrderBtn.style.display = 'none'; // Hide place order button while verifying
            }

            const placeOrderBtn = document.getElementById('placeOrderBtn');
            const otpSection = document.getElementById('otpSection');
            const otpInput = document.getElementById('otpInput');
            const submitOtpBtn = document.getElementById('submitOtpBtn');
            const resendOtpBtn = document.getElementById('resendOtpBtn');

            placeOrderBtn.addEventListener('click', function (event) {
                event.preventDefault();
                generateAndDisplayOTP();
            });

            submitOtpBtn.addEventListener('click', function () {
                const userOtp = otpInput.value;

                if (userOtp == currentOtp) {
                    alert('OTP verified successfully!');
                    isOtpVerified = true;
                    enableOrderPlacement();
                } else {
                    alert('Incorrect OTP. Please try again.');
                    otpInput.value = '';
                    otpInput.focus();
                    isOtpVerified = false;
                }
            });

            resendOtpBtn.addEventListener('click', function () {
                generateAndDisplayOTP();
            });

            function enableOrderPlacement() {
                if (isOtpVerified) {
                    // FIXED: Actually submit the form data to process_checkout.php instead of just changing the URL!
                    document.getElementById('checkout-form').submit();
                }
            }
        });
    </script>
</body>

</html>