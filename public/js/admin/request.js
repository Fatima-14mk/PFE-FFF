
const filterSelect = document.getElementById('filter');
const rows = document.querySelectorAll('table tbody tr');

filterSelect.addEventListener('change', function () {
    const selectedValue = this.value;

    rows.forEach(row => {
        const typeCell = row.cells[3]; // 4th column = Disability Type
        const typeValue = typeCell.textContent.trim().toLowerCase();// pour supp les espaces autour du texte

        if (selectedValue === 'all' || typeValue === selectedValue) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});