<div class="modal fade" id="updateFileModal" tabindex="-1" aria-labelledby="updateFileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateFileModalLabel">Edit file</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateFileForm" enctype="multipart/form-data">
                    <input type="hidden" id="updateFileId" name="id">
                    <div class="mb-3">
                        <label for="updateName" class="form-label">Name file</label>
                        <input type="text" class="form-control" id="updateName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="updateFile" class="form-label">Select new file</label>
                        <input type="file" class="form-control" id="updateFile" name="file">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="submitUpdateFileForm()">Update</button>
            </div>
        </div>
    </div>
</div>