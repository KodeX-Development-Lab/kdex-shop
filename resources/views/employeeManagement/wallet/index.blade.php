@extends('ecommerce.layout.master')
@section('title', 'Employee Wallet')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {{-- add amount --}}
                        <div class="bootstrap-modal">
                            <button type="button" class="btn btn-success text-white" data-toggle="modal"
                                data-target="#addModal">Add Amount <i class=" fas fa-plus-circle"></i></button>
                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                data-target="#basicModal">Reduce Amount <i class=" fas fa-minus-circle"></i></button>
                            <!-- Add Modal -->
                            <div class="modal fade" id="addModal">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Add Wallet Amount </h5>
                                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('addAmount') }}" method="post">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="">Select User</label>
                                                    <select name="user_id" class=" form-control">
                                                        @foreach ($user as $u)
                                                            <option value="{{ $u->id }}">{{ $u->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Add Amount</label>
                                                    <input type="number" name="amount" class=" form-control">
                                                </div>
                                                <button class=" btn btn-primary">Confirm</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- reduce model --}}
                            <div class="modal fade" id="basicModal">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Reduce Wallet Amount </h5>
                                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('reduceAmount') }}" method="post">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="">Select User</label>
                                                    <select name="user_id" class=" form-control">
                                                        @foreach ($user as $u)
                                                            <option value="{{ $u->id }}">{{ $u->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Reduce Amount</label>
                                                    <input type="number" name="amount" class=" form-control">
                                                </div>
                                                <button class=" btn btn-primary">Confirm</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table w-100 table-striped table-bordered  zero-configuration" id="example">
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>Account Number</th>
                                        <th>Phone</th>
                                        <th>Amount(mmk)</th>
                                        <th>Created At</th>
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
                        title: 'Employee Attendance',
                        orientation: 'portrait',
                        pageSize: 'A4',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
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
                                            text: 'Attendance Table ' + jsDate,
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
                ajax: 'dataTable/Wallet',
                mark: true,
                processing: true,
                serverSide: true,
                columns: [{
                        'data': 'employee',
                        'name': 'employee'
                    },
                    {
                        'data': 'account_number',
                        'name': 'account_number'
                    },
                    {
                        'data': 'phone',
                        'name': 'phone'
                    },
                    {
                        'data': 'amount',
                        'name': 'amount'
                    },
                    {
                        'data': 'created_at',
                        'name': 'created_at'
                    },
                    {
                        'data': 'updated_at',
                        'name': 'updated_at'
                    }
                ]
            });
        })
    </script>
@endsection
