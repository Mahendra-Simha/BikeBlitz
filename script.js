document.addEventListener('DOMContentLoaded', () => {
    fetchItemsByCategory();
});

function fetchItemsByCategory() {
    const category = document.getElementById('categorySelect').value;
    
    if (!category) {
        document.getElementById('itemList').innerHTML = '';
        return;
    }

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
    const itemList = document.getElementById('itemList');
    itemList.innerHTML = ''; // Clear existing content

    items.forEach(item => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${item.id}</td>
            <td>${item.category_id}</td>
            <td>${item.name}</td>
            <td>${item.description}</td>
            <td>${item.price}</td>
            <td><img src="${item.image_path}" alt="${item.name}" style="width:100px;"></td>
            <td>
                <button onclick="updateItem(${item.id})">Update</button>
                <button onclick="deleteItem(${item.id})">Delete</button>
            </td>
        `;
        itemList.appendChild(row);
    });
}

function addItem() {
    const form = document.getElementById('itemForm');
    const formData = new FormData(form);

    fetch('add_item.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            alert('Item added successfully');
            fetchItemsByCategory(); // Refresh the item list
        } else {
            alert(result.message);
        }
    })
    .catch(error => console.error('Error:', error));
}

function updateItem(id) {
    fetch(`fetch_item.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data) {
                document.getElementById('updateId').value = data.id;
                document.getElementById('updateCategory').value = data.category_id;
                document.getElementById('updateName').value = data.name;
                document.getElementById('updateDescription').value = data.description;
                document.getElementById('updatePrice').value = data.price;
                document.getElementById('existingImage').value = data.image_path;
                document.getElementById('currentImage').src = data.image_path;
                document.getElementById('updateItemSection').style.display = 'block';
            } else {
                alert('Item not found');
            }
        })
        .catch(error => console.error('Error:', error));
}

function saveUpdate() {
    const form = document.getElementById('updateItemForm');
    const formData = new FormData(form);

    fetch('update_item.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            alert('Item updated successfully');
            fetchItemsByCategory(); // Refresh the item list
            cancelUpdate();
        } else {
            alert(result.message);
        }
    })
    .catch(error => console.error('Error:', error));
}

function deleteItem(id) {
    const category = document.getElementById('categorySelect').value;
    
    if (!confirm('Are you sure you want to delete this item?')) {
        return;
    }

    fetch('delete_item.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `category=${encodeURIComponent(category)}&id=${encodeURIComponent(id)}`
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            alert('Item deleted successfully');
            fetchItemsByCategory(); // Refresh the item list
        } else {
            alert(result.message);
        }
    })
    .catch(error => console.error('Error:', error));
}

function cancelUpdate() {
    document.getElementById('updateItemSection').style.display = 'none';
}
function fetchItem(id) {
    fetch(`fetch_item.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data) {
                document.getElementById('updateId').value = data.id;
                document.getElementById('updateCategory').value = data.category_id; // Ensure this value matches the category IDs in the dropdown
                document.getElementById('updateName').value = data.name;
                document.getElementById('updateDescription').value = data.description;
                document.getElementById('updatePrice').value = data.price;
                document.getElementById('existingImage').value = data.image_path;
                document.getElementById('currentImage').src = data.image_path;
                document.getElementById('currentImage').style.display = 'block';
                document.getElementById('updateItemSection').style.display = 'block';
            } else {
                alert('Item not found');
            }
        })
        .catch(error => console.error('Error fetching item:', error));
}
function fetchOrders() {
    fetch('fetch_orders.php')
        .then(response => response.json())
        .then(orders => {
            const ordersList = document.getElementById('ordersList');
            ordersList.innerHTML = ''; // Clear existing content

            orders.forEach(order => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${order.id}</td>
                    <td>${order.name}</td>
                    <td>${order.product_name}</td>
                    <td>${order.price}</td>
                    <td>${order.insurance_type || 'N/A'}</td>
                    <td>${order.insurance_price}</td>
                    <td>${order.total_price}</td>
                    <td>${order.address}</td>
                    <td>${order.phone}</td>
                    <td>${order.payment_method}</td>
                    <td>${order.starting_point}</td>
                    <td>${order.dropping_point}</td>
                    <td>${order.created_at}</td>
                `;
                ordersList.appendChild(row);
            });
        })
        .catch(error => console.error('Error fetching orders:', error));
}

// Fetch orders when the page loads
document.addEventListener('DOMContentLoaded', fetchOrders);