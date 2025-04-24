document.addEventListener('DOMContentLoaded', function() {
    const swiper = new Swiper(".mySwiper", {
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        loop: true,
        autoplay: {
            delay: 4000, 
            disableOnInteraction: false, 
        },
    });
});