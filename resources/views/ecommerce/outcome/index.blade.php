@extends('ecommerce.layout.master')
@section('title', 'Outcome')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- delete income -->
                        <button class=" btn btn-danger deleteOutcome">Delete All Selected <i
                                class=" fas fa-trash-alt"></i></button>
                        <div class="table-responsive">
                            <table class="table w-100 table-striped table-bordered  zero-configuration" id="example">
                                <thead>
                                    <tr>
                                        <th><input class="form-check-input" type="checkbox" value=""
                                                id="select_all_ids" />
                                        <th>Title</th>
                                        <th>Message</th>
                                        <th>Amount</th>
                                        <th>Created at</th>
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
                ajax: 'dataTable/outcome',
                mark: true,
                responsive: true,
                processing: true,
                serverSide: true,
                columns: [{
                        'data': 'delete',
                        'name': 'delete',
                        sortable: false
                    }, {
                        'data': 'title',
                        'name': 'title'
                    },
                    {
                        'data': 'message',
                        'name': 'message'
                    },
                    {
                        'data': 'amount',
                        'name': 'amount'
                    },
                    {
                        'data': 'created_at',
                        'name': 'created_at'
                    }
                ],
                order: [
                    [4, 'desc']
                ],
                language: {
                    "paginate": {
                        "next": "<i class=\"fa-solid fa-angles-right\"></i>",
                        "previous": "<i class=\"fa-solid fa-angles-left\"></i>"
                    }
                }
            });
            // check delete
            $('#select_all_ids').click(function() {
                $('.checkbox_ids').prop('checked', $(this).prop('checked'))
            })
            $('.deleteOutcome').click(function() {
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
                            url: "deleteSelectedOutcome",
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
