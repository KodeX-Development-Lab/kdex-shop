@extends('ecommerce.layout.master')
@section('title', 'Product')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="">
                            <a href="{{ route('product.create') }}" class=" btn btn-primary">Create Product <i
                                    class=" fas fa-plus-circle"></i></a>
                            <button class=" btn btn-danger delete">Delete All Selected <i
                                    class=" fas fa-trash-alt"></i></button>
                        </div>
                        <div class="table-responsive">
                            <table class="table w-100 table-striped table-bordered  zero-configuration" id="example">
                                <thead>
                                    <tr>
                                        <th style="max-width : 10px">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="select_all_ids" />
                                        </th>
                                        <th>Image</th>
                                        <th>Name(Eng)</th>
                                        <th>Name(MM)</th>
                                        <th>Price</th>
                                        <th>Total Qty</th>
                                        <th>Supplier</th>
                                        <th>Category</th>
                                        <th>Brand</th>
                                        <th>Action</th>
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
                        title: 'Product List',
                        orientation: 'portrait',
                        pageSize: 'A4',
                        exportOptions: {
                            columns: [1, 3, 4, 5, 6, 7]
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
                                            text: 'Product List Table ' + jsDate,
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
                ajax: 'dataTable/product',
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
                        'data': 'image',
                        'name': 'image'
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
                        'data': 'price',
                        'name': 'price'
                    },
                    {
                        'data': 'total_qty',
                        'name': 'total_qty'
                    },
                    {
                        'data': 'supplier',
                        'name': 'supplier',
                    },
                    {
                        'data': 'category',
                        'name': 'category'
                    },
                    {
                        'data': 'brand',
                        'name': 'brand'
                    },
                    {
                        'data': 'action',
                        'name': 'action'
                    },
                    {
                        'data': 'updated_at',
                        'name': 'updated_at'
                    }
                ],
                language: {
                    "paginate": {
                        "next": "<i class=\"fa-solid fa-angles-right\"></i>",
                        "previous": "<i class=\"fa-solid fa-angles-left\"></i>"
                    }
                },
                order: [
                    [10, 'desc']
                ],
                columnDefs: [{
                    target: 10,
                    visible: false
                }]
            });
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
                            url: `product/${id}`,
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

            // add qty
            $(document).on('click', '.qtyPlus', function(e) {
                e.preventDefault()
                var id = $(this).data('id')
                $.ajax({
                    url: `product/addQty/${id}`,
                    type: 'PUT',
                    success: function(data) {
                        table.ajax.reload();
                    }
                });
            })
            // add qty
            $(document).on('click', '.reduceQty', function(e) {
                e.preventDefault()
                var id = $(this).data('id')
                $.ajax({
                    url: `product/reduceQty/${id}`,
                    type: 'PUT',
                    success: function(data) {
                        table.ajax.reload();
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
                            url: "deleteSelectedProduct",
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
