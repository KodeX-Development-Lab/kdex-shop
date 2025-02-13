<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Create Category <i class=" fas fa-plus-circle"></i></button>
                    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"></h5>Create category
                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('category.store') }}" method="POST" id="create" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="">Image</label> <br>
                                            <div class="createImg"></div>
                                            <input type="file" name="image" id="image" class=" form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Name(En)</label>
                                            <input type="text" name="name" class=" form-control">
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
