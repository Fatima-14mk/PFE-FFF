document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const menu = document.querySelector('.menu');
    
    menuToggle.addEventListener('click', function(e) {
        e.stopPropagation();
        menu.classList.toggle('active');
    });
    
    // Fermer le menu quand on clique ailleurs
    document.addEventListener('click', function() {
        menu.classList.remove('active');
    });
});