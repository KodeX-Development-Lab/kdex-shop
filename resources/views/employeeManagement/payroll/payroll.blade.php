@extends('ecommerce.layout.master')
@section('title', ' Overview')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-2">
                                    <select name="" class=" form-control select2" id="month">
                                        <option value="">-- Choose Month --</option>
                                        <option value="01" @if (now()->format('m') == '01') selected @endif>January</option>
                                        <option value="02" @if (now()->format('m') == '02') selected @endif>February</option>
                                        <option value="03" @if (now()->format('m') == '03') selected @endif>March</option>
                                        <option value="04" @if (now()->format('m') == '04') selected @endif>April</option>
                                        <option value="05" @if (now()->format('m') == '05') selected @endif>May</option>
                                        <option value="06" @if (now()->format('m') == '06') selected @endif>June</option>
                                        <option value="07" @if (now()->format('m') == '07') selected @endif>July</option>
                                        <option value="08" @if (now()->format('m') == '08') selected @endif>Auguest</option>
                                        <option value="09" @if (now()->format('m') == '09') selected @endif>September</option>
                                        <option value="10" @if (now()->format('m') == '10') selected @endif>October</option>
                                        <option value="11" @if (now()->format('m') == '11') selected @endif>November</option>
                                        <option value="12" @if (now()->format('m') == '12') selected @endif>December</option>
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
                                            <option value="{{ $year }}" @if (now()->format('Y') == $year) selected @endif>{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select  class=" form-control select2 " id="userName">
                                        <option value="">-- Choose Employee --</option>
                                        @foreach ($employee as $e)
                                            <option value="{{ $e->name }}">{{ $e->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button class=" btn btn-primary filterBtn"><i class="fa-solid fa-filter"></i></button>
                            </div>
                            <div class="overview-table"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('script')
        <script>
            $(document).ready(function() {
                fetchData()
                function fetchData(){
                    var month = $('#month').val();
                   var year = $('#year').val();
                   var userName = $('#userName').val();
                   $.ajax({
                    url: `payroll-filter?userName=${userName}&month=${month}&year=${year}`,
                    type: 'GET',
                    success: function(res) {
                        console.log(res);
                      $('.overview-table').html(res)
                    }
                });
                }
                $(document).on('click','.filterBtn',function(){
                   fetchData();
                })
            })
        </script>
    @endsection
