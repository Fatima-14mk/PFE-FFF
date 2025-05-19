document.addEventListener("DOMContentLoaded", function () {
    const menuToggle = document.querySelector(".menu-toggle");
    const menu = document.querySelector(".menu");
    const register = document.querySelector(".register");
  
    menuToggle.addEventListener("click", (e) => {
      e.stopPropagation();
      menu.classList.toggle("active");
      register.classList.toggle("active");
    });
  
    // Fermer menu/register si on clique en dehors
    document.addEventListener("click", function (event) {
      if (
        !menu.contains(event.target) &&
        !register.contains(event.target) &&
        !menuToggle.contains(event.target)
      ) {
        menu.classList.remove("active");
        register.classList.remove("active");
      }
    });
  });
  