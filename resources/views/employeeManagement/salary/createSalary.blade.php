<div class="form-group">
    <label for="">Employee</label>
  <select name="user_id" class=" form-control select2">
    @foreach ($user as $u)
        <option value="{{ $u->id }}">{{ $u->name }}</option>
    @endforeach
  </select>
</div>
<div class="form-group">
    <label for="">Month</label>
    <select name="month" class=" form-control select2" id="month">
        <option value="">-- Choose Month --</option>
        <option value="01">January</option>
        <option value="02">February</option>
        <option value="03">March</option>
        <option value="04">April</option>
        <option value="05">May</option>
        <option value="06">June</option>
        <option value="07">July</option>
        <option value="08">Auguest</option>
        <option value="09">September</option>
        <option value="10">October</option>
        <option value="11">November</option>
        <option value="12">December</option>
    </select>
</div>
<div class="form-group">
    @php
    $currentYear = date('Y');
    $years = [];
    for ($i = 0; $i < 5; $i++) {
        $years[] = $currentYear + $i;
    }
@endphp
<label for="">Year</label>
<select class="form-control select2" name="year" id="year">
    <option value="">-- Choose Year --</option>
    @foreach ($years as $year)
        <option value="{{ $year }}" >{{ $year }}</option>
    @endforeach
</select>
</div>
<div class="form-group">
    <label for="">Salary Amount</label>
    <input type="number" name="amount" class=" form-control">
</div>
