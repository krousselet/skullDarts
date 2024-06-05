document.addEventListener('DOMContentLoaded', () => {
    const swiper = new Swiper('.swiper', {
        slidesPerView: 1,
        spaceBetween: 10,
        // breakpoints: {
        //     320: {
        //         slidesPerView: 1,
        //         spaceBetween: 20
        //     },
        //     480: {
        //         slidesPerView: 2,
        //         spaceBetween: 30
        //     },
        //     640: {
        //         slidesPerView: 3,
        //         spaceBetween: 40
        //     }
        // },
        autoplay: {
            delay: 5000,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
            bulletClass: 'swiper-pagination-bullet',
            bulletActiveClass: 'swiper-pagination-bullet-active',
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        }
    });
});
