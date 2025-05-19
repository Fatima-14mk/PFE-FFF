// Dropdown menu functionality
const settingsBtn = document.getElementById("settings-btn");
const dropdownMenu = document.getElementById("dropdown-menu");

// Toggle dropdown when clicking on "Settings"
settingsBtn.addEventListener("click", function(event) {
    event.preventDefault(); // Prevent the link from navigating
    event.stopPropagation(); // Prevent the click from propagating
    dropdownMenu.classList.toggle("show");
});

// Hide dropdown when clicking outside
document.addEventListener("click", function(event) {
    if (!event.target.closest(".menu-container")) {
        dropdownMenu.classList.remove("show");
    }
});

// Tab switching functionality
const tabLinks = document.querySelectorAll('.settings-link');
const tabContents = document.querySelectorAll('.tab-content');

tabLinks.forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Remove active class from all tabs
        tabLinks.forEach(tab => tab.classList.remove('active'));
        tabContents.forEach(content => content.classList.remove('active'));
        
        // Add active class to clicked tab
        this.classList.add('active');
        
        // Show corresponding content
        const tabId = this.getAttribute('data-tab');
        document.getElementById(tabId).classList.add('active');
    });
});

// File upload button
const fileInput = document.querySelector('.file-input');
const uploadBtn = document.querySelector('.btn-outline');

uploadBtn.addEventListener('click', function() {
    fileInput.click();
});

fileInput.addEventListener('change', function() {
    if (this.files && this.files[0]) {
        // Here you would typically handle the file upload
        console.log('File selected: ' + this.files[0].name);
    }
});

// Function to create and show a modal confirmation dialog
function showConfirmModal(message, confirmCallback) {
    // Create the modal overlay
    const overlay = document.createElement('div');
    overlay.className = 'modal-overlay';
    
    // Create the modal content
    const modal = document.createElement('div');
    modal.className = 'modal-container';
    
    // Create the message
    const messageElement = document.createElement('p');
    messageElement.textContent = message;
    
    // Create buttons container
    const buttonsContainer = document.createElement('div');
    buttonsContainer.className = 'modal-buttons';
    
    // Create confirm button
    const confirmButton = document.createElement('button');
    confirmButton.className = 'btn btn-primary modal-btn';
    confirmButton.textContent = 'Yes';
    confirmButton.addEventListener('click', function() {
        document.body.removeChild(overlay);
        if (confirmCallback) confirmCallback();
    });
    
    // Create cancel button
    const cancelButton = document.createElement('button');
    cancelButton.className = 'btn btn-default modal-btn';
    cancelButton.textContent = 'No';
    cancelButton.addEventListener('click', function() {
        document.body.removeChild(overlay);
    });
    
    // Append buttons to container
    buttonsContainer.appendChild(confirmButton);
    buttonsContainer.appendChild(cancelButton);
    
    // Assemble modal
    modal.appendChild(messageElement);
    modal.appendChild(buttonsContainer);
    overlay.appendChild(modal);
    
    // Add to DOM
    document.body.appendChild(overlay);
}

// Function to show notification message
function showNotification(message) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.textContent = message;
    
    // Add to DOM
    document.body.appendChild(notification);
    
    // Remove after 3 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            document.body.removeChild(notification);
        }
    }, 3000);
}

// Save changes button
const saveBtn = document.querySelector('.btn-primary');
saveBtn.addEventListener('click', function() {
    showConfirmModal('Are you sure you want to save?', function() {
        // Here you would handle the form submission
        showNotification('Changes saved successfully!');
    });
});

// Cancel button
const cancelBtn = document.querySelector('.buttons-container .btn-default');
if (cancelBtn) {
    cancelBtn.addEventListener('click', function() {
        showConfirmModal('Are you sure you want to cancel?', function() {
            // Here you would typically reset the form or navigate away
            window.location.reload();
        });
    });
}


//CHANGER LA PHOTO

document.querySelector('.file-input').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (!file) return;

    // Vérifie si le fichier est une image
    if (!file.type.startsWith('image/')) {
        alert("Veuillez sélectionner une image valide.");
        return;
    }

    const reader = new FileReader();
    reader.onload = function(e) {
        document.querySelector('.profile-image').src = e.target.result;
    };
    reader.readAsDataURL(file);
});

// Reset photo button
const resetBtn = document.querySelector('.profile-photo .btn-default');
if (resetBtn) {
    resetBtn.addEventListener('click', function() {
        showConfirmModal('Are you sure you want to reset your profile photo?', function() {
            showNotification('Profile photo reset successfully!');
        });
    });
}


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

document.querySelector('.file-input').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (!file) return;

    // Vérifie si le fichier est une image
    if (!file.type.startsWith('image/')) {
        alert("Veuillez sélectionner une image valide.");
        return;
    }

    const reader = new FileReader();
    reader.onload = function(e) {
        document.querySelector('.profile-image').src = e.target.result;
    };
    reader.readAsDataURL(file);
});
