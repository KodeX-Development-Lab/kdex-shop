@extends('ecommerce.layout.master')
@section('title', 'Contact')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class=" d-flex">
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
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Subject</th>
                                        <th>Message</th>
                                        <th class=" hidden">Updated At</th>
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
    <script>
        $(document).ready(function() {

            var table = new DataTable('#example', {
                ajax: 'dataTable/contact',
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
                        'data': 'name',
                        'name': 'name'
                    },
                    {
                        'data': 'email',
                        'name': 'email'
                    },
                    {
                        'data': 'phone',
                        'name': 'phone'
                    },
                    {
                        'data': 'subject',
                        'name': 'subject'
                    },
                    {
                        'data': 'message',
                        'name': 'message'
                    },
                    {
                        'data': 'updated_at',
                        'name': 'updated_at'
                    }
                ],
                order: [
                    [7, 'desc']
                ],
                columnDefs: [{
                    target: [6],
                    visible: false
                }],
                language: {
                    "paginate": {
                        "next": "<i class=\"fa-solid fa-angles-right\"></i>",
                        "previous": "<i class=\"fa-solid fa-angles-left\"></i>"
                    }
                }
            });

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
                            url: "deleteSelectedContact",
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
