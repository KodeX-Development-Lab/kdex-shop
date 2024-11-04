@extends('ecommerce.layout.master')
@section('title', 'Attendance Scan')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="text-center">
                    <img src="{{ asset('images/qr-code-isometric.svg') }}" style=" width : 300px ; height : 200px">
                    <div class=" mt-5">
                        <h5 class=" text-muted mb-5">Please Scan To Attendance Qr</h5>
                        <div class="bootstrap-modal">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary scanModel" data-toggle="modal"
                                data-target="#basicModal">Scan
                                Qr</button>
                            <!-- Modal -->
                            <div class="modal fade" id="basicModal">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Scan to qr</h5>
                                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <video id="scan" style=" width : 100% ; height : 300px"></video>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-dark btn-close"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            {{-- my attendance overview --}}
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-2">
                                <select name="" class=" form-control select2" id="month">
                                    <option value="01" @if (now()->format('m') == '01') selected @endif>January
                                    </option>
                                    <option value="02" @if (now()->format('m') == '02') selected @endif>February
                                    </option>
                                    <option value="03" @if (now()->format('m') == '03') selected @endif>March</option>
                                    <option value="04" @if (now()->format('m') == '04') selected @endif>April</option>
                                    <option value="05" @if (now()->format('m') == '05') selected @endif>May</option>
                                    <option value="06" @if (now()->format('m') == '06') selected @endif>June</option>
                                    <option value="07" @if (now()->format('m') == '07') selected @endif>July</option>
                                    <option value="08" @if (now()->format('m') == '08') selected @endif>Auguest
                                    </option>
                                    <option value="09" @if (now()->format('m') == '09') selected @endif>September
                                    </option>
                                    <option value="10" @if (now()->format('m') == '10') selected @endif>October
                                    </option>
                                    <option value="11" @if (now()->format('m') == '11') selected @endif>November
                                    </option>
                                    <option value="12" @if (now()->format('m') == '12') selected @endif>December
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                @php
                                    $currentYear = date('Y');
                                    $years = [];
                                    for ($i = 0; $i < 5; $i++) {
                                        $years[] = $currentYear - $i;
                                    }
                                @endphp
                                <select class="form-control select2" id="year">
                                    <option value="">-- Choose Year --</option>
                                    @foreach ($years as $year)
                                        <option value="{{ $year }}"
                                            @if (now()->format('Y') == $year) selected @endif>{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button class=" btn btn-primary filterBtn"><i class="fa-solid fa-filter"></i></button>
                        </div>
                        <div class="table-responsive">
                            <div class="myAttendance">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table w-100 table-striped table-bordered  zero-configuration" id="example">
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>Date</th>
                                        <th>Checkin Time</th>
                                        <th>Checkout Time</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            var month = $('#month').val();
            var year = $('#year').val();
            // datatable start
            var table = new DataTable('#example', {
                ajax: `myAttendance`,
                mark: true,
                responsive: true,
                processing: true,
                serverSide: true,
                columns: [{
                        'data': 'employee',
                        'name': 'employee'
                    },
                    {
                        'data': 'date',
                        'name': 'date'
                    },
                    {
                        'data': 'checkin',
                        'name': 'checkin'
                    },
                    {
                        'data': 'checkout',
                        'name': 'checkout'
                    }
                ]
            });
            // datatable end
            // scan start
            $(document).on('click', '.scanModel', function() {
                qrScanner.start();
            })
            $(document).on('click', '.btn-close', function() {
                qrScanner.stop();
            })
            const videoElem = document.getElementById('scan')
            const qrScanner = new QrScanner(
                videoElem,
                function(res) {
                    if (res) {
                        qrScanner.stop();
                    }
                    $.ajax({
                        url: 'attendanceScan',
                        type: 'POST',
                        data: {
                            'value': res
                        },
                        success: function(res) {
                            if (res.status == 404) {
                                Swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    text: res.msg,
                                });
                            }
                            if (res.status == 200) {
                                Swal.fire({
                                    title: "Good job!",
                                    text: res.msg,
                                    icon: "success"
                                });
                            }
                        }
                    })
                }
            );
            // scan end
            // overview
            fetchData()

            function fetchData() {
                var month = $('#month').val();
                var year = $('#year').val();
                $.ajax({
                    url: `myAttendanceOverview?month=${month}&year=${year}`,
                    type: 'GET',
                    success: function(res) {
                        $('.myAttendance').html(res)
                    }
                });
            }
            $('.filterBtn').on('click', function() {
                var month = $('#month').val();
                var year = $('#year').val();
                fetchData()
                table.ajax.url(`myAttendance?month=${month}&year=${year}`).load()
            })
        })
    </script>
@endsection
