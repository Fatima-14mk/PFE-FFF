
    
    // Filtre
    const filterSelect = document.getElementById('filter');
    const rows = document.querySelectorAll('table tbody tr');
    
    if(filterSelect) {
        filterSelect.addEventListener('change', function() {
            const selectedValue = this.value.toLowerCase();
            
            rows.forEach(row => {
                const typeCell = row.cells[3];
                const typeValue = typeCell.textContent.trim().toLowerCase();
                row.style.display = (selectedValue === 'all' || typeValue === selectedValue) ? '' : 'none';
            });
        });
    }

   