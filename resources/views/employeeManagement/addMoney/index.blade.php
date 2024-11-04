@extends('ecommerce.layout.master')
@section('title', 'Product Category')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <button class=" btn btn-primary delete">Delete all selected <i class=" fas fa-trash-alt"></i></button>
                        <div class="table-responsive">
                            <table class="table w-100 table-striped table-bordered  zero-configuration" id="example">
                                <thead>
                                    <tr>
                                        <th class="">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="select_all_ids" />
                                        </th>
                                        <th>Image</th>
                                        <th>User name</th>
                                        <th>User Phone</th>
                                        <th>Status</th>
                                        <th>Created at</th>
                                        <th>Updated at</th>
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
                dom: 'Bmfrtip',
                buttons: [{
                        extend: 'pdf',
                        text: 'PDF Download <i class=" fas fa-file-pdf"></i>',
                        className: 'btn text-white',
                        title: 'Product Order',
                        orientation: 'portrait',
                        pageSize: 'A4',
                        exportOptions: {
                            columns: [2, 3, 4, 5, 6, 7, 8, 9]
                        },
                        customize: function(doc) {
                            //Remove the title created by datatTables
                            doc.content.splice(0, 1);
                            var now = new Date();
                            var jsDate = now.getDate() + '-' + (now.getMonth() + 1) + '-' + now
                                .getFullYear();
                            doc.pageMargins = [20, 50, 20, 30];
                            doc.defaultStyle.fontSize = 8;
                            doc.styles.tableHeader.fontSize = 8;
                            doc.styles.tableHeader.alignment = 'left';

                            doc['header'] = (function() {
                                return {
                                    columns: [

                                        {
                                            alignment: 'center',
                                            text: 'Product Order List ' + jsDate,
                                            fontSize: 8,
                                            margin: [10, 0]
                                        }
                                    ],
                                    margin: 15
                                }
                            });

                            doc['footer'] = (function(page, pages) {
                                return {
                                    columns: [{
                                            alignment: 'left',
                                            text: ['Created on: ', {
                                                text: jsDate.toString()
                                            }]
                                        },
                                        {
                                            alignment: 'right',
                                            text: ['page ', {
                                                text: page.toString()
                                            }, ' of ', {
                                                text: pages.toString()
                                            }]
                                        }
                                    ],
                                    margin: 20
                                }
                            });

                            var objLayout = {};
                            objLayout['hLineWidth'] = function(i) {
                                return .5;
                            };
                            objLayout['vLineWidth'] = function(i) {
                                return .5;
                            };
                            objLayout['hLineColor'] = function(i) {
                                return '#aaa';
                            };
                            objLayout['vLineColor'] = function(i) {
                                return '#aaa';
                            };
                            objLayout['paddingLeft'] = function(i) {
                                return 4;
                            };
                            objLayout['paddingRight'] = function(i) {
                                return 4;
                            };
                            doc.content[0].layout = objLayout;
                            doc.content[0].table.widths = '*'
                        }
                    },
                    {
                        extend: 'pageLength',
                        className: 'btn text-white',
                    },
                    {
                        extend: 'excel',
                        className: 'btn text-white',
                        text: 'Excel <i class="fa fa-file-excel-o" ></i>'
                    }
                ],
                ajax: 'dataTable/addMoney',
                mark: true,
                responsive: true,
                processing: true,
                serverSide: true,
                columns: [{
                        'data': 'checkBox',
                        'name': 'checkBox',
                        sortable: false
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
                        'data': 'phone',
                        'phone': 'phone'
                    },
                    {
                        'data': 'status',
                        'name': 'status'
                    },
                    {
                        'data': 'created_at',
                        'created_at': 'created_at'
                    },
                    {
                        'data': 'updated_at',
                        'created_at': 'updated_at'
                    }
                ],
                order: [
                    [6, 'desc']
                ],
                columnDefs: [{
                    target: 6,
                    visible: false
                }],
                language: {
                    "paginate": {
                        "next": "<i class=\"fa-solid fa-angles-right\"></i>",
                        "previous": "<i class=\"fa-solid fa-angles-left\"></i>"
                    }
                }
            });

            // change order status
            $(document).on('change', '.statusChange', function() {
                const id = $(this).data('id')
                const status = $('.statusChange').val()
                $.ajax({
                    url: `addWalletMoney`,
                    type: "post",
                    data: {
                        id,
                        status
                    },
                    success: function(res) {
                        console.log(res);
                    }
                });
            })

            // check delete
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
                            url: "deleteSelectedAddMoney",
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
            // status change
            $(document).on('change', '.status', function() {
                const status = $('.status').val()
                const id = $(this).data('id')
            })
        })
    </script>
@endsection
