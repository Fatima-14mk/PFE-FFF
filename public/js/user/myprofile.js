document.addEventListener('DOMContentLoaded', () => {
    // Éléments du DOM
    const menuToggle = document.querySelector('.menu-toggle');
    const nav = document.querySelector('nav');
    const menu = document.querySelector('.menu');
    const settingsBtn = document.getElementById('settings-btn');
    const dropdownMenu = document.getElementById('dropdown-menu');
    const tabLinks = document.querySelectorAll('.settings-link');
    const tabContents = document.querySelectorAll('.tab-content');
    const fileInput = document.querySelector('.file-input');
    const profileImage = document.querySelector('.profile-image');
    const uploadBtn = document.querySelector('.btn-outline');
    const resetBtn = document.querySelector('.profile-photo .btn-default');
    const saveBtn = document.querySelector('.btn-primary');
    const cancelBtn = document.querySelector('.buttons-container .btn-default');

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


    // 3. Gestion des onglets
    tabLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Retirer l'onglet actif
            tabLinks.forEach(tab => tab.classList.remove('active'));
            tabContents.forEach(content => {
                content.classList.remove('active');
                content.style.display = 'none';
            });

            // Activer l'onglet cliqué
            this.classList.add('active');
            const tabId = this.getAttribute('data-tab');
            const selectedTab = document.getElementById(tabId);
            if (selectedTab) {
                selectedTab.classList.add('active');
                selectedTab.style.display = 'block';
            }
        });
    });

    // 4. Upload d'image de profil
    if (fileInput && profileImage) {
        fileInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (!file) return;
            
            if (!file.type.startsWith('image/')) {
                alert('Veuillez sélectionner une image valide.');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                profileImage.src = e.target.result;
            };
            reader.readAsDataURL(file);
        });
    }

    if (uploadBtn && fileInput) {
        uploadBtn.addEventListener('click', () => {
            fileInput.click();
        });
    }

    // 5. Réinitialisation de la photo
    if (resetBtn) {
        resetBtn.addEventListener('click', function() {
            showConfirmModal('Are you sure you want to reset your profile photo?', function() {
                showNotification('Profile photo reset successfully!');
            });
        });
    }

    // 6. Confirmation de sauvegarde
    if (saveBtn) {
        saveBtn.addEventListener('click', function() {
            showConfirmModal('Are you sure you want to save?', function() {
                showNotification('Changes saved successfully!');
            });
        });
    }

    // 7. Annulation des modifications
    if (cancelBtn) {
        cancelBtn.addEventListener('click', function() {
            showConfirmModal('Are you sure you want to cancel?', function() {
                window.location.reload();
            });
        });
    }

    // Fonctions utilitaires
    function showConfirmModal(message, confirmCallback) {
        const overlay = document.createElement('div');
        overlay.className = 'modal-overlay';

        const modal = document.createElement('div');
        modal.className = 'modal-container';

        const messageElement = document.createElement('p');
        messageElement.textContent = message;

        const buttonsContainer = document.createElement('div');
        buttonsContainer.className = 'modal-buttons';

        const confirmButton = document.createElement('button');
        confirmButton.className = 'btn btn-primary modal-btn';
        confirmButton.textContent = 'Yes';
        confirmButton.addEventListener('click', function() {
            document.body.removeChild(overlay);
            if (confirmCallback) confirmCallback();
        });

        const cancelButton = document.createElement('button');
        cancelButton.className = 'btn btn-default modal-btn';
        cancelButton.textContent = 'No';
        cancelButton.addEventListener('click', function() {
            document.body.removeChild(overlay);
        });

        buttonsContainer.appendChild(confirmButton);
        buttonsContainer.appendChild(cancelButton);
        modal.appendChild(messageElement);
        modal.appendChild(buttonsContainer);
        overlay.appendChild(modal);
        document.body.appendChild(overlay);
    }

    function showNotification(message) {
        const notification = document.createElement('div');
        notification.className = 'notification';
        notification.textContent = message;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, 3000);
    }

    // Accessibilité - fermeture avec Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            if (menu) menu.classList.remove('active');
            if (nav) nav.classList.remove('menu-open');
            if (dropdownMenu) dropdownMenu.classList.remove('show');
        }
    });
});