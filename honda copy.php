<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Honda Items</title>
    <link rel="stylesheet" href="honda.css">
</head>

<body>
    <header>
        <h1>Honda Items</h1>
    </header>
    <main id="itemsListSection">
        <!-- Items will be loaded here -->
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            fetchItems('Honda');
        });

        function fetchItems(category) {
            fetch(`fetch_items_by_category.php?category=${category}`)
                .then(response => response.json())
                .then(data => {
                    if (Array.isArray(data)) {
                        displayItems(data);
                    } else {
                        console.error('Failed to fetch items.');
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function displayItems(items) {
            const itemsListSection = document.getElementById('itemsListSection');
            itemsListSection.innerHTML = ''; // Clear existing content

            items.forEach(item => {
                const box = document.createElement('div');
                box.className = 'box';
                box.innerHTML = `
                    <img src="${item.image_path}" alt="${item.name}" class="box-img">
                    <h3>Model - ${item.name}</h3>
                    <p>Price - ₹${item.price}</p>
                    <button class="btn" onclick="bookNow('${item.name}', '${item.price}')">Book Now</button>
                `;
                itemsListSection.appendChild(box);
            });
        }

        function bookNow(model, price) {
            alert(`Booking ${model} for ₹${price}`);
        }
    </script>
</body>

</html>