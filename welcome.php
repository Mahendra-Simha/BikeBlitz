<?php
// CRITICAL FIX: You MUST start the session before checking $_SESSION variables!
session_start();

// Redirect to the guest page if they somehow land here without being logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: welcome_guest.php");
    exit();
}
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
        /* User menu styling */
        .user-menu-container {
            position: relative;
            display: inline-block;
        }

        .user-dropdown {
            display: none;
            position: absolute;
            top: 60px;
            right: 0; 
            background-color: aliceblue;
            border: 1px solid #ccc;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            width: 200px; 
            border-radius: 8px;
            padding: 15px;
            text-align: center;
        }

        .user-dropdown.show {
            display: block; 
        }

        .logout-btn {
            display: inline-block;
            padding: 10px;
            background-color: #ff4d4d;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            width: 90%;
            margin-top: 15px;
            font-weight: bold;
        }

        .logout-btn:hover { background-color: #e60000; }

        .my-orders-btn {
            display: inline-block;
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            width: 90%;
            margin-top: 10px;
            font-weight: bold;
        }

        .my-orders-btn:hover { background-color: #0056b3; }

        .user-logo {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            cursor: pointer;
            margin: 6px;
            background-color: #fff;
            padding: 5px;
        }

        .navbar {
            border-bottom: 1px solid black;
            background-color: #111111;
            width: 100%;
            height: 115px;
            text-align: center;
            position: sticky;
            top: 0;
            z-index: 999;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 5%; 
            box-sizing: border-box;
        }

        .logo img {
            width: 150px;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="logo">
            <a href="home.html"><img src="Bg remove.png" alt="Logo"></a>
        </div>
        
        <!-- User Menu Integration -->
        <div class="user-menu-container">
            <img src="https://cdn-icons-png.flaticon.com/512/1144/1144760.png" alt="User Profile" class="user-logo" id="userIcon">
            <div class="user-dropdown" id="userDropdown">
                <h3 style="margin-top:0; color:#333;">Welcome, <?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Rider'; ?>!</h3>
                <a href="my_orders.php" class="my-orders-btn">My Orders</a>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
        </div>
    </nav>

    <h2 class="h2-style" style="text-align: center; margin-top: 30px;">Select your Category</h2>
    
    <div class="container">
        <!-- Box 1 (Direct Link) -->
        <div class="box" data-link="TVS.php">
            <img src="Images/0-75cc.png" alt="0-75cc" class="box-img">
            <h2 class="box-h2">0-75cc</h2>
        </div>
        
        <!-- Box 2 (Dropdown) -->
        <div class="box">
            <img src="Images/75-300cc.png" alt="75-300cc" class="box-img">
            <h2 class="box-title">75-300cc</h2>
            <div class="dropdown-menu">
                <div class="dropdown-item"><a href="honda.php"><img src="Images/Honda.jpg" alt="Honda logo" class="dropdown-item-img"></a></div>
                <div class="dropdown-item"><a href="hero_honda.php"><img src="Images/hero honda.png" alt="Hero logo" class="dropdown-item-img"></a></div>
                <div class="dropdown-item"><a href="TVS_first.php"><img src="Images/tvs logo.jpg" alt="tvs logo" class="dropdown-item-img"></a></div>
                <div class="dropdown-item"><a href="Bajaj_second.php"><img src="Images/bajaj new logo.jpg" alt="Bajaj logo" class="dropdown-item-img"></a></div>
                <div class="dropdown-item"><a href="yezdi.php"><img src="Images/yezdi.png" alt="yezdi logo" class="dropdown-item-img"></a></div>
                <div class="dropdown-item"><a href="suzuki.php"><img src="Images/suzuki logo.jpg" alt="Suzuki logo" class="dropdown-item-img"></a></div>
            </div>
        </div>

        <!-- Box 3 (Dropdown) -->
        <div class="box">
            <img src="Images/300-1000cc.png" alt="300-1000cc" class="box-img">
            <h2 class="box-title">300-1000cc</h2>
            <div class="dropdown-menu">
                <div class="dropdown-item"><a href="ktm.php"><img src="Images/KTM logo.jpg" alt="ktm logo" class="dropdown-item-img"></a></div>
                <div class="dropdown-item"><a href="bajaj_third.php"><img src="Images/bajaj new logo.jpg" alt="bajaj logo" class="dropdown-item-img"></a></div>
                <div class="dropdown-item"><a href="RE.php"><img src="Images/royal enfield.jpg" alt="RE logo" class="dropdown-item-img"></a></div>
                <div class="dropdown-item"><a href="jawa.php"><img src="Images/jawa logo.jpg" alt="jawa logo" class="dropdown-item-img"></a></div>
                <div class="dropdown-item"><a href="benelli.php"><img src="Images/Benelli.jpg" alt="Beneli logo" class="dropdown-item-img"></a></div>
                <div class="dropdown-item"><a href="kawasaki.php"><img src="Images/Kawasaki logo.png" alt="kawasaki logo" class="dropdown-item-img"></a></div>
                <div class="dropdown-item"><a href="triumph.php"><img src="Images/triumph logo.jpg" alt="Triumph logo" class="dropdown-item-img"></a></div>
                <div class="dropdown-item"><a href="BMW.php"><img src="Images/BMW logo.jpg" alt="BMW logo" class="dropdown-item-img"></a></div>
                <div class="dropdown-item"><a href="harley.php"><img src="Images/HD logo.jpg" alt="Harley logo" class="dropdown-item-img"></a></div>
                <div class="dropdown-item"><a href="honda_Bigwing.php"><img src="Images/Honda.jpg" alt="Honda logo" class="dropdown-item-img"></a></div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
            // 1. Profile Menu Toggle
            const userIcon = document.getElementById('userIcon');
            const userDropdown = document.getElementById('userDropdown');
            
            if(userIcon) {
                userIcon.addEventListener('click', function(e) {
                    e.stopPropagation(); 
                    userDropdown.classList.toggle('show');
                });
            }

            // 2. Click Logic for Category Boxes & Menus
            document.body.addEventListener('click', function(e) {
                const targetLink = e.target.closest('.dropdown-item a');
                const targetBox = e.target.closest('.box');

                // A: Close the Profile Menu if clicking outside
                if(userDropdown && userDropdown.classList.contains('show') && e.target !== userIcon) {
                    userDropdown.classList.remove('show');
                }

                // B: If they click an actual image link inside a dropdown, let it redirect normally!
                if (targetLink) {
                    return; 
                }

                // C: If they click outside of ANY category box, close all category dropdowns
                if (!targetBox) {
                    document.querySelectorAll('.box .dropdown-menu').forEach(menu => {
                        menu.style.display = 'none';
                    });
                    return;
                }

                // D: If they click a Category Box...
                if (targetBox) {
                    const dataLink = targetBox.getAttribute('data-link');
                    
                    if (dataLink) {
                        // It's the 0-75cc Box -> Send them to the page!
                        window.location.href = dataLink;
                    } else {
                        // It's the 75-300cc OR 300-1000cc Box -> Toggle the dropdown menu open/closed!
                        const dropdown = targetBox.querySelector('.dropdown-menu');
                        if (dropdown) {
                            
                            // First, close any OTHER dropdowns so only one stays open at a time
                            document.querySelectorAll('.box .dropdown-menu').forEach(menu => {
                                if (menu !== dropdown) menu.style.display = 'none';
                            });

                            // Then, toggle this specific dropdown
                            const currentDisplay = window.getComputedStyle(dropdown).display;
                            dropdown.style.display = (currentDisplay === 'none') ? 'block' : 'none';
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>