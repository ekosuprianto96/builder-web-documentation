class EDataTable {
    constructor(options) {
        this.options = options;
        this.table = document.querySelector(options.selector);
        this.columns = options.columns || [];
        this.data = options.data || [];
        this.noDataMessage = options.noDataMessage || 'No data available';
        this.init();
    }

    init() {
        this.createTable();
        this.renderTable();
        this.setupSearch();
        if (this.options.ajax) {
            this.loadDataWithAjax(this.options.ajax.url);
        }
    }

    createTable() {
        // Create table structure
        this.table.innerHTML = `
            <thead>
                <tr>
                    <th><input type="checkbox" id="checkAll"></th>
                    ${this.columns.map(column => `<th>${column}</th>`).join('')}
                </tr>
            </thead>
            <tbody></tbody>
        `;
    }

    renderTable() {
        const tbody = this.table.querySelector('tbody');
        tbody.innerHTML = ''; // Clear existing rows

        if (this.data.length === 0) {
            tbody.innerHTML = `<tr><td colspan="${this.columns.length + 1}">${this.noDataMessage}</td></tr>`;
            return;
        }

        this.data.forEach(rowData => {
            const tr = document.createElement('tr');
            const checkboxTd = document.createElement('td');
            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.classList.add('rowCheckbox');
            checkboxTd.appendChild(checkbox);
            tr.appendChild(checkboxTd);

            this.columns.forEach(column => {
                const td = document.createElement('td');
                td.textContent = rowData[column];
                tr.appendChild(td);
            });

            tbody.appendChild(tr);
        });

        this.setupCheckAll();
    }

    setupCheckAll() {
        const checkAll = this.table.querySelector('#checkAll');
        const checkboxes = this.table.querySelectorAll('.rowCheckbox');

        checkAll.addEventListener('change', function() {
            const isChecked = this.checked;
            checkboxes.forEach(checkbox => {
                checkbox.checked = isChecked;
            });
        });
    }

    setupSearch() {
        const searchInput = document.querySelector(this.options.searchInput);
        const noDataMessage = this.noDataMessage;
        const table = this.table;

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const query = searchInput.value.toLowerCase();
                const rows = table.querySelectorAll('tbody tr');
                let visibleRows = 0;

                rows.forEach(row => {
                    const rowText = row.textContent.toLowerCase();
                    const isVisible = rowText.indexOf(query) > -1;
                    row.style.display = isVisible ? '' : 'none';
                    if (isVisible) visibleRows++;
                });

                if (visibleRows === 0) {
                    table.querySelector('tbody').innerHTML = `<tr><td colspan="${this.columns.length + 1}">${noDataMessage}</td></tr>`;
                }
            });
        }
    }

    loadDataWithAjax(url) {
        fetch(url)
            .then(response => response.json())
            .then(data => {
                this.data = data;
                this.renderTable();
            })
            .catch(error => {
                console.error('Failed to fetch data:', error);
            });
    }
}