<form action="{{ route('orderChangeStatus') }}" method="post">
    @csrf
    <input type="hidden" name="order_id" value="{{ $order->id }}">
    <div class="form-group">
        <label for="">Status</label>
        <select name="status" class=" form-control  w-100" id="">
            <option value="accept">Accept</option>
            <option value="reject">Reject</option>
        </select>
    </div>
    <div class=" form-group mb-3">
        <label for="">Message</label>
        <input type="text" name="message" class=" form-control">
    </div>
    <button type="submit" class=" btn btn-primary w-100">Confirm</button>
</form>
