/**
 * Document Upload Handler
 */
class DaystarDocumentUpload {
    constructor() {
        this.initializeUploadHandlers();
    }

    initializeUploadHandlers() {
        // Handle document upload buttons
        document.querySelectorAll('.document-upload-card button').forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const card = e.target.closest('.document-upload-card');
                const input = card.querySelector('input[type="file"]');
                const docType = input.id.replace('_upload', '');
                
                if (input.files.length === 0) {
                    this.showMessage('Please select a file first', 'error');
                    return;
                }

                this.uploadDocument(input.files[0], docType);
            });
        });
    }

    async uploadDocument(file, docType) {
        // Check file size
        if (file.size > 5 * 1024 * 1024) { // 5MB limit
            this.showMessage('File size must be less than 5MB', 'error');
            return;
        }

        // Check file type
        const allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
        if (!allowedTypes.includes(file.type)) {
            this.showMessage('Only JPG, PNG and PDF files are allowed', 'error');
            return;
        }

        const formData = new FormData();
        formData.append('action', 'daystar_upload_document');
        formData.append('document', file);
        formData.append('document_type', docType);
        formData.append('security', daystarData.uploadNonce);

        try {
            const response = await fetch(daystarData.ajaxUrl, {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                this.showMessage('Document uploaded successfully', 'success');
                this.updateUploadStatus(docType);
            } else {
                this.showMessage(result.data || 'Upload failed', 'error');
            }
        } catch (error) {
            this.showMessage('Upload failed: ' + error.message, 'error');
        }
    }

    updateUploadStatus(docType) {
        const card = document.querySelector(`#${docType}_upload`).closest('.document-upload-card');
        card.classList.add('uploaded');
        card.querySelector('button').textContent = 'Update';
    }

    showMessage(message, type = 'info') {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show mt-3`;
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;

        const container = document.querySelector('.documents-section');
        container.insertBefore(alertDiv, container.firstChild);

        // Auto dismiss after 5 seconds
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new DaystarDocumentUpload();
});
