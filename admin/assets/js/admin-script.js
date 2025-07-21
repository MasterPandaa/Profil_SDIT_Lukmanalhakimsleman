// Admin Panel JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Toggle sidebar on mobile
    const sidebarToggle = document.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            document.querySelector('#sidebar').classList.toggle('show');
        });
    }

    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // File input preview
    const fileInputs = document.querySelectorAll('.custom-file-input');
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            const fileName = this.files[0]?.name;
            const nextSibling = this.nextElementSibling;
            
            if (nextSibling && fileName) {
                nextSibling.innerText = fileName;
            }
            
            // Image preview
            const previewElement = document.querySelector(this.dataset.preview);
            if (previewElement && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewElement.src = e.target.result;
                    previewElement.style.display = 'block';
                }
                
                reader.readAsDataURL(this.files[0]);
            }
        });
    });

    // Confirm delete
    const deleteButtons = document.querySelectorAll('.btn-delete');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('Apakah Anda yakin ingin menghapus item ini?')) {
                e.preventDefault();
            }
        });
    });

    // Show loading spinner on form submit
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            // Check if form has file inputs
            const hasFileInputs = form.querySelector('input[type="file"]') !== null;
            
            // Only show spinner for forms with file uploads or data-show-spinner attribute
            if (hasFileInputs || form.dataset.showSpinner) {
                const spinnerOverlay = document.createElement('div');
                spinnerOverlay.className = 'spinner-overlay';
                spinnerOverlay.innerHTML = `
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                `;
                document.body.appendChild(spinnerOverlay);
            }
        });
    });

    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });

    // Initialize datepicker if available
    if (typeof flatpickr !== 'undefined') {
        flatpickr('.datepicker', {
            dateFormat: 'Y-m-d',
            locale: 'id'
        });
    }

    // Initialize CKEditor if available
    if (typeof ClassicEditor !== 'undefined') {
        document.querySelectorAll('.ckeditor').forEach(editor => {
            ClassicEditor
                .create(editor)
                .catch(error => {
                    console.error(error);
                });
        });
    }

    // Handle bulk actions
    const bulkActionForm = document.querySelector('#bulkActionForm');
    if (bulkActionForm) {
        const bulkActionSelect = bulkActionForm.querySelector('#bulkAction');
        const bulkActionButton = bulkActionForm.querySelector('#bulkActionBtn');
        
        bulkActionButton.addEventListener('click', function(e) {
            e.preventDefault();
            const selectedAction = bulkActionSelect.value;
            
            if (!selectedAction) {
                alert('Silakan pilih tindakan terlebih dahulu.');
                return;
            }
            
            const checkedItems = document.querySelectorAll('input[name="bulk_ids[]"]:checked');
            if (checkedItems.length === 0) {
                alert('Silakan pilih minimal satu item.');
                return;
            }
            
            if (selectedAction === 'delete' && !confirm('Apakah Anda yakin ingin menghapus semua item yang dipilih?')) {
                return;
            }
            
            bulkActionForm.submit();
        });
    }
}); 