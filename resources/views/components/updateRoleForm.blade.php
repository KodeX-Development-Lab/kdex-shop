<form action="{{ route('updateRole') }}" id="update" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <input type="hidden" value="{{ $role->id }}" name="id">
    <div class="form-group">
        <label for="">Name</label>
        <input type="text" name="name" value="{{ $role->name }}" class=" form-control">
    </div>
    <div class="form-group">
        <label for="">Permission</label>
        <div class="row">
            @foreach ($permission as $p)
                <div class="col-md-4">
                    <div class="form-check mb-2">
                        <input @if (in_array($p->name, $oldPermission)) checked @endif class="form-check-input" type="checkbox"
                            name="permissions[]" value="{{ $p->name }}" id="{{ $p->id }}">
                        <label class="form-check-label" for="{{ $p->id }}">
                            {{ $p->name }}
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="updateForm">Confirm</button>
    </div>
</form>
