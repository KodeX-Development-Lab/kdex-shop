<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Create Role <i
        class=" fas fa-plus-circle"></i></button>
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>Create Role
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('role.store') }}" method="POST" id="create" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" name="name" class=" form-control">
                    </div>
                    <div class="row">

                        @foreach ($permission as $p)
                            <div class="col-md-4">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                        value="{{ $p->name }}" id="{{ $p->id }}">
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
                <button class="btn btn-primary">Confirm</button>
            </div>
            </form>
        </div>
    </div>
</div>
