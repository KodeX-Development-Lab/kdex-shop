<table class="table table-bordered">
    <thead>
        <tr>
            <th>Employee</th>
            @foreach ($period as $p)
                <th class=" @if ($p->format('D') == 'Sat' || $p->format('D') == 'Sun') alert-danger @endif">{{ Carbon\Carbon::parse($p)->format('d') }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>

            <tr>
                <td> {{ $employee->name }}</td>
                @foreach ($period as $p)
                    @php
                        $attendance = collect($check)
                            ->where('user_id', $employee->id)
                            ->where('date', $p->format('Y-m-d'))
                            ->first();
                        $checkinIcon = '';
                        $checoutnIcon = '';
                        if ($attendance) {
                            if ($attendance->checkin <= $company->office_start_time) {
                                $checkinIcon = '<i class=" fas fa-check-circle text-success"></i>';
                            } elseif ($attendance->checkin > $company->office_start_time && $attendance->checkin < $company->break_start_time) {
                                $checkinIcon = '<i class=" fas fa-check-circle text-warning"></i>';
                            } else {
                                $checkinIcon = '<i class=" fas fa-times-circle text-danger"></i>';
                            }
                        }
                        if ($attendance) {
                            if ($attendance->checkout > $company->office_end_time) {
                                $checkoutIcon = '<i class=" fas fa-check-circle text-success"></i>';
                            } elseif ($attendance->checkout < $company->office_end_time && $attendance->checkout > $company->break_end_time) {
                                $checkoutIcon = '<i class=" fas fa-check-circle text-warning"></i>';
                            } else {
                                $checkoutIcon = '<i class=" fas fa-times-circle text-danger"></i>';
                            }
                        }
                    @endphp
                    <td @if (!$attendance) class=" alert-danger" @endif>
                        @if ($attendance)
                        <div>{!! $checkinIcon !!}</div>
                        <div>{!! $checkoutIcon !!}</div>
                        @endif
                    </td>
                @endforeach
            </tr>
    </tbody>
</table>
