/* ================================
   INTERN HUB - SCRIPT.JS
================================ */

/* Toggle Profile Menu */
function toggleProfileMenu(event) {
    event.stopPropagation();
    const menu = document.getElementById('profileMenu');
    menu.classList.toggle('show');
}

/* Close Profile Menu when clicking outside */
document.addEventListener('click', function(event) {
    const profileMenu = document.getElementById('profileMenu');
    const profileDropdown = document.querySelector('.profile-dropdown');
    
    if (profileDropdown && !profileDropdown.contains(event.target)) {
        if (profileMenu) {
            profileMenu.classList.remove('show');
        }
    }
});

/* ================================
   MOBILE MENU TOGGLE
================================ */

function toggleMobileMenu() {
    const navMenu = document.querySelector('.nav-menu');
    navMenu.classList.toggle('active');
}
