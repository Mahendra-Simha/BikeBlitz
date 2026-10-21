<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TVS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mukta:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- FIXED: Changed backslash to forward slash -->
    <link rel="icon" type="image/x-icon" href="Images/tvs logo.jpg">
    <link rel="stylesheet" href="category.css">
    <link rel="stylesheet" href="search.css">
    <style>
        /* FIXED: Restored the missing .main-img CSS so the logo doesn't break */
        .main-img {
            width: 20%;
            display: block;
            margin: 20px auto;
            border-radius: 12px;
            padding: 10px 20px;
        }

        main {
            padding: 1rem;
            display: grid;
            /* FIXED: Changed from repeat(2, 1fr) to repeat(4, 1fr) for consistency */
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            justify-content: center;
            margin: auto;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="logo">
            <a href="home.html"><img src="Bg remove.png" alt="Logo"></a>
        </div>
    </nav>
    
    <!-- FIXED: Changed backslash to forward slash -->
    <img src="Images/tvs_logo-removebg.png" alt="TVS logo" class="main-img">
    
    <div class="search-container">
        <input type="text" id="searchInput" placeholder="Search for bikes...">
        <button onclick="searchBikes()">Search</button>
    </div>
    
    <main id="itemsListSection">
        <!-- Items will be loaded here -->
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            fetchItems('TVS');
        });

        function fetchItems(category) {
            // Added URL encoding for safety
            fetch(`fetch_items_by_category.php?category=${encodeURIComponent(category)}`)
                .then(response => response.json())
                .then(data => {
                    // Upgraded error handling
                    if (data.error) {
                        console.error('Server Error:', data.error);
                        alert('Failed to load bikes. Please try again later.');
                    } else if (Array.isArray(data)) {
                        displayItems(data);
                    }
                })
                .catch(error => console.error('Fetch Error:', error));
        }

        function displayItems(items) {
            const itemsListSection = document.getElementById('itemsListSection');
            itemsListSection.innerHTML = ''; 

            // Empty state handler
            if (items.length === 0) {
                itemsListSection.innerHTML = '<p>No bikes found in this category.</p>';
                return;
            }

            items.forEach(item => {
                const box = document.createElement('div');
                box.className = 'box';
                // SECURITY FIX: Swapped item.price out for item.id in the onclick event
                box.innerHTML = `
                    <img src="${item.image_path}" alt="${item.name}" class="box-img">
                    <h3>Model - ${item.name}</h3>
                    <p>Price - ₹${item.price}</p>
                    <button class="btn" onclick="bookNow('${item.id}', '${item.name}')">Book Now</button>
                `;
                itemsListSection.appendChild(box);
            });
        }

        function bookNow(id, model) {
            alert(`Redirecting to booking for: ${model}`);
            // CRITICAL FIX: Pointing to checkout.php instead of checkout.html and passing the secure ID!
            window.location.href = `checkout.php?item_id=${encodeURIComponent(id)}`;
        }
    </script>
    <script src="search.js"></script>
</body>

</html>