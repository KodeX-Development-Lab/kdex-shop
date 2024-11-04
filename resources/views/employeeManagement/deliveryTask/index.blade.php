@extends('ecommerce.layout.master')
@section('title', 'Delivery Task')
@section('content')
    <div class="container-fluid">
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target=".createTask">Add Task <i
                class=" fas fa-plus-circle"></i></button>
        {{-- add task model --}}
        @include('components.management.deliverTask.createDeliveryTask')
        @include('components.management.deliverTask.updateDeliveryTask')
        <div class="row w-100">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header " style=" background-color : #FFD700">
                        <h3 class=" text-white"><i class="fa fa-list"></i> Pending Task</h3>
                    </div>
                    <div class="card-body" id="pending" style=" background : #f9f8e0">
                        @foreach (collect($tasks)->where('status', 'pending') as $task)
                           <a href="{{ route('delivery.show',$task->id) }}">
                            <div class="items mb-3" data-id="{{ $task->id }}">
                                <div class=" d-flex justify-content-between">
                                    <h4 class="">{{ $task->title }}</h4>
                                    <div class=" d-flex ">
                                        <form action="{{ route('delivery.destroy', $task->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class=" mx-2 btn btn-danger btn-sm"><i
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
                          <a href="{{ route('delivery.show',$task->id) }}">
                            <div class="items mb-3" data-id="{{ $task->id }}">
                                <div class=" d-flex justify-content-between">
                                    <h4 class="">{{ $task->title }}</h4>
                                    <div class=" d-flex ">
                                        <form action="{{ route('delivery.destroy', $task->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class=" mx-2 btn btn-danger btn-sm"><i
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
                           <a href="{{ route('delivery.show',$task->id) }}">
                            <div class=" items mb-3" data-id="{{ $task->id }}">
                                <div class=" d-flex justify-content-between">
                                    <h4 class="">{{ $task->title }}</h4>
                                    <div class=" d-flex ">
                                        <form action="{{ route('delivery.destroy', $task->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class=" mx-2 btn btn-danger btn-sm"><i
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
@endsection
@section('script')
    {!! JsValidator::formRequest('App\Http\Requests\CreateTaskDelivery', '#create') !!}
    {!! JsValidator::formRequest('App\Http\Requests\updateTaskDelivery', '#update') !!}
    <script>
        $(document).ready(function() {
            $(document).on('click', '.editBtn', function(e) {
                e.preventDefault();
                var id = $(this).data('id')
                $.ajax({
                    url: `delivery/${id}/edit`,
                    type: 'GET',
                    success: function(res) {
                        $('.updateForm').html(res)
                    }
                });
            })
            sort();

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
        })
    </script>
@endsection
