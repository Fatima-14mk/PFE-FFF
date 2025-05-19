// Sélection du bouton et du menu
const settingsBtn = document.getElementById("settings-btn");
const dropdownMenu = document.getElementById("dropdown-menu");

// Afficher/Masquer le menu déroulant quand on clique sur "Settings"
settingsBtn.addEventListener("click", function(event) {
    event.preventDefault(); // Empêche le lien de suivre une URL
    event.stopPropagation(); // Empêche la propagation du clic
    dropdownMenu.classList.toggle("show");
});

// Cacher le menu si on clique ailleurs
document.addEventListener("click", function(event) {
    if (!event.target.closest(".menu-container")) {
        dropdownMenu.classList.remove("show");
    }
});
// Mobile Menu Toggle
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const menu = document.querySelector('.menu');
    const register = document.querySelector('.register');
    
    menuToggle.addEventListener('click', function(e) {
        e.stopPropagation();
        menu.classList.toggle('active');
        register.classList.toggle('active');
    });
    
    // Fermer le menu quand on clique ailleurs
    document.addEventListener('click', function() {
        menu.classList.remove('active');
        register.classList.remove('active');
    });
});
