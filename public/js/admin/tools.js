
document.addEventListener("DOMContentLoaded", () => { // Document Object Model pour charger tout le html
    const filterSelect = document.getElementById('filter');
    const rows = document.querySelectorAll('table tbody tr');
    const modal = document.getElementById('tool-form-modal');
    const formTitle = document.getElementById('tool-form-title');
    const addToolBtn = document.querySelector('.add-newtool-btn');
    const addNeedBtn = document.querySelector('.add-newneed-btn');
    const closeFormBtn = document.getElementById('close-tool-form');
    const editBtns = document.querySelectorAll('.btn-edit');
    const deleteBtns = document.querySelectorAll('.btn-delete');
  
    // Filtrage
    filterSelect.addEventListener('change', function () {
      const selectedValue = this.value;
      rows.forEach(row => {
        const typeCell = row.cells[3];
        const typeValue = typeCell.textContent.trim().toLowerCase();
        row.style.display = (selectedValue === 'all' || typeValue === selectedValue) ? '' : 'none';
      });
    });
  
    // Ouvrir le formulaire pour un outil
    addToolBtn.addEventListener('click', () => {
      formTitle.textContent = 'Add New Tool';
      modal.style.display = 'flex';
    });
  
    // Ouvrir le formulaire pour un besoin
    addNeedBtn.addEventListener('click', () => {
      formTitle.textContent = 'Add New Need';
      modal.style.display = 'flex';
    });
  
    // Édition
    editBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        formTitle.textContent = 'Edit Tool';
        modal.style.display = 'flex';
      });
    });
  
    // Fermer le modal
    closeFormBtn.addEventListener('click', () => {
      modal.style.display = 'none';
    });
  
    // Fermer en cliquant à l'extérieur du modal
    window.addEventListener('click', (e) => {
      if (e.target === modal) {
        modal.style.display = 'none';
      }
    });
  
     // Supprimer TOOL
    deleteBtns.forEach((btn) => {
    btn.addEventListener('click', function () {
        const confirmation = confirm("Are you sure you want to proceed with the deletion?");
        if (confirmation) {
            const row = this.closest('tr'); // Trouve la ligne entière du bouton
        row.remove(); 
        }
    });
  });

  });