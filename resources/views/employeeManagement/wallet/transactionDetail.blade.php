@extends('ecommerce.layout.master')
@section('title', 'Wallet Transaction')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <img src="{{ asset('images/6617.jpg') }}" class=" w-100">
                    </div>
                    <div class="col-md-6">
                        <h4 class=" mt-4">Trx ID : {{ $transaction->trx_no }}</h4>
                        <h4 class=" mt-4">Reference Number : {{ $transaction->ref_no }}</h4>
                        <h4 class=" mt-4">
                            @if ($transaction->type == 2)
                         To : {{ $transaction->source->name }}
                        @endif
                        @if ($transaction->type == 1)
                        From : {{ $transaction->source->name }}
                        @endif
                        <h4 class=" mt-4">Amount :
                            @if ($transaction->type == 2)
                          <span class=" "> -{{ $transaction->amount }}MMK</span>
                        @endif
                        @if ($transaction->type == 1)
                        <span class=" "> +{{ $transaction->amount }}MMK</span>
                        @endif
                        </h4>
                        <h4 class=" mt-4">Date And Time : {{ $transaction->created_at->format('j-F-Y') }}</h4>
                        <h4 class=" mt-4">Description : {{ $transaction->description }}</h4>
                        <h4 class=" mt-4">Type :
                            @if ($transaction->type == 2)
                                <span class=" badge badge-danger badge-pill text-white ">Expense</span>
                            @endif
                            @if ($transaction->type == 1)
                                <span class=" badge badge-success badge-pill text-white ">Income</span>
                            @endif
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script></script>
@endsection
