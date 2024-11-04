<input type="hidden" name="id" value="{{ $salary->id }}">
<div class="form-group">
    <label for="">Employee</label>
  <select name="user_id" class=" form-control select2">
    @foreach ($user as $u)
        <option value="{{ $u->id }}" @if ($u->id == $salary->user_id) selected @endif>{{ $u->name }}</option>
    @endforeach
  </select>
</div>
<div class="form-group">
    <label for="">Month</label>
    <select name="month" class=" form-control select2" id="month">
        <option value="">-- Choose Month --</option>
        <option value="01" @if ($salary->month == '01') selected @endif>January</option>
        <option value="02" @if ($salary->month == '02') selected @endif>February</option>
        <option value="03" @if ($salary->month == '03') selected @endif>March</option>
        <option value="04" @if ($salary->month == '04') selected @endif>April</option>
        <option value="05" @if ($salary->month == '05') selected @endif>May</option>
        <option value="06" @if ($salary->month == '06') selected @endif>June</option>
        <option value="07" @if ($salary->month == '07') selected @endif>July</option>
        <option value="08" @if ($salary->month == '08') selected @endif>Auguest</option>
        <option value="09" @if ($salary->month == '09') selected @endif>September</option>
        <option value="10" @if ($salary->month == '10') selected @endif>October</option>
        <option value="11" @if ($salary->month == '11') selected @endif>November</option>
        <option value="12" @if ($salary->month == '12') selected @endif>December</option>
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
        <option value="{{ $year }}" @if ($salary->year == $year) selected @endif>{{ $year }}</option>
    @endforeach
</select>
</div>
<div class="form-group">
    <label for="">Salary Amount</label>
    <input type="number" name="amount" value="{{ $salary->amount }}" class=" form-control">
</div>
