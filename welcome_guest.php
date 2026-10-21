<?php
// CRITICAL FIX: Session must be started to check if they are logged in!
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - BikeBlitz</title>
    <link rel="icon" type="image/x-icon" href="Bg remove.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mukta:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="welcome.css">
    <style>
        /* FIXED: Replaced unused dropdown CSS with clean Guest Action Buttons */
        .guest-actions {
            display: flex;
            gap: 15px;
        }

        .login-btn, .signup-btn {
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .login-btn {
            background-color: transparent;
            color: #fff;
            border: 2px solid #fff;
        }

        .login-btn:hover {
            background-color: #fff;
            color: #000;
        }

        .signup-btn {
            background-color: #007BFF;
            color: #fff;
            border: 2px solid #007BFF;
        }

        .signup-btn:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .navbar {
            border-bottom: 1px solid black;
            background-color: #111111;
            width: 100%;
            height: 115px;
            text-align: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            /* FIXED: Replaced 500px padding with percentage for responsive design */
            padding: 0 5%;
            box-sizing: border-box;
        }

        .logo img {
            width: 150px; /* Fixed width prevents image explosion */
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="logo">
            <a href="home.html"><img src="Bg remove.png" alt="Logo"></a>
        </div>
        
        <!-- NEW: Guest Action Buttons -->
        <div class="guest-actions">
            <a href="login.html" class="login-btn">Log In</a>
            <a href="user.html" class="signup-btn">Sign Up</a>
        </div>
    </nav>
    
    <h2 class="h2-style" style="text-align: center; margin-top: 30px;">Select your Category</h2>
    <div class="container">
        <!-- FIXED: Image Backslashes converted to Forward Slashes -->
        <div class="box" data-link="TVS_first.php">
            <img src="Images/0-75cc.png" alt="0-75cc" class="box-img">
            <h2 class="box-h2">0-75cc</h2>
        </div>
        <div class="box">
            <img src="Images/75-300cc.png" alt="75-300cc" class="box-img">
            <h2 class="box-title">75-300cc</h2>
            <div class="dropdown-menu">
                <div class="dropdown-item">
                    <a href="honda.php"><img src="Images/Honda.jpg" alt="Honda logo" class="dropdown-item-img"></a>
                </div>
                <div class="dropdown-item">
                    <a href="hero_honda.php"><img src="Images/hero honda.png" alt="Hero logo" class="dropdown-item-img"></a>
                </div>
                <div class="dropdown-item">
                    <a href="TVS_first.php"><img src="Images/tvs logo.jpg" alt="tvs logo" class="dropdown-item-img"></a>
                </div>
                <div class="dropdown-item">
                    <a href="Bajaj_second.php"><img src="Images/bajaj new logo.jpg" alt="Bajaj logo" class="dropdown-item-img"></a>
                </div>
                <div class="dropdown-item">
                    <a href="yezdi.php"><img src="Images/yezdi.png" alt="yezdi logo" class="dropdown-item-img"></a>
                </div>
                <div class="dropdown-item">
                    <a href="suzuki.php"><img src="Images/suzuki logo.jpg" alt="kawasaki logo" class="dropdown-item-img"></a>
                </div>
            </div>
        </div>
        <div class="box">
            <img src="Images/300-1000cc.png" alt="300-1000cc" class="box-img">
            <h2 class="box-title">300-1000cc</h2>
            <div class="dropdown-menu">
                <div class="dropdown-item">
                    <a href="ktm.php"><img src="Images/KTM logo.jpg" alt="ktm logo" class="dropdown-item-img"></a>
                </div>
                <div class="dropdown-item">
                    <a href="bajaj_third.php"><img src="Images/bajaj new logo.jpg" alt="bajaj logo" class="dropdown-item-img"></a>
                </div>
                <div class="dropdown-item">
                    <a href="RE.php"><img src="Images/royal enfield.jpg" alt="RE logo" class="dropdown-item-img"></a>
                </div>
                <div class="dropdown-item">
                    <a href="jawa.php"><img src="Images/jawa logo.jpg" alt="jawa logo" class="dropdown-item-img"></a>
                </div>
                <div class="dropdown-item">
                    <a href="benelli.php"><img src="Images/Benelli.jpg" alt="Beneli logo" class="dropdown-item-img"></a>
                </div>
                <div class="dropdown-item">
                    <a href="kawasaki.php"><img src="Images/Kawasaki logo.png" alt="kawasaki logo" class="dropdown-item-img"></a>
                </div>
                <div class="dropdown-item">
                    <a href="triumph.php"><img src="Images/triumph logo.jpg" alt="Triumph logo" class="dropdown-item-img"></a>
                </div>
                <div class="dropdown-item">
                    <a href="BMW.php"><img src="Images/BMW logo.jpg" alt="BMW logo" class="dropdown-item-img"></a>
                </div>
                <div class="dropdown-item">
                    <a href="harley.php"><img src="Images/HD logo.jpg" alt="Harley logo" class="dropdown-item-img"></a>
                </div>
                <div class="dropdown-item">
                    <a href="honda_Bigwing.php"><img src="Images/Honda.jpg" alt="Honda logo" class="dropdown-item-img"></a>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Check PHP session state
            const isLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;

            // FIXED: Robust interceptor for guests clicking anywhere in the categories
            document.body.addEventListener('click', function(e) {
                // Check if they clicked an <a> tag in the dropdown, or a box with a data-link
                const targetLink = e.target.closest('.dropdown-item a');
                const targetBox = e.target.closest('.box[data-link]');

                if (targetLink || targetBox) {
                    if (!isLoggedIn) {
                        e.preventDefault(); // Stop them from navigating
                        alert('Please login first to view bikes and make a booking!');
                        window.location.href = 'login.html';
                    } else if (targetBox && !targetLink) {
                        // Only trigger the box redirect if they didn't click an actual <a> tag inside it
                        window.location.href = targetBox.getAttribute('data-link');
                    }
                }
            });
        });
    </script>
</body>
</html>