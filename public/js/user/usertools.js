// Sélection du bouton et du menu
const settingsBtn = document.getElementById('settings-btn');
const dropdownMenu = document.getElementById('dropdown-menu');

// Afficher/Masquer le menu déroulant quand on clique sur "Settings"
settingsBtn.addEventListener('click', function (event) {
  event.preventDefault(); // Empêche le lien de suivre une URL
  event.stopPropagation(); // Empêche la propagation du clic
  dropdownMenu.classList.toggle('show');
});

// Cacher le menu si on clique ailleurs
document.addEventListener('click', function (event) {
  if (!event.target.closest('.menu-container')) {
    dropdownMenu.classList.remove('show');
  }
});


// Fonction pour ouvrir et afficher le modal
function openModal(imageSrc, title, description) {
  const modal = document.getElementById('detail-modal');
  const modalImage = document.getElementById('modal-image');
  const modalTitle = document.getElementById('modal-title');
  const modalDescription = document.getElementById('modal-description');

  if (modal && modalImage && modalTitle && modalDescription) {
    modalImage.src = imageSrc;
    modalTitle.textContent = title;
    modalDescription.textContent = description;
    modal.style.display = 'flex';
    modal.style.visibility = 'visible';
    modal.style.opacity = '1';
  }
}

// Fonction pour fermer le modal
function closeModal() {
  const modal = document.getElementById('detail-modal');
  if (modal) {
    modal.style.display = 'none';
    modal.style.visibility = 'hidden';
    modal.style.opacity = '0';
  }
}

// Initialisation après le chargement du DOM
document.addEventListener('DOMContentLoaded', function () {
  // Fermeture via le bouton ×
  const closeButton = document.querySelector('.close-btn');
  if (closeButton) {
    closeButton.addEventListener('click', closeModal);
  }

  // Fermeture en cliquant à l'extérieur
  const modal = document.getElementById('detail-modal');
  if (modal) {
    modal.addEventListener('click', function (e) {
      if (e.target === this) {
        closeModal();
      }
    });
  }
// Configuration des données pour chaque bouton
const modalButtons = [
{
selector: '.characteristics-1',
img: '../../../public/images/shared/manual-wheelchair.jpg',
title: 'Manual wheelchair',
desc: 'Lightweight steel or aluminum frame. Foldable for easy storage and transport. Adjustable footrests and armrests. Puncture-resistant tires. Suitable for indoor and outdoor use.'
},
{
selector: '.characteristics-2',
img: '../../../public/images/shared/electric-wheelchair.jpg',
title: 'Electric wheelchair',
desc: 'Powered by rechargeable battery. Joystick control for easy navigation. Padded seat and backrest for comfort. Anti-tip wheels for extra safety. Ideal for users with limited upper body strength.'
},
{
selector: '.characteristics-3',
img: '../../../public/images/shared/electric-assist-wheelchair.jpg',
title: 'Electric assist wheelchair',
desc: 'Manual wheelchair with electric assist motor. Motorized support for slopes and long distances. Removable battery for convenient charging. Switch between manual and powered mode. Compact and foldable design.'
},
{
selector: '.characteristics-4',
img: '../../../public/images/shared/crutches.jpg',
title: 'Crutches',
desc: 'Lightweight aluminum construction. Ergonomic handles and arm cuffs for comfort. Adjustable height for user customization. Non-slip rubber tips for safety. Ideal for short- or long-term mobility support.'
},
{
selector: '.characteristics-5',
img: '../../../public/images/shared/rollator.jpg',
title: 'Rollator',
desc: 'Four-wheel design for stability and maneuverability. Built-in seat and backrest for resting. Height-adjustable handles. Hand brakes for safety. Storage basket for personal items.'
},
{
selector: '.characteristics-6',
img: '../../../public/images/shared/toilet-reducer.jpg',
title: 'Toilet reducer',
desc: 'Fits securely on standard toilet seats. Raised seat height for easier sitting and standing. Side handles for added support and balance. Easy to clean, durable plastic material. Ideal for elderly or mobility-impaired users.'
},
{
selector: '.characteristics-7',
img: '../../../public/images/shared/bath-seat.jpg',
title: 'Bath seat',
desc: 'Non-slip rubber feet for extra stability. Corrosion-resistant aluminum legs. Height-adjustable legs for user comfort. Water-drainage holes to prevent slipping. Lightweight and easy to clean.'
},
{
selector: '.characteristics-8',
img: '../../../public/images/shared/handrail.jpg',
title: 'Handrail',
desc: 'Heavy-duty steel or aluminum construction. Wall or floor mounted for added support. Ergonomic design for secure grip. Ideal for bathrooms, hallways, and near stairs. Foldable models available for space-saving.'
}

];
  // Attachement des événements à tous les boutons
  modalButtons.forEach((button) => {
    const elements = document.querySelectorAll(button.selector);
    elements.forEach((element) => {
      element.addEventListener('click', function () {
        openModal(button.img, button.title, button.desc);
      });
    });
  });

  // Fermeture avec la touche Escape
  document.addEventListener('keydown', function (e) {
    if (
      e.key === 'Escape' &&
      modal &&
      modal.style.visibility === 'visible'
    ) {
      closeModal();
    }
  });
});
