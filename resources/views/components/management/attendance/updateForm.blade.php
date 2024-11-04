<div class="modal fade editModel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>Edit Attendance
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('updateAttendance') }}"  id="update" method="POST"  enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="editAddendance"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="updateForm">Confirm</button>
            </div>
            </form>
        </div>
    </div>
</div>
