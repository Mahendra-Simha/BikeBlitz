document.addEventListener('DOMContentLoaded', function() {
    const boxes = document.querySelectorAll('.box');
    
    boxes.forEach(box => {
        const dropdownMenu = box.querySelector('.dropdown-menu');
        
        box.addEventListener('mouseenter', function() {
            dropdownMenu.style.display = 'block';
        });
        
        box.addEventListener('mouseleave', function() {
            dropdownMenu.style.display = 'none';
        });
        
        dropdownMenu.addEventListener('click', function(event) {
            if (event.target.classList.contains('dropdown-item')) {
                alert(`Selected: ${event.target.textContent}`);
            }
        });
    });
});

document.getElementById('userLogo').addEventListener('click', function() {
    var dropdown = document.getElementById('userDropdown');
    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
});
