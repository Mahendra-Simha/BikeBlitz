document.addEventListener('DOMContentLoaded', () => {
    const carousel = document.querySelector('.carousel-inner');
    const items = document.querySelectorAll('.carousel-item');
    const prev = document.querySelector('.carousel-control-prev');
    const next = document.querySelector('.carousel-control-next');
    let index = 0;

    const updateCarousel = () => {
        carousel.style.transform = `translateX(-${index * 100}%)`;
    };

    const nextSlide = () => {
        index = (index < items.length - 1) ? index + 1 : 0;
        updateCarousel();
    };

    const prevSlide = () => {
        index = (index > 0) ? index - 1 : items.length - 1;
        updateCarousel();
    };

    prev.addEventListener('click', prevSlide);
    next.addEventListener('click', nextSlide);

    setInterval(nextSlide, 10000); // Change slide every 3 seconds
});
