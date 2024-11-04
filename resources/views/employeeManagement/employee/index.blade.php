@extends('ecommerce.layout.master')
@section('title', 'Employee')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class=" d-flex">
                            <a href="{{ route('employee.create') }}" class=" btn btn-primary">Create Employee <i
                                    class=" fas fa-plus-circle"></i></a>
                            <button class=" btn btn-danger mx-2 deleteBtnCheck">Delete all seleted <i
                                    class=" fas fa-trash-alt "></i></button>
                        </div>
                        <div class="table-responsive">
                            <table class="table w-100 table-striped table-bordered  zero-configuration" id="example">
                                <thead>
                                    <tr>
                                        <th>
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="select_all_ids" />
                                        </th>
                                        <th>Image</th>
                                        <th>Employee Id</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Nrc Number</th>
                                        <th>Phone</th>
                                        <th>Join Date</th>
                                        <th>Department</th>
                                        <th>Is Present</th>
                                        <th style=" min-width : 100px">Action</th>
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
                            columns: [2, 2, 3, 4, 5, 6, 7, 8, 9]
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
                ajax: 'dataTable/employee',
                mark: true,
                processing: true,
                responsive: true,
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
                        'data': 'employee_id',
                        'name': 'employee_id'
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
                        'data': 'nrc_number',
                        'name': 'nrc_number'
                    },
                    {
                        'data': 'phone',
                        'name': 'phone'
                    },
                    {
                        'data': 'join_date',
                        'name': 'join_date',
                    },
                    {
                        'data': 'department',
                        'name': 'department'
                    },
                    {
                        'data': 'is_present',
                        'name': 'is_present'
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
                order: [
                    [11, 'desc']
                ],
                columnDefs: [{
                    target: 11,
                    visible: false
                }],
                language: {
                    "paginate": {
                        "next": "<i class=\"fa-solid fa-angles-right\"></i>",
                        "previous": "<i class=\"fa-solid fa-angles-left\"></i>"
                    }
                }
            });
            // delete all check
            $('#select_all_ids').click(function() {
                $('.checkbox_ids').prop('checked', $(this).prop('checked'))
            })
            $('.deleteBtnCheck').click(function() {
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
                            url: "deleteSelectedEmployee",
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
                            url: `employee/${id}`,
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

        })
    </script>
@endsection
