@extends('ecommerce.layout.master')
@section('title', 'Employee Profile')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5 ShowC text-center">
                                <div class="">
                                    <img src="{{ asset('storage/' . Auth::user()->image) }}"
                                        style=" width:200px ; height : 200px">
                                    <div class=" mt-3">
                                        <div class="">
                                            <span class=" mb-3 badge badge-secondary text-white badge-pill">
                                                {{ Auth::user()->employee_id }}</span>
                                            <span
                                                class=" mb-3 badge badge-secondary text-white badge-pill">{{ Auth::user()->name }}</span>
                                        </div>
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target=".bd-example-modal-lg">Change Password</button>
                                        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-md">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Change Your Password</h5>
                                                        <button type="button" class="close"
                                                            data-dismiss="modal"><span>&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('changePassword') }}" id="changePasssword"
                                                        method="POST">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class=" form-group">
                                                                <label for="" class=" float-left">Current
                                                                    Password</label>
                                                                <input type="password" name='currentPassword'
                                                                    class=" form-control">
                                                            </div>
                                                            <div class=" form-group">
                                                                <label class=" float-left" for="">New
                                                                    Password</label>
                                                                <input type="password" name='newPassword'
                                                                    class=" form-control">
                                                            </div>
                                                        </div>
                                                        <button type=" submit"
                                                            class=" w-75 btn btn-primary">Confirm</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-7 px-5">
                                <h4 class=" mb-3">Email : {{ Auth::user()->email }}</h4>
                                <h4 class=" mb-3">Phone : {{ Auth::user()->phone }}</h4>
                                <h4 class=" mb-3">Nrc Number{{ Auth::user()->nrc_number }}</h4>
                                <h4 class=" mb-3">Gender : {{ Auth::user()->gender }}</h4>
                                <h4 class=" mb-3">Address{{ Auth::user()->address }}</h4>
                                <h4 class=" mb-3">Birthday : {{ Auth::user()->birthday }}</h4>
                                <h4 class=" mb-3">Join Date : {{ Auth::user()->join_date }}</h4>
                                <h4 class=" mb-3">Department : {{ Auth::user()->department->name }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card" style=" background-color :  #7571f9">
                    <div class="card-body">
                        <h3 class=" text-white">Your Wallet</h3>
                        <?php
                        $accountNumber = Auth::user()->wallet->account_number;
                        $formattedNumber = substr(chunk_split($accountNumber, 3, '-'), 0, -1);
                        ?>
                        <h3 class=" mt-4 text-white"><i class="fa-solid fa-compress"></i> Account Number :
                            {{ $formattedNumber }}</h3>
                        <h3 class=" mt-4 text-white"><i class="fa-solid fa-phone-volume"></i> Phone :
                            {{ Auth::user()->phone }}</h3>
                        <h3 class=" mt-4 text-white"><i class="fa-solid fa-money-bill-1-wave"></i> Balance :
                            {{ Auth::user()->wallet->amount }}</h3>
                        <div class=" mt-4 p-2">
                            <button type="button" class="btn btn-primary text-primary" style=" background-color : white"
                                data-toggle="modal" data-target="#basicModal">Sent Money <i
                                    class=" fas fa-paper-plane"></i></button>
                            <!-- Modal -->
                            <div class="modal fade" id="basicModal">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">
                                                <h4 class="card-title">Choose Transfer</h4>
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <ul class="nav nav-pills mb-3">
                                                <li class="nav-item"><a href="#navpills-1" class="nav-link active phoneBtn"
                                                        data-toggle="tab" aria-expanded="false">Sent with Phone</a>
                                                </li>
                                                <li class="nav-item"><a href="#navpills-2" class="nav-link scanBtn"
                                                        data-toggle="tab" aria-expanded="false">Sent With Scan</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content br-n pn">
                                                {{-- Sent money with phone --}}
                                                <div id="navpills-1" class="tab-pane active">
                                                    <div class="">
                                                        <form action="{{ route('sentMoney') }}" method="POST"
                                                            id="sentForm" id="create">
                                                            @csrf
                                                            <div class="form-group">
                                                                <label for="">To Phone : <span
                                                                        class=" text-primary textFail text-danger"></span><span
                                                                        class=" text-primary textSuccess text-success"></span></label>
                                                                <div class="input-group mb-2 mr-sm-2">
                                                                    <div class="input-group-prepend">
                                                                        <div class="btnCheck input-group-text"><i
                                                                                class=" fas fa-check-circle-o"></i></div>
                                                                    </div>
                                                                    <input type="text" class="form-control toPhone"
                                                                        name="to_phone"
                                                                        id="inlineFormInputGroupUsername2">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Amount</label>
                                                                <input type="number" class=" form-control"
                                                                    name="amount">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Description</label>
                                                                <input type="text" class=" form-control"
                                                                    name="description">
                                                            </div>
                                                            <button type="button"
                                                                class="mt-3 btn btn-primary btnSubmit">Sent Money <i
                                                                    class=" text-white fas fa-paper-plane"></i></button>
                                                        </form>
                                                    </div>
                                                </div>
                                                {{-- Sent money with scan --}}
                                                <div id="navpills-2" class="tab-pane">
                                                    <div class="row align-items-center">
                                                        <div class="">
                                                            <video class=" w-100" id="scan"></video>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class=" float-right" style=" width : 80px ; height : 80px"><img class="w-100"
                                    id="images" src="data:image/png;base64, {!! base64_encode(
                                        QrCode::format('png')->size(300)->generate(Auth::user()->phone),
                                    ) !!} "></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- delivery task --}}
    @if ($tasks)
        <div class="container-fluid">
            <div class="row w-100">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header " style=" background-color : #FFD700">
                            <h3 class=" text-white"><i class="fa fa-list"></i> Pending Task</h3>
                        </div>
                        <div class="card-body" id="pending" style=" background : #f9f8e0">
                            @foreach (collect($tasks)->where('status', 'pending') as $task)
                                <a href="{{ route('delivery.show', $task->id) }}">
                                    <div class="items mb-3" data-id="{{ $task->id }}">
                                        <div class=" d-flex justify-content-between">
                                            <h4 class="">{{ $task->title }}</h4>
                                            <div class=" d-flex ">
                                                <form action="{{ route('delivery.destroy', $task->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button disabled class=" mx-2 btn btn-danger btn-sm"><i
                                                            class=" fas fa-trash-alt"></i></button>
                                                </form>
                                                <div class="">
                                                    <a data-id="{{ $task->id }}" class="editBtn btn btn-sm btn-info"
                                                        data-toggle="modal" data-target=".editModel"><i
                                                            class=" fas fa-edit"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" mt-2 d-flex justify-content-between align-items-center">
                                            <div class="">
                                                <h4><i class=" fas fa-clock"></i>
                                                    {{ Carbon\Carbon::parse($task->deadline)->format('M d') }}</h4>
                                                @if ($task->priority == 'high')
                                                    <div class=" badge badge-pill badge-danger">High</div>
                                                @elseif ($task->priority == 'middle')
                                                    <div class=" badge badge-pill badge-warning text-white">Middle</div>
                                                @elseif ($task->priority == 'low')
                                                    <div class=" badge badge-pill badge-info">Low</div>
                                                @endif
                                            </div>
                                            <div class="">
                                                <img src="{{ asset('storage/' . $task->user->image) }}" id="images"
                                                    class=" img-thumbnail"
                                                    style=" border-radius : 100% ; width : 70px ; height : 70px">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                {{-- in progress task --}}
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header " style=" background-color : cyan">
                            <h3 class=" text-white"><i class="fa fa-list"></i> In Progress Task</h3>
                        </div>
                        <div class="card-body" id="progress" style=" background-color : #E0FFFF">
                            @foreach (collect($tasks)->where('status', 'in_progress') as $task)
                                <a href="{{ route('delivery.show', $task->id) }}">
                                    <div class="items mb-3" data-id="{{ $task->id }}">
                                        <div class=" d-flex justify-content-between">
                                            <h4 class="">{{ $task->title }}</h4>
                                            <div class=" d-flex ">
                                                <form action="{{ route('delivery.destroy', $task->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button disabled class=" mx-2 btn btn-danger btn-sm"><i
                                                            class=" fas fa-trash-alt"></i></button>
                                                </form>
                                                <div class="">
                                                    <a data-id="{{ $task->id }}" class="editBtn btn btn-sm btn-info"
                                                        data-toggle="modal" data-target=".editModel"><i
                                                            class=" fas fa-edit"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" mt-2 d-flex justify-content-between align-items-center">
                                            <div class="">
                                                <h4><i class=" fas fa-clock"></i>
                                                    {{ Carbon\Carbon::parse($task->deadline)->format('M d') }}</h4>
                                                @if ($task->priority == 'high')
                                                    <div class=" badge badge-pill badge-danger">High</div>
                                                @elseif ($task->priority == 'middle')
                                                    <div class=" badge badge-pill badge-warning text-white">Middle</div>
                                                @elseif ($task->priority == 'low')
                                                    <div class="updateTask badge badge-pill badge-info">Low</div>
                                                @endif
                                            </div>
                                            <div class="">
                                                <img src="{{ asset('storage/' . $task->user->image) }}"
                                                    class=" img-thumbnail"
                                                    style=" border-radius : 100% ; width : 70px ; height : 70px">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                {{-- complete task --}}
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header " style=" background-color : #4CBB17">
                            <h3 class=" text-white"><i class="fa fa-list"></i> Complete Task</h3>
                        </div>
                        <div class="card-body" id="complete" style=" background-color : #eaffde">
                            @foreach (collect($tasks)->where('status', 'complete') as $task)
                                <a href="{{ route('delivery.show', $task->id) }}">
                                    <div class=" items mb-3" data-id="{{ $task->id }}">
                                        <div class=" d-flex justify-content-between">
                                            <h4 class="">{{ $task->title }}</h4>
                                            <div class=" d-flex ">
                                                <form action="{{ route('delivery.destroy', $task->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button disabled class=" mx-2 btn btn-danger btn-sm"><i
                                                            class=" fas fa-trash-alt"></i></button>
                                                </form>
                                                <div class="">
                                                    <a href="" data-id="{{ $task->id }}"
                                                        class="editBtn btn btn-sm btn-info" data-toggle="modal"
                                                        data-target=".editModel"><i class=" fas fa-edit"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" mt-2 d-flex justify-content-between align-items-center">
                                            <div class="">
                                                <h4><i class=" fas fa-clock"></i>
                                                    {{ Carbon\Carbon::parse($task->deadline)->format('M d') }}</h4>
                                                @if ($task->priority == 'high')
                                                    <div class=" badge badge-pill badge-danger">High</div>
                                                @elseif ($task->priority == 'middle')
                                                    <div class=" badge badge-pill badge-warning text-white">Middle</div>
                                                @elseif ($task->priority == 'low')
                                                    <div class=" badge badge-pill badge-info">Low</div>
                                                @endif
                                            </div>
                                            <div class="">
                                                <img src="{{ asset('storage/' . $task->user->image) }}"
                                                    class=" img-thumbnail"
                                                    style=" border-radius : 100% ; width : 70px ; height : 70px">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection
@section('script')
    {!! JsValidator::formRequest('App\Http\Requests\SentMoneyRequest', '#create') !!}
    {!! JsValidator::formRequest('App\Http\Requests\PasswordChangeRequest', '#changePasssword') !!}
    <script>
        $(document).ready(function() {
            // change task status
            sort()

            function sort() {
                var pending = document.getElementById('pending');
                var progress = document.getElementById('progress');
                var complete = document.getElementById('complete');
                Sortable.create(pending, {
                    group: 'taskboard',
                    animation: 300,
                    ghostClass: "sortable-ghost",
                    store: {
                        set: function(sortable) {
                            var order = sortable.toArray().filter(id => !isNaN(id));
                            localStorage.setItem('pending', order.join(','));
                        }
                    },

                    onSort: function(e) {
                        setTimeout(() => {
                            var pending = localStorage.getItem('pending');
                            $.ajax({
                                url: `sortTask?pending=${pending}`,
                                type: 'GET',
                                success: function(res) {
                                    console.log(res);
                                }
                            });
                        }, 1000);
                    },
                });
                // in progress
                Sortable.create(progress, {
                    group: 'taskboard',
                    animation: 300,
                    ghostClass: "sortable-ghost",
                    store: {
                        set: function(sortable) {
                            var order = sortable.toArray().filter(id => !isNaN(id));
                            localStorage.setItem('progress', order.join(','));
                        }
                    },

                    onSort: function(e) {
                        setTimeout(() => {
                            var progress = localStorage.getItem('progress');
                            $.ajax({
                                url: `sortTask?progress=${progress}`,
                                type: 'GET',
                                success: function(res) {
                                    console.log(res);
                                }
                            });
                        }, 1000);
                    },
                });
                // complete
                Sortable.create(complete, {
                    group: 'taskboard',
                    animation: 300,
                    ghostClass: "sortable-ghost",
                    store: {
                        set: function(sortable) {
                            var order = sortable.toArray().filter(id => !isNaN(id));
                            localStorage.setItem('complete', order.join(','));
                        }
                    },

                    onSort: function(e) {
                        setTimeout(() => {
                            var complete = localStorage.getItem('complete');
                            $.ajax({
                                url: `sortTask?complete=${complete}`,
                                type: 'GET',
                                success: function(res) {
                                    console.log(res);
                                }
                            });
                        }, 1000);
                    },
                });
            }
            // phone check
            $(document).on('click', '.btnCheck', function() {
                var toPhone = $('.toPhone').val();
                $.ajax({
                    url: `phoneCheck/${toPhone}`,
                    type: 'GET',
                    success: function(res) {
                        $('.textFail').html(res.msg)
                        $('.textSuccess').html(res)
                    }
                });
            })
            // password check
            $(document).on('click', '.btnSubmit', function(e) {
                e.preventDefault();
                Swal.fire({
                    icon: "info",
                    html: `
                        <label class=" mt-3" style='margin-right : 278px'>Enter Your Password</label>
                        <input class="form-control password" name="password" />
                    `,
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    reverseButtons: true,
                    confirmButtonText: "Confirm"
                }).then((result) => {
                    if (result.isConfirmed) {
                        var password = $('.password').val();
                        $.ajax({
                            url: `passwordCheck/${password}`,
                            type: 'GET',
                            success: function(res) {
                                if (res.status == 200) {
                                    $('#sentForm').submit();
                                }
                                if (res.status == 500) {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Oops...",
                                        text: res.msg,
                                    });
                                }
                            }
                        });
                    }
                });
            })
            const videoElem = document.getElementById('scan')
            $(document).on('click', '.scanBtn', function() {
                qrScanner.start();
            })
            $(document).on('click', '.phoneBtn', function() {
                qrScanner.stop();
            })
            $(document).on('click', '.close', function() {
                qrScanner.stop();
            })
            const qrScanner = new QrScanner(
                videoElem,
                function(res) {
                    if (res) {
                        qrScanner.stop();
                        $.ajax({
                            url: `phoneCheck/${res}`,
                            type: 'GET',
                            success: function(phone) {
                                if (phone.status == 500) {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Oops...",
                                        text: res.msg,
                                    });
                                }
                                if (phone) {
                                    Swal.fire({
                                        icon: "info",
                                        html: `
                                        <label class=" mt-3" style='margin-right : 372px'>Amount</label>
                                        <input class="form-control amount" name="amount" />
                                        <label class=" mt-3" style='margin-right : 355px'>Description</label>
                                        <input class="form-control description" name="description" />
                                        <label class=" mt-3" style='margin-right : 278px'>Enter Your Password</label>
                                        <input class="form-control password" name="password" />
                                       `,
                                        showCancelButton: true,
                                        confirmButtonColor: "#3085d6",
                                        cancelButtonColor: "#d33",
                                        reverseButtons: true,
                                        confirmButtonText: "Confirm"
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            var password = $('.password').val();
                                            var amount = $('.amount').val();
                                            var description = $('.description').val();
                                            $.ajax({
                                                type: 'POST',
                                                url: "sentMoneyScan",
                                                data: {
                                                    password: password,
                                                    to_phone: res,
                                                    amount: amount,
                                                    description: description
                                                },
                                                success: function(finalResult) {
                                                    console.log(finalResult);
                                                    if (finalResult.status ==
                                                        500) {
                                                        Swal.fire({
                                                            icon: "error",
                                                            title: "Oops...",
                                                            text: finalResult
                                                                .msg,
                                                        });
                                                    }
                                                    if (finalResult.status ==
                                                        200) {
                                                        const Toast = Swal
                                                            .mixin({
                                                                toast: true,
                                                                position: "top-end",
                                                                showConfirmButton: false,
                                                            });
                                                        Toast.fire({
                                                            icon: "success",
                                                            title: finalResult
                                                                .msg
                                                        });
                                                        window.location.replace(
                                                            `walletTransaction/${finalResult.trx_no}`
                                                        );
                                                    }
                                                }
                                            });
                                        }
                                    });
                                }
                            }
                        });
                    }
                }
            );
            new Viewer(document.getElementById('images'));
        })
    </script>
@endsection
