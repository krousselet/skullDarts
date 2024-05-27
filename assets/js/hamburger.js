let hamburger = document.querySelector('.hamburger');
let upper = document.querySelector('.upper');
let middle = document.querySelector('.middle');
let lower = document.querySelector('.lower');
let mobileMenu = document.querySelector('.mobile-menu');

document.addEventListener('DOMContentLoaded', function() {
    function displayMenu() {
        upper.classList.toggle('upper-active');
        middle.classList.toggle('middle-active');
        lower.classList.toggle('lower-active');
        mobileMenu.classList.toggle('mobile-menu-active');
    }

    hamburger.onclick = () => displayMenu();
});
