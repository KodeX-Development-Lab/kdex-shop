@extends('ecommerce.layout.master')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <a href="{{ route('delivery.index') }}" class=" text-dark"><i class=" fas fa-angle-left"></i></a>
                <div class="row">
                    <div class="col-md-6 text-center ShowC">
                        <img src="{{ asset('storage/' . $delivery->user->image) }}" class=" img-thumbnail showPP">
                        <div class="mt-4">
                            <span class=" badge badge-info badge-pill">{{ $delivery->user->name }}</span>
                            <span class=" badge badge-secondary text-white badge-pill">{{ $delivery->user->phone }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h4 class=" mb-3">Delivery Name : {{ $delivery->user->name }}</h4>
                        <h4 class=" mb-3">Title : {{ $delivery->title }}</h4>
                        <h4 class=" mb-3">Product : {{ $delivery->product->name_en }}</h4>
                        <h4 class=" mb-3">Description : {{ $delivery->description }}</h4>
                        <h4 class=" mb-3">Start Date : {{ $delivery->start_date }}</h4>
                        <h4 class=" mb-3">Deadline : {{ $delivery->deadline }}</h4>
                        <h4 class=" mb-3">Customer Phone : {{ $delivery->phone }}</h4>
                        <h4 class=" mb-3">Customer Address : {{ $delivery->customer_address }}</h4>
                        <h4 class=" mb-3">Priority :
                            @if ($delivery->priority == 'high')
                                <div class=" badge badge-pill badge-danger">High</div>
                            @endif
                            @if ($delivery->priority == 'middle')
                                <div class=" badge badge-pill badge-warning text-white">Middle</div>
                            @endif
                            @if ($delivery->priority == 'low')
                                <div class=" badge badge-pill badge-info">Low</div>
                            @endif
                        </h4>
                        <h4 class=" mb-3">Status :
                            @if ($delivery->status == 'pending')
                            <div class=" badge badge-pill badge-danger">Pending</div>
                        @elseif ($delivery->status == 'in_progress')
                            <div class=" badge badge-pill badge-warning text-white">In Progress</div>
                        @elseif ($delivery->status == 'complete')
                            <div class=" badge badge-pill badge-info">Complete</div>
                        @endif
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
