/* ============================================
   DGENTECH — Admin JavaScript
   ============================================ */

document.addEventListener('DOMContentLoaded', function () {

    // ==========================================
    // SIDEBAR TOGGLE (RESPONSIVE)
    // ==========================================
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.querySelector('.admin-sidebar');
    const overlay = document.querySelector('.sidebar-overlay');
    const sidebarClose = document.querySelector('.sidebar-close');

    function openSidebar() {
        if (sidebar) sidebar.classList.add('show');
        if (overlay) overlay.classList.add('show');
    }

    function closeSidebar() {
        if (sidebar) sidebar.classList.remove('show');
        if (overlay) overlay.classList.remove('show');
    }

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', openSidebar);
    }

    if (overlay) {
        overlay.addEventListener('click', closeSidebar);
    }

    if (sidebarClose) {
        sidebarClose.addEventListener('click', closeSidebar);
    }


    // ==========================================
    // CONFIRM DELETE
    // ==========================================
    document.querySelectorAll('.btn-delete-confirm').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            if (!confirm('Bạn có chắc chắn muốn xóa?')) {
                e.preventDefault();
            }
        });
    });


    // ==========================================
    // IMAGE UPLOAD PREVIEW
    // ==========================================
    const uploadArea = document.querySelector('.upload-area');
    const fileInput = document.getElementById('productImage');
    const previewContainer = document.querySelector('.upload-preview');

    if (uploadArea && fileInput) {
        uploadArea.addEventListener('click', function () {
            fileInput.click();
        });

        // Drag & drop
        uploadArea.addEventListener('dragover', function (e) {
            e.preventDefault();
            uploadArea.style.borderColor = 'var(--accent)';
            uploadArea.style.background = 'var(--accent-light)';
        });

        uploadArea.addEventListener('dragleave', function () {
            uploadArea.style.borderColor = '';
            uploadArea.style.background = '';
        });

        uploadArea.addEventListener('drop', function (e) {
            e.preventDefault();
            uploadArea.style.borderColor = '';
            uploadArea.style.background = '';
            if (e.dataTransfer.files.length > 0) {
                fileInput.files = e.dataTransfer.files;
                showPreview(e.dataTransfer.files);
            }
        });

        fileInput.addEventListener('change', function () {
            if (fileInput.files.length > 0) {
                showPreview(fileInput.files);
            }
        });

        function showPreview(files) {
            if (!previewContainer) return;
            previewContainer.innerHTML = '';
            Array.from(files).forEach(function (file) {
                if (!file.type.startsWith('image/')) return;
                const reader = new FileReader();
                reader.onload = function (e) {
                    const div = document.createElement('div');
                    div.className = 'preview-item';
                    div.innerHTML = '<img src="' + e.target.result + '" alt="Preview"><button type="button" class="remove-preview" onclick="this.parentElement.remove()"><i class="bi bi-x"></i></button>';
                    previewContainer.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        }
    }


    // ==========================================
    // SIMPLE TABLE SEARCH
    // ==========================================
    const tableSearchInput = document.getElementById('adminTableSearch');
    if (tableSearchInput) {
        tableSearchInput.addEventListener('input', function () {
            const query = this.value.toLowerCase();
            const table = document.querySelector('.admin-table tbody');
            if (!table) return;

            table.querySelectorAll('tr').forEach(function (row) {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(query) ? '' : 'none';
            });
        });
    }


    // ==========================================
    // STATUS FILTER
    // ==========================================
    const statusFilter = document.getElementById('statusFilter');
    if (statusFilter) {
        statusFilter.addEventListener('change', function () {
            const filterValue = this.value.toLowerCase();
            const table = document.querySelector('.admin-table tbody');
            if (!table) return;

            table.querySelectorAll('tr').forEach(function (row) {
                if (filterValue === 'all' || filterValue === '') {
                    row.style.display = '';
                } else {
                    const badge = row.querySelector('.status-badge');
                    if (badge && badge.classList.contains(filterValue)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        });
    }

});
