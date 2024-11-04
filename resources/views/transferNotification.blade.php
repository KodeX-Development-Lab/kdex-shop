@extends('ecommerce.layout.master')
@section('title', 'Wallet Transaction')
@section('content')
    <div class="container-fluid">
        @foreach ($notification as $noti)
            <a href="{{ route('transferNotificationDetail', $noti->id) }}">
                <div class="card mb-2" @if (is_null($noti->read_at)) style=" background-color : #eefcff" @endif>
                    <div class="card-body">
                        <div class=" d-flex justify-content-between">
                            <div class="">
                                <h3>{{ $noti->data['title'] }}</h3>
                                <h4>{{ $noti->data['message'] }}</h4>
                                <h4>{{ $noti->created_at->format('j-F-Y') }}</h4>
                            </div>
                            <div class="">
                                <i class=" @if (is_null($noti->read_at)) text-danger @endif fas fa-bell"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
        <div class=" float-right">
            {{ $notification->links() }}
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {

        })
    </script>
@endsection
