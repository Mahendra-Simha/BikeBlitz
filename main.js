document.addEventListener('DOMContentLoaded', function() {
    fetch('fetch_items.php')
    .then(response => response.json())
    .then(items => {
        const container = document.getElementById('itemsContainer');
        items.forEach(item => {
            const itemBox = document.createElement('div');
            itemBox.classList.add('box');
            itemBox.innerHTML = `
                <img src="${item.image}" alt="${item.name}" class="box-img">
                <h3>Model - ${item.name}</h3>
                <p>Price - ₹${item.price}</p>
                <button class="btn" onclick="bookNow('${item.name}', '${item.price}')">Book Now</button>
            `;
            container.appendChild(itemBox);
        });
    });
});

function bookNow(name, price) {
    alert(`Booking ${name} for ₹${price}`);
}
