<input type="hidden" value="{{ $check->id }}" name="id">
<div class="form-group">
    <label for="">Employee</label>
    <select name="user_id" class=" form-control select2" id="">
       @foreach ($user as $u)
          <option value="{{ $u->id }}" @if ($u->id == $check->id) selected @endif>{{ $u->name }}</option>
       @endforeach
    </select>
</div>
<div class="form-group">
    <label for="">Date</label>
     <input type="date" name="date" value="{{ $check->date }}" class=" form-control">
</div>
<div class="form-group">
    <label for="">Check In Time</label>
     <input type="time" name="checkin" value="{{ Carbon\Carbon::parse($check->checkin)->format('H:s:i') }}" class=" form-control time">
</div>
<div class="form-group">
    <label for="">CheckOut Time</label>
     <input type="time" name="checkout" value="{{ Carbon\Carbon::parse($check->checkout)->format('H:s:i') }}" class=" form-control time">
</div>
