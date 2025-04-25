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