@extends('ecommerce.layout.master')
@section('title', 'Employee Salary')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- create modal -->
                        <div class=" d-flex justify-content-between">
                            <div class=" d-flex">
                                @include('components.management.salary.createForm')
                                @include('components.management.salary.updateForm')
                                <div class="">
                                    <button class=" btn btn-danger delete mx-3">Delete All Selected <i
                                            class=" fas fa-trash-alt"></i></button>
                                </div>
                            </div>
                            <div class=" d-flex">
                                <select id="selectMonth" class=" form-control select2" style=" width : 150px">
                                    <option value="">-- Select Month --</option>
                                    <option value="">All</option>
                                    <option value="01">January
                                    </option>
                                    <option value="02">February
                                    </option>
                                    <option value="03">March</option>
                                    <option value="04">April</option>
                                    <option value="05">May</option>
                                    <option value="06">June</option>
                                    <option value="07">July</option>
                                    <option value="08">Auguest
                                    </option>
                                    <option value="09">September
                                    </option>
                                    <option value="10">October
                                    </option>
                                    <option value="11">November
                                    </option>
                                    <option value="12">December
                                    </option>
                                </select>
                                <select id="selectYear" name="" class=" form-control select2  "
                                    style=" width : 130px">
                                    <option value="">-- Select Year--</option>
                                    <option value="">All</option>
                                    @foreach ($year as $y)
                                        <option value="{{ $y }}">{{ $y }}</option>
                                    @endforeach
                                </select>
                                <i class=" text-primary mx-3 fa-solid fa-filter" style=" font-size : 25px"></i>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table w-100 table-striped table-bordered  zero-configuration" id="example">
                                <thead>
                                    <tr>
                                        <th style=" max-width : 20px"><input class="form-check-input" type="checkbox"
                                                value="" id="select_all_ids" /></th>
                                        <th>Employee</th>
                                        <th>Month</th>
                                        <th>Year</th>
                                        <th>Salary Amount</th>
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
    {!! JsValidator::formRequest('App\Http\Requests\createSalary', '#create') !!}
    {!! JsValidator::formRequest('App\Http\Requests\updateSalary', '#update') !!}
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
                            columns: [0, 1, 2, 3]
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
                ajax: 'dataTable/salary',
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
                        'data': 'employee',
                        'name': 'employee'
                    },
                    {
                        'data': 'month',
                        'name': 'month'
                    },
                    {
                        'data': 'year',
                        'name': 'year'
                    },
                    {
                        'data': 'amount',
                        'name': 'amount'
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
            $(document).on('click', '.btnSalary', function() {
                $.ajax({
                    type: 'GET',
                    url: " salary/create",
                    success: function(data) {
                        $('.createSalaryForm').html(data)
                    }
                });
            })
            // edit each data
            $(document).on('click', '.editBtn', function(e) {
                e.preventDefault();
                var id = $(this).data('id')
                $.ajax({
                    url: `salary/${id}/edit`,
                    type: 'GET',
                    success: function(res) {
                        $('.salaryUpdateForm').html(res)
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
                            url: `salary/${id}`,
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
            // delete select all data
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
                            url: "deleteSelectedSalary",
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
            // filter
            $(document).on('click', '.fa-filter', function() {
                var month = $('#selectMonth').val()
                var year = $('#selectYear').val()
                table.ajax.url(`dataTable/salary?month=${month}&year=${year}`).load()
                // table.ajax.reload()
            })
        })
    </script>
@endsection
