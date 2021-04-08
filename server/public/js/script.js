// Register service worker
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/js/serviceworker.js', { scope: '/' }).then(registration => {
        registration.update();
    });
}

// Bulma mobile navigation bar
const navbarBurger = document.querySelector('.navbar-burger');
const navbarMenu = document.querySelector('.navbar-menu');
if (navbarBurger != undefined && navbarMenu != undefined) {
    navbarBurger.addEventListener('click', event => {
        event.preventDefault();
        navbarBurger.classList.toggle('is-active');
        navbarMenu.classList.toggle('is-active');
    });
}

// Bulma alerts close button
const notificationDeleteButtons = document.querySelectorAll('.notification .delete');
for (let notificationDeleteButton of notificationDeleteButtons) {
    notificationDeleteButton.addEventListener('click', function (event) {
        event.preventDefault();
        this.parentNode.parentNode.removeChild(this.parentNode);
    });
}
