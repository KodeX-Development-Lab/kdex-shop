@extends('ecommerce.layout.master')
@section('title', 'Employee Role')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- create modal -->
                        @include('components.management.role.createForm')
                        @include('components.management.role.updateForm')
                        <div class="table-responsive">
                            <table class="table w-100 table-striped table-bordered  zero-configuration" id="example">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Permission</th>
                                        <th>Created at</th>
                                        <th>Updated at</th>
                                        <th style=" min-width : 60px">Action</th>
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
    {!! JsValidator::formRequest('App\Http\Requests\createRole', '#create') !!}
    {!! JsValidator::formRequest('App\Http\Requests\updateRole', '#update') !!}
    <script>
        $(document).ready(function() {

            var table = new DataTable('#example', {
                ajax: 'dataTable/role',
                mark: true,
                responsive: true,
                processing: true,
                serverSide: true,
                columns: [{
                        'data': 'name',
                        'name': 'name'
                    },
                    {
                        'data': 'permission',
                        'name': 'permission'
                    },
                    {
                        'data': 'created_at',
                        'name': 'created_at'
                    },
                    {
                        'data': 'updated_at',
                        'name': 'updated_at'
                    },
                    {
                        'data': 'action',
                        'name': 'action'
                    }
                ],
                language: {
                    "paginate": {
                        "next": "<i class=\"fa-solid fa-angles-right\"></i>",
                        "previous": "<i class=\"fa-solid fa-angles-left\"></i>"
                    }
                }
            });
            // edit each data
            $(document).on('click', '.editBtn', function(e) {
                e.preventDefault();
                var id = $(this).data('id')
                $.ajax({
                    url: `role/${id}/edit`,
                    type: 'GET',
                    success: function(res) {
                        console.log(res);
                        $('.roleUpdate').html(res)
                    }
                });
            })
            //delete
            $(document).on('click', '.deleteBtn', function(e) {
                e.preventDefault();
                var id = $(this).data('id')
                Swal.fire({
                    title: "Are you sure?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    reverseButtons: true,
                    confirmButtonText: "Delete"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: `role/${id}`,
                        }).done(function(msg) {
                            table.ajax.reload();
                            Swal.fire({
                                title: "Deleted!",
                                text: "Your file has been deleted.",
                                icon: "success"
                            });
                        });

                    }
                });

            })
        })
    </script>
@endsection
