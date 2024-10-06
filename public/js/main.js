document.addEventListener('DOMContentLoaded', function() {
    const fileList = document.getElementById('fileList');
    const selectAll = document.getElementById('selectAll');
    const downloadSelected = document.getElementById('downloadSelected');
    const shareSelected = document.getElementById('shareSelected');
    const deleteSelected = document.getElementById('deleteSelected');
    const sortFiles = document.getElementById('sortFiles');
    const sortDirection = document.getElementById('sortDirection');

    function updateButtonState() {
        const selectedFiles = document.querySelectorAll('.file-select:checked');
        const isAnySelected = selectedFiles.length > 0;
        downloadSelected.disabled = !isAnySelected;
        shareSelected.disabled = !isAnySelected;
        deleteSelected.disabled = !isAnySelected;
    }

    selectAll.addEventListener('change', function() {
        document.querySelectorAll('.file-select').forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateButtonState();
    });

    fileList.addEventListener('change', function(e) {
        if (e.target.classList.contains('file-select')) {
            updateButtonState();
        }
    });

    fileList.addEventListener('click', function(e) {
        if (e.target.closest('.file-card') && !e.target.closest('input[type="checkbox"]') && !e.target.closest('a') && !e.target.closest('button')) {
            const checkbox = e.target.closest('.file-card').querySelector('.file-select');
            checkbox.checked = !checkbox.checked;
            updateButtonState();
        }
    });

    downloadSelected.addEventListener('click', function() {
        const selectedFiles = document.querySelectorAll('.file-select:checked');
        selectedFiles.forEach(checkbox => {
            const link = document.createElement('a');
            link.href = checkbox.closest('.file-card').dataset.path;
            link.download = '';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });
    });

    deleteSelected.addEventListener('click', function() {
        if (confirm('Ви впевнені, що хочете видалити вибрані файли?')) {
            const selectedFiles = document.querySelectorAll('.file-select:checked');
            selectedFiles.forEach(checkbox => {
                const fileId = checkbox.value;
                fetch(`/delete-file/${fileId}`, { method: 'POST' })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            checkbox.closest('.col-md-4').remove();
                        } else {
                            alert(`Error deleting file: ${data.error}`);
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        }
    });

    sortFiles.addEventListener('change', function() {
        const [criteria, order] = this.value.split('_');
        const files = Array.from(fileList.children);
        files.sort((a, b) => {
            if (criteria === 'name') {
                const aValue = a.querySelector('.card-title').textContent.trim().toLowerCase();
                const bValue = b.querySelector('.card-title').textContent.trim().toLowerCase();
                return order === 'asc' ? aValue.localeCompare(bValue) : bValue.localeCompare(aValue);
            } else {
                const aDate = new Date(a.querySelector('.card-text:last-child').textContent.split(': ')[1].trim());
                const bDate = new Date(b.querySelector('.card-text:last-child').textContent.split(': ')[1].trim());
                return order === 'asc' ? aDate - bDate : bDate - aDate;
            }
        });
        files.forEach(file => fileList.appendChild(file));
        updateSortDirection();
    });

    function updateSortDirection() {
        const selectedOption = sortFiles.value;
        if (selectedOption.endsWith('_asc')) {
            sortDirection.className = 'fa-solid fa-arrow-up-wide-short ms-2';
        } else {
            sortDirection.className = 'fa-solid fa-arrow-down-short-wide ms-2';
        }
    }

    updateSortDirection();

    document.querySelectorAll('.delete-file').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to delete this file?')) {
                fetch(this.href, { method: 'POST' })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.closest('.col-md-4').remove();
                        } else {
                            alert(`Error deleting file: ${data.error}`);
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        });
    });

    document.querySelectorAll('.update-file').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const fileId = this.dataset.id;
            const fileName = this.dataset.name;
            document.getElementById('updateFileId').value = fileId;
            document.getElementById('updateName').value = fileName;
            const updateFileModal = new bootstrap.Modal(document.getElementById('updateFileModal'));
            updateFileModal.show();
        });
    });
});

function submitAddFileForm() {
    const form = document.getElementById('addFileForm');
    const formData = new FormData(form);

    fetch('/add-file', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('File successfully added');
            location.reload();
        } else {
            alert('Error adding file');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while sending the request');
    });
}

function submitUpdateFileForm() {
    const form = document.getElementById('updateFileForm');
    const formData = new FormData(form);
    const fileId = formData.get('id');

    fetch(`/update-file/${fileId}`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('File successfully updated');
            location.reload();
        } else {
            alert('Error updating file');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while sending the request');
    });
}

function fallbackCopyTextToClipboard(button) {
    const path = button.getAttribute('data-path');
    const text = window.location.origin + '/' + path;

    const textArea = document.createElement("textarea");
    textArea.value = text;
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();

    try {
        const successful = document.execCommand('copy');
        const msg = successful ? 'success' : 'failed';
        alert('Link ' + msg + ' copied to clipboard: ' + text);
    } catch (err) {
        console.error('Failed to copy the link: ', err);
        alert('Failed to copy the link. Please copy it manually: ' + text);
    }

    document.body.removeChild(textArea);
}