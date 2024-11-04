<div class="form-group">
    <label for="">Employee</label>
    <select name="user_id" class=" form-control select2" id="">
       @foreach ($user as $u)
          <option value="{{ $u->id }}">{{ $u->name }}</option>
       @endforeach
    </select>
</div>
<div class="form-group">
    <label for="">Date</label>
     <input type="date" name="date" class=" form-control">
</div>
<div class="form-group">
    <label for="">Check In Time</label>
     <input type="time" name="checkin" class=" form-control time">
</div>
<div class="form-group">
    <label for="">CheckOut Time</label>
     <input type="time" name="checkout" class=" form-control time">
</div>
