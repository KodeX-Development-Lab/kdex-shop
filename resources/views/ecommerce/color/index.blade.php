@extends('ecommerce.layout.master')
@section('title', 'Product Color')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class=" d-flex">
                            <!-- create modal -->
                            @include('components.ecommerce.Color.createForm')
                            @include('components.ecommerce.Color.updateForm')
                            <div class=" mx-3">
                                <button class=" btn btn-danger delete">Delete All Selected <i
                                        class=" fas fa-trash-alt"></i></button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table w-100 table-striped table-bordered  zero-configuration" id="example">
                                <thead>
                                    <tr>
                                        <th style="max-width : 10px"><input class="form-check-input" type="checkbox"
                                                value="" id="select_all_ids" /></th>
                                        <th>Name_en</th>
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
    {!! JsValidator::formRequest('App\Http\Requests\createColorRequest', '#create') !!}
    {!! JsValidator::formRequest('App\Http\Requests\updateColorRequest', '#update') !!}
    <script>
        $(document).ready(function() {

            var table = new DataTable('#example', {
                ajax: 'dataTable/color',
                mark: true,
                responsive: true,
                processing: true,
                serverSide: true,
                columns: [{
                        'data': 'check',
                        'name': 'check',
                        sortable: false
                    },
                    {
                        'data': 'name_en',
                        'name': 'name_en'
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
                    [5, 'desc']
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
                    url: `color/${id}/edit`,
                    type: 'GET',
                    success: function(res) {
                        $('#name_en').val(res.name_en)
                        $('#name_mm').val(res.name_mm)
                        $('#id').val(res.id)
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
                            url: `color/${id}`,
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
            // select all delete
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
                            url: "deleteSelectedColor",
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
