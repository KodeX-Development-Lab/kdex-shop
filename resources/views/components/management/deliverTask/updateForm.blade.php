<input type="hidden" name="id" value="{{ $delivery->id }}">
<div class="from-group mb-2">
    <label for="">Choose Delivery</label>
    <select name="user_id" class="form-control">
       @foreach ($user as $u)
       <option value="{{ $u->id }}" @if ($u->id == $delivery->user->id) selected @endif>{{ $u->name }} @foreach ($u->roles as $r) ({{ $r->name }}) @endforeach</option>
       @endforeach
    </select>
</div>
<div class="from-group mb-2">
    <label for="">Choose Product</label>
    <select name="product_id" class="form-control">
       @foreach ($product as $u)
       <option value="{{$u->id }}" @if ($u->id == $delivery->product->id) selected @endif>{{$u->name_en }}</option>
       @endforeach
    </select>
</div>
<div class="form-group mb-2">
    <label for="">title</label>
    <input type="text" name="title" value="{{ $delivery->title }}" class=" form-control">
</div>
<div class="form-group mb-2">
    <label for="">Description</label>
    <textarea name="description"    class=" form-control">{{ $delivery->description }}</textarea>
</div>
<div class="form-group mb-2">
    <label for="">Start Date</label>
    <input type="date" name="start_date"  value="{{ $delivery->start_date }}" class=" form-control">
</div>
<div class="form-group mb-2">
    <label for="">Deadline</label>
    <input type="date" name="deadline"  value="{{ $delivery->deadline }}" class=" form-control">
</div>
<div class="from-group mb-2">
    <label for="">Priority</label>
    <select name="priority" class="form-control">
     <option value="high" @if($delivery->priority == 'high') selected @endif>High</option>
     <option value="middle" @if($delivery->priority == 'middle') selected @endif>Middle</option>
     <option value="low" @if($delivery->priority == 'low') selected @endif>Low</option>
    </select>
</div>
<div class="from-group mb-2">
    <label for="">Customer Address</label>
    <input type="text" name="customer_address"  value="{{ $delivery->customer_address }}" class=" form-control">
</div>
<div class="from-group mb-2">
    <label for="">Customer Phone</label>
    <input type="number" name="phone"  value="{{ $delivery->phone }}" class=" form-control">
</div>
<div class="from-group mb-2">
    <label for="">Status</label>
    <select name="status" class="form-control">
     <option value="pending" @if($delivery->status == 'pending') selected @endif >pending</option>
     <option value="in_progress" @if($delivery->status == 'in_progress') selected @endif>in_progress</option>
     <option value="complete" @if($delivery->status == 'complete') selected @endif>complete</option>
    </select>
</div>
