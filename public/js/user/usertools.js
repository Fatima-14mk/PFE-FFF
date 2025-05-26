document.addEventListener('DOMContentLoaded', () => {
    // Éléments du DOM
    const menuToggle = document.querySelector('.menu-toggle');     // pour ouvrir/fermer le menu mobile
const nav = document.querySelector('nav');                     // pour ajouter/enlever la classe "menu-open"
const menu = document.querySelector('.menu');                  // le menu mobile à afficher/masquer
const settingsBtn = document.getElementById('settings-btn');   // bouton qui ouvre le menu déroulant
const dropdownMenu = document.getElementById('dropdown-menu'); // le menu déroulant "settings"
const modal = document.getElementById('detail-modal');         // fenêtre modale
const closeButton = document.querySelector('.close-btn');      // bouton pour fermer la modale


    // 1. Gestion du menu mobile
    if (menuToggle && menu) {
        menuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Fermer le dropdown settings si ouvert
            if (dropdownMenu) dropdownMenu.classList.remove('show');
            
            // Basculer le menu principal
            menu.classList.toggle('active');
            nav.classList.toggle('menu-open');
        });
        // Fermer le menu au clic ailleurs
        document.addEventListener('click', function(e) {
            if (!e.target.closest('nav')) {
                menu.classList.remove('active');
                nav.classList.remove('menu-open');
            }
        });
    }

    // 2. Gestion du dropdown settings
   if (settingsBtn && dropdownMenu) {
    settingsBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        // Afficher / masquer le dropdown sans toucher au menu mobile
        dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
    });

    // Fermer le dropdown si on clique ailleurs
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.menu-container')) {
            dropdownMenu.style.display = 'none';
        }
    });
}

    // Fermeture du modal
    if (closeButton) {
        closeButton.addEventListener('click', closeModal);
    }

    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    }

    // Fermeture avec Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal && modal.style.display === 'flex') {
            closeModal();
        }
    });

    // 4. Adaptation au redimensionnement
    window.addEventListener('resize', function() {
        // Réinitialiser les menus si on passe en desktop
        if (window.innerWidth > 991) {
            if (menu) menu.classList.remove('active');
            if (nav) nav.classList.remove('menu-open');
            if (dropdownMenu) dropdownMenu.classList.remove('show');
        }
    });
});