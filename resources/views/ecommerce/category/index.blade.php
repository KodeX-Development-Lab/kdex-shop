@extends('ecommerce.layout.master')
@section('title', 'Product Category')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- create modal -->
                        <div class=" d-flex ">
                            @include('components.ecommerce.Category.createForm')
                            @include('components.ecommerce.Category.updateForm')
                            <div class="">
                                <button class=" btn btn-danger mx-3 delete">Delete All Selected <i
                                        class=" fa fas-trash-alt"></i></button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table w-100 table-striped table-bordered  zero-configuration" id="example">
                                <thead>
                                    <tr>
                                        <th style="max-width : 10px"><input class="form-check-input" type="checkbox"
                                                value="" id="select_all_ids" /></th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Name_mm</th>
                                        <th>Created at</th>
                                        <th>Updated at</th>
                                        <th>Action</th>
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
    {!! JsValidator::formRequest('App\Http\Requests\CategoryCreate', '#create') !!}
    {!! JsValidator::formRequest('App\Http\Requests\UpdateCategoryRequest', '#update') !!}
    <script>
        $(document).ready(function() {
            //create image append
            $('#image').on('change', function() {
                $('.createImg').html('')
                $('.createImg').append(
                    `<img class=" img-thumbnail" id="images" src="${URL.createObjectURL(event.target.files[0])}">`
                )
            })
            //update image append
            $('#update').on('change', function() {
                $('.updateImg').html('')
                $('.updateImg').append(
                    `<img class=" img-thumbnail" id="images" src="${URL.createObjectURL(event.target.files[0])}">`
                )
            })
            var table = new DataTable('#example', {
                responsive: true,
                ajax: 'dataTable/category',
                mark: true,
                processing: true,
                serverSide: true,
                columns: [{
                        'data': 'check',
                        'name': 'check',
                        'sortable': false
                    },
                    {
                        'data': 'image',
                        'name': 'image'
                    },
                    {
                        'data': 'name',
                        'name': 'name'
                    },
                    {
                        'data': 'name_mm',
                        'name': 'name_mm'
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
                order: [
                    [6, 'desc']
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
                    url: `category/${id}/edit`,
                    type: 'GET',
                    success: function(res) {
                        $('#name_en').val(res.name_en)
                        $('#name_mm').val(res.name_mm)
                        $('#id').val(res.id)
                        $('.updateImg').html('')
                        $('.updateImg').append(
                            `<img class=" img-thumbnail" id="images" src="http://127.0.0.1:8000/storage/${res.image}">`
                        )
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
                            url: `category/${id}`,
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
            // delete all selected
            $('#select_all_ids').click(function() {
                $('.checkbox_ids').prop('checked', $(this).prop('checked'))
            })
            $('.delete').click(function() {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Delete",
                    reverseButtons: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        var all_ids = []
                        $('input:checkbox[name=ids]:checked').each(function() {
                            all_ids.push($(this).val());
                        })
                        $.ajax({
                            type: "POST",
                            url: "deleteSelectedCategory",
                            data: {
                                ids: all_ids
                            },
                            success: function(res) {
                                table.ajax.reload()

                            }
                        })
                        Swal.fire({
                            title: "Deleted!",
                            text: "Your file has been deleted.",
                            icon: "success"
                        });
                    }
                });

            })
        })
    </script>
@endsection
