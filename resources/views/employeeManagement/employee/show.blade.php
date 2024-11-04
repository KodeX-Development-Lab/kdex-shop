@extends('ecommerce.layout.master')
@section('content')
<div class="container">
<div class="card">
    <div class="card-body">
        <a href="{{ route('employee.index') }}" class=" text-dark"><i class=" fas fa-angle-left"></i></a>
        <div class="row">
            <div class="col-md-6 text-center ShowC">
                <img src="{{ asset('storage/'.$employee->image) }}" class=" img-thumbnail showPP">
                <div class="mt-4">
                    <span class=" badge badge-info badge-pill">{{ $employee->employee_id }}</span>
                    <span class=" badge badge-secondary text-white badge-pill">{{ $employee->department->name }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <h4 class=" mb-3">Name : {{ $employee->name }}</h4>
                <h4 class=" mb-3">Email : {{ $employee->email }}</h4>
                <h4 class=" mb-3">Phone : {{ $employee->phone }}</h4>
                <h4 class=" mb-3">Nrc Number : {{ $employee->nrc_number }}</h4>
                <h4 class=" mb-3">Birthday : {{ $employee->birthday }}</h4>
                <h4 class=" mb-3">Join Date : {{ $employee->join_date }}</h4>
                <h4 class=" mb-3">is Present : @if ($employee->is_present == 1) <span class=" badge badge-success text-white badge-pill">Is present</span> @endif @if ($employee->is_present == 0) <span class=" badge badge-danger badge-pill">Is present</span> @endif</h4>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

