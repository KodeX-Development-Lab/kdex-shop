@extends('ecommerce.layout.master')
@section('title', 'Product Category')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class=" d-flex justify-content-between">
                            <button class=" btn btn-primary delete">Delete all selected <i
                                    class=" fas fa-trash-alt"></i></button>
                            <select class=" form-control filterStatus">
                                <option value="">All</option>
                                <option value="pending">Pending</option>
                                <option value="accept">Accept</option>
                                <option value="reject">Reject</option>
                            </select>
                        </div>
                        <div class="table-responsive">
                            <table class="table w-100 table-striped table-bordered  zero-configuration" id="example">
                                <thead>
                                    <tr>
                                        <th class="">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="select_all_ids" />
                                        </th>
                                        <th>Image</th>
                                        <th>Product Name</th>
                                        <th>Customer Name</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Quantity</th>
                                        <th>Total Price</th>
                                        <th>Status</th>
                                        <th>Created at</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Order Status Change</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body orderForm">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            // datatable start
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
                            var jsDate = now.getDate() + '-' + (now.getMonth() + 1) + '-' +
                                now
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
                                            text: 'Product Order List ' +
                                                jsDate,
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
                ajax: `dataTable/order`,
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
                        'data': 'productName',
                        'productName': 'productName'
                    },
                    {
                        'data': 'customer_name',
                        'customer_name': 'customer_name'
                    },
                    {
                        'data': 'phone',
                        'phone': 'phone'
                    },
                    {
                        'data': 'address',
                        'address': 'address'
                    },
                    {
                        'data': 'qty',
                        'qty': 'qty'
                    },
                    {
                        'data': 'total',
                        'total': 'total'
                    },
                    {
                        'data': 'status',
                        'status': 'status'
                    },
                    {
                        'data': 'created_at',
                        'created_at': 'created_at'
                    }
                ],
                language: {
                    "paginate": {
                        "next": "<i class=\"fa-solid fa-angles-right\"></i>",
                        "previous": "<i class=\"fa-solid fa-angles-left\"></i>"
                    }
                },
                order: [
                    [9, 'desc']
                ],
            });
            // datatable end

            // filter status start
            $(document).on('change', '.filterStatus', function() {
                const status = $('.filterStatus').val();
                table.ajax.url(`dataTable/order?status=${status}`).load()
            })
            // filter status end

            // change order status
            $(document).on('click', '.changeStatus', function() {
                const id = $(this).data('id')
                $.ajax({
                    url: `orderForm/${id}`,
                    type: "GET",
                    success: function(res) {
                        $('.orderForm').html(res)
                    }
                });
            })

            // check delete
            $('#select_all_ids').click(function() {
                $('.checkbox_ids').prop('checked', $(this).prop('checked'))
            });
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
                            url: "deleteSelected",
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
