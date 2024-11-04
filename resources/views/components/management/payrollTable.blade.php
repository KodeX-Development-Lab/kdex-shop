<table class="table table-bordered table-striped ">
    <thead>
        <tr>
            <th>Employee</th>
            <th>Role</th>
            <th>Day of Month</th>
            <th>Working Day</th>
            <th>Off Day</th>
            <th>Attendance Day</th>
            <th>Leave</th>
            <th>Per Day(MMK)</th>
            <th>Meal (MMK)</th>
            <th>Total (MMK)</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($employee as $e)
            <tr>
                @php
                    $attend = 0;
                    $salary = $e->salary->where('month',$month)->where('year',$year)->first();
                @endphp

                @foreach ($period as $p)
                    @php
                        $attendance = collect($check)
                            ->where('user_id', $e->id)
                            ->where('date', $p->format('Y-m-d'))
                            ->first();

                        if ($attendance) {
                            if ($attendance->checkin <= $company->office_start_time || ($attendance->checkin > $company->office_start_time && $attendance->checkin < $company->break_start_time)) {
                                $attend += 0.5;
                            }

                            if ($attendance->checkout > $company->office_end_time || ($attendance->checkout < $company->office_end_time && $attendance->checkout > $company->break_end_time)) {
                                $attend += 0.5;
                            }
                        }
                    @endphp
                @endforeach

                <td>{{ $e->name }}</td>
                <td>{{ implode(" ", $e->roles->pluck('name')->toArray()) }}</td>
                <td>{{ $numberOfDays }}</td>
                <td>{{ $workingDay+1 }}</td>
                <td>{{ $numberOfDays - ($workingDay+1) }}</td>
                <td>{{ $attend }}</td>
                <td>{{ ($workingDay+1) - $attend }}</td>
                <td>{{ $salary ? number_format($salary->amount /  ($workingDay+1)) : 0}}</td>
                <td>25000</td>
                <td>{{ $salary ? number_format((($attend)*($salary->amount /  ($workingDay+1))) + 25000) : 0}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
