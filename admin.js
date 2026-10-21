document.getElementById('addItemForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch('add_item.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => alert(data));
});

document.getElementById('deleteItemForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch('delete_item.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => alert(data));
});

document.getElementById('updateItemForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch('update_item.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => alert(data));
});
 // admin.js
document.getElementById('addItemForm').onsubmit = function() {
    alert("Item added successfully!");
};

document.getElementById('deleteItemForm').onsubmit = function() {
    alert("Item deleted successfully!");
};

document.getElementById('updateItemForm').onsubmit = function() {
    alert("Item updated successfully!");
};
