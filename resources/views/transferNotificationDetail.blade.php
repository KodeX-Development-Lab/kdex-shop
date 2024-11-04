@extends('ecommerce.layout.master')
@section('title', 'Wallet Transaction')
@section('content')
    <div class="container">
        <div class="card">
            <div class="crad-body">
                <div class="row">
                    <div class="col-md-6">
                        <img src="{{ asset('images/notifications-outline.png') }}" class=" w-100">
                    </div>
                    <div class="col-md-6">
                        <div style=" margin-top : 80px">
                            <h3 class=" mt-3">{{ $notification->data['title'] }}</h3>
                            <h4 class=" mt-3">{{ $notification->data['message'] }}</h4>
                            <h4 class=" mt-3">{{ $notification->created_at }}</h4>
                           <div class=" mt-5">
                            <a class=" btn btn-primary" href="{{ $notification->data['web_link'] }}">Continue</a>
                           </div>
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

        })
    </script>
@endsection
