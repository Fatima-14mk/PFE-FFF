 //POUR dashboard
 const filterSelect = document.getElementById('filter');
 const rows = document.querySelectorAll('table tbody tr');

 filterSelect.addEventListener('change', function () {
     const selectedValue = this.value;

     rows.forEach(row => {
         const typeCell = row.cells[4]; // 5th column = Disability Type
         const typeValue = typeCell.textContent.trim().toLowerCase();// pour supp les espaces autour du texte

         if (selectedValue === 'all' || typeValue === selectedValue) {
             row.style.display = '';
         } else {
             row.style.display = 'none';
         }
     });
 });

// POUR LE FORMULAIRE         
const addUserBtn = document.querySelector('.add-user-btn');
const editBtns = document.querySelectorAll('.btn-edit');
const deleteBtns = document.querySelectorAll('.btn-delete');
const modal = document.getElementById('user-form-modal');
const closeFormBtn = document.getElementById('close-form');
const formTitle = document.getElementById('form-title');

addUserBtn.addEventListener('click', () => {
    formTitle.textContent = 'Add User';
    modal.style.display = 'flex';
});

editBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        formTitle.textContent = 'Edit User';
        modal.style.display = 'flex';
        
    });
});

closeFormBtn.addEventListener('click', () => {
    modal.style.display = 'none';
});

// Fermer en cliquant hors du formulaire
window.addEventListener('click', function (e) {
    if (e.target === modal) {
        modal.style.display = 'none';
    }
});

// Supprimer un utilisateur
deleteBtns.forEach((btn) => {
btn.addEventListener('click', function () {
    const confirmation = confirm("Are you sure you want to proceed with the deletion?");
    if (confirmation) {
        const row = this.closest('tr'); // Trouve la ligne entière du bouton
    row.remove(); 
    }
});
});
