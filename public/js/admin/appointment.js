// SUPP UN RND
const deleteBtns = document.querySelectorAll('.delete-btn');
  
    deleteBtns.forEach((btn) => {
      btn.addEventListener('click', function () {
        const confirmation = confirm("Are you sure you want to proceed with the deletion?");
        if (confirmation) {
          const card = this.closest('.card'); 
          card.remove(); 
        }
      });
    });
    

