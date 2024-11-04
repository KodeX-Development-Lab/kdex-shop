@extends('ecommerce.layout.master')
@section('title', 'Employee')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table w-100 table-striped table-bordered  zero-configuration" id="example">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Updated At</th>
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
                        title: 'Employee List',
                        orientation: 'portrait',
                        pageSize: 'A4',
                        exportOptions: {
                            columns: [1, 2, 3]
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
                                            text: 'Employee List Table ' + jsDate,
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
                            doc.content[0].table.widths = '14%,14%,14.29%,14%,14%,14%,14%,'
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
                ajax: 'dataTable/customer',
                mark: true,
                processing: true,
                responsive: true,
                serverSide: true,
                columns: [{
                        'data': 'image',
                        'name': 'image',
                        sortable: false,
                        searchable: false
                    },
                    {
                        'data': 'name',
                        'name': 'name'
                    },
                    {
                        'data': 'email',
                        'name': 'email',
                        sortable: false
                    },
                    {
                        'data': 'phone',
                        'name': 'phone',
                        sortable: false
                    },
                    {
                        'data': 'updated_at',
                        'name': 'updated_at'
                    }
                ],
                order: [
                    [4, 'desc']
                ],
                columnDefs: [{
                    target: 4,
                    visible: false
                }],
                language: {
                    "paginate": {
                        "next": "<i class=\"fa-solid fa-angles-right\"></i>",
                        "previous": "<i class=\"fa-solid fa-angles-left\"></i>"
                    }
                }
            });

        })
    </script>
@endsection
