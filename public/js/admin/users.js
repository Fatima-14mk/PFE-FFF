// 🔄 Filtrer les utilisateurs par type de handicap
const filterSelect = document.getElementById('filter');
const rows = document.querySelectorAll('table tbody tr');

filterSelect.addEventListener('change', function () {
    const selectedValue = this.value;
    rows.forEach(row => {
        const typeCell = row.cells[4];
        const typeValue = typeCell.textContent.trim().toLowerCase();
        row.style.display = (selectedValue === 'all' || typeValue === selectedValue) ? '' : 'none';
    });
});

// 🧾 Références utiles
const modal = document.getElementById('user-form-modal');
const formTitle = document.getElementById('form-title');
const userForm = document.getElementById('user-form');
const closeFormBtn = document.getElementById('close-form');
const addUserBtn = document.querySelector('.add-user-btn');

// ➕ Ouvrir le formulaire pour ajout
addUserBtn.addEventListener('click', () => {
    formTitle.textContent = 'Add User';
    userForm.reset();
    document.getElementById('userId').value = '0';
    userForm.action = "../../../controller/admin/add_user.php";
    modal.style.display = 'flex';
});



// ❌ Fermer la modale
closeFormBtn.addEventListener('click', () => {
    modal.style.display = 'none';
});

window.addEventListener('click', function (e) {
    if (e.target === modal) {
        modal.style.display = 'none';
    }
});
