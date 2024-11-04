<div class="modal fade createTask" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Delivery Task</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('delivery.store') }}" method="POST" id="create">
                    @csrf
                    <div class="from-group mb-2">
                        <label for="">Choose Delivery</label>
                        <select name="user_id" class="form-control">
                            @foreach ($user as $u)
                                <option value="{{ $u->id }}">{{ $u->name }} @foreach ($u->roles as $r)
                                        ({{ $r->name }})
                                    @endforeach
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="from-group mb-2">
                        <label for="">Choose Product</label>
                        <select name="product_id" class="form-control ">
                            @foreach ($product as $u)
                                <option value="{{ $u->id }}">{{ $u->name_en }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">title</label>
                        <input type="text" name="title" class=" form-control">
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Description</label>
                        <textarea name="description" class=" form-control"></textarea>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Start Date</label>
                        <input type="date" name="start_date" class=" form-control">
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Deadline</label>
                        <input type="date" name="deadline" class=" form-control">
                    </div>
                    <div class="from-group mb-2">
                        <label for="">Priority</label>
                        <select name="priority" class="form-control">
                            <option value="high">High</option>
                            <option value="middle">Middle</option>
                            <option value="low">Low</option>
                        </select>
                    </div>
                    <div class="from-group mb-2">
                        <label for="">Customer Address</label>
                        <input type="text" name="customer_address" class=" form-control">
                    </div>
                    <div class="from-group mb-2">
                        <label for="">Customer Phone</label>
                        <input type="number" name="phone" class=" form-control">
                    </div>
                    <div class="from-group mb-2">
                        <label for="">Status</label>
                        <select name="status" class="form-control">
                            <option value="pending">pending</option>
                            <option value="in_progress">in_progress</option>
                            <option value="complete">complete</option>
                        </select>
                    </div>
                    <button type="submit" class=" btn btn-primary mt-3">Confirm</button>
                </form>
            </div>
        </div>
    </div>
</div>
