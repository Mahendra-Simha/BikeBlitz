<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Harley Davidson</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mukta:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="Images/HD logo.jpg">
    <link rel="stylesheet" type="text/css" href="category.css">
    <link rel="stylesheet" type="text/css" href="search.css">
</head>
<style>
    .main-img {
        width: 20%;
        display: block;
        margin: 20px auto;
        /* Adjusted margin to center the image horizontally */
        border-radius: 12px;
        padding: 10px 20px;
    }

    main {
        padding: 1rem;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        /* 4 columns */
        gap: 1rem;
        /* Space between items */
        justify-content: center;
        /* Center the grid */
        margin: auto;
    }
</style>

<body>
    <nav class="navbar">
        <div class="logo">
            <a href="home.html"><img src="Bg remove.png" alt="Logo"></a>
        </div>
    </nav>
    <img src="Images/HD logo.jpg" alt="HD logo" class="main-img">
    <div class="search-container">
        <input type="text" id="searchInput" placeholder="Search for bikes...">
        <button onclick="searchBikes()">Search</button>
    </div>
    <main id="itemsListSection">
        <!-- Items will be loaded here -->
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
    fetchItems('Harley Davidson');
});

function fetchItems(category) {
    // 1. URL-encode the category to safely handle the space in "Harley Davidson"
    fetch(`fetch_items_by_category.php?category=${encodeURIComponent(category)}`)
        .then(response => response.json())
        .then(data => {
            // 2. Handle the specific error JSON we set up in your backend
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
    itemsListSection.innerHTML = ''; // Clear existing content

    // 3. Gracefully handle an empty category
    if (items.length === 0) {
        itemsListSection.innerHTML = '<p>No bikes found in this category.</p>';
        return;
    }

    items.forEach(item => {
        const box = document.createElement('div');
        box.className = 'box';
        // 4. BIG FIX: Pass the item.id into the bookNow function instead of the price!
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
    // Alert the user
    alert(`Redirecting to booking for: ${model}`);

    // 5. Send the secure ID in the URL, NOT the price!
    window.location.href = `checkout.html?item_id=${encodeURIComponent(id)}`;
}
    </script>
    <script src="search.js"></script>
</body>

</html>