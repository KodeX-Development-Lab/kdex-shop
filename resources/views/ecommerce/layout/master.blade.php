<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Goody Ecommerces</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">

    {{-- dataTable --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/datatables.mark.js/2.0.0/datatables.mark.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/plug-ins/1.10.13/features/mark.js/datatables.mark.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.6/viewer.min.css">
    <link href="{{ asset('plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <!-- Date picker plugins css -->
    <link href="{{ asset('plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <!-- Daterange picker plugins css -->
    <link href="{{ asset('plugins/timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
    {{-- pdf --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    {{-- fontawesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        rel="stylesheet" />
    <!-- Custom Stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>

    <!--Preloader start-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3"
                    stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--Preloader end-->


    <!--Main wrapper start-->
    <div id="main-wrapper">

        <!--Nav header start-->
        <div class="nav-header">
            <div class="brand-logo">
                <a href="">
                    <b class="logo-abbr"><img src="{{ asset('images/logo.png') }}" alt=""> </b>
                    <span class="logo-compact"><img src="{{ asset('images/logo-compact.png') }}" alt=""></span>
                    <span class="brand-title">
                        <img src="{{ asset('images/logo-text.png') }}" alt="">
                    </span>
                </a>
            </div>
        </div>
        <!--Nav header end-->

        <!--Header start-->
        <div class="header">
            <div class="header-content clearfix">

                <div class="nav-control">
                    <div class="hamburger">
                        <span class="toggle-icon"><i class="icon-menu"></i></span>
                    </div>
                </div>
                <div class="header-left">
                    <div class="input-group icons">
                        <h3 class=" mt-2 text-primary">@yield('title')</h3>
                    </div>
                </div>
                <div class="header-right">
                    <ul class="clearfix">
                        <li class="icons dropdown"><a href="javascript:void(0)" data-toggle="dropdown">
                                <a href="{{ route('contact') }}"> <i class="mdi mdi-email-outline"></i></a>
                            </a>
                            <div class="drop-down animated fadeIn dropdown-menu">
                                <div class="dropdown-content-heading d-flex justify-content-between">
                                    <span class="">3 New Messages</span>

                                </div>
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li class="notification-unread">
                                            <a href="javascript:void()">
                                                <a href="{{ route('transferNotification') }}">
                                                    <img class="float-left mr-3 avatar-img" src="images/avatar/1.jpg"
                                                        alt="">
                                                    <div class="notification-content">
                                                        <div class="notification-heading">Saiful Islam</div>
                                                        <div class="notification-timestamp">08 Hours ago</div>
                                                        <div class="notification-text">Hi Teddy, Just wanted to let you
                                                            ...
                                                        </div>
                                                    </div>
                                                </a>
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </li>
                        <li class="icons dropdown"><a href="{{ route('transferNotification') }}">
                                <i class="mdi mdi-bell-outline"></i>
                                <span class="badge badge-pill gradient-2 badge-primary">
                                    <p style="margin-top: -4px;">{{ Auth::user()->unreadNotifications->count() }}</p>
                                </span>
                            </a>
                        </li>
                        <li class="icons dropdown">
                            <div class="user-img c-pointer position-relative" data-toggle="dropdown">
                                <span class="activity active"></span>
                                <img src="{{ asset('storage/' . Auth::user()->image) }}" height="40"
                                    width="40" alt="">
                            </div>
                            <div class="drop-down dropdown-profile   dropdown-menu">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li>
                                            <a href="{{ route('dashboard') }}"><i class="icon-user"></i>
                                                <span>Profile</span></a>
                                        </li>
                                        <li>
                                            <a href="{{ route('contact') }}"><i class="icon-envelope-open"></i>
                                                <span>Inbox</span>
                                                <div class="badge gradient-3 badge-pill badge-primary">3</div>
                                            </a>
                                        </li>
                                        <hr class="my-2">

                                        <li>
                                            <form action="{{ route('logout') }}" method="post">
                                                @csrf
                                                <button class=" btn btn-sm btn-outline-danger w-100 mx-2">
                                                    <i class="icon-key"></i> <span>Logout</span>
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--Header end ti-comment-alt-->

        <!--Sidebar start-->

        <div class="nk-sidebar">
            <div class="nk-nav-scroll">
                <ul class="metismenu" id="menu">
                    @can('view_income')
                        <li class="nav-label" style=" color : #4540f7">Conpany Business</li>
                    @endcan
                    @can('view_income')
                        <li>
                            <a href="{{ route('income') }}">
                                <i class="fa fa-money" aria-hidden="true"></i><span class="nav-text">Income</span>
                            </a>
                        </li>
                    @endcan
                    @can('view_outcome')
                        <li>
                            <a href="{{ route('outcome') }}">
                                <i class="fa-solid fa-share"></i><span class="nav-text">Outcome</span>
                            </a>
                        </li>
                    @endcan
                    @can('view_order')
                        <li>
                            <a href="{{ route('order.index') }}">
                                <i class="fas fa-shipping-fast"></i><span class="nav-text">Product Order</span>
                            </a>
                        </li>
                    @endcan
                    @can('view_dashboard')
                        <li>
                            <a href="{{ route('DataDashboard') }}">
                                <i class="fa-solid fa-chart-simple"></i><span class="nav-text">Dashboard</span>
                            </a>
                        </li>
                    @endcan
                    @can('view_customer')
                        <li>
                            <a href="{{ route('customer') }}">
                                <i class=" fas fa-users"></i><span class="nav-text">Customer</span>
                            </a>
                        </li>
                    @endcan
                    <li class="nav-label" style=" color : #4540f7">Employee Magnement</li>
                    @can('view_profile')
                        <li>
                            <a href="{{ route('dashboard') }}">
                                <i class="fa-solid fa-face-smile"></i><span class="nav-text">Profile</span>
                            </a>
                        </li>
                    @endcan
                    @can('view_company_setting')
                        <li>
                            <a href="{{ route('company-setting.show', 1) }}">
                                <i class="fa-solid fa-gear"></i><span class="nav-text">Company Setting</span>
                            </a>
                        </li>
                    @endcan
                    @can('view_employee')
                        <li>
                            <a href="{{ route('employee.index') }}">
                                <i class="fa fa-users"></i><span class="nav-text">Employee</span>
                            </a>
                        </li>
                    @endcan
                    @can('view_department')
                        <li>
                            <a href="{{ route('department.index') }}">
                                <i class="fa fa-building"></i><span class="nav-text">Department</span>
                            </a>
                        </li>
                    @endcan
                    @can('view_role')
                        <li>
                            <a href="{{ route('role.index') }}">
                                <i class="fa-solid fa-users-viewfinder"></i><span class="nav-text">Role</span>
                            </a>
                        </li>
                    @endcan
                    @can('view_permission')
                        <li>
                            <a href="{{ route('permission.index') }}">
                                <i class="fa-solid fa-shield-halved"></i><span class="nav-text">Permission</span>
                            </a>
                        </li>
                    @endcan
                    @can('view_attendance')
                        <li>
                            <a href="{{ route('attendance.index') }}">
                                <i class="fa-solid fa-user-check"></i><span class="nav-text">Attendance</span>
                            </a>
                        </li>
                    @endcan
                    @can('view_QrScan')
                        <li>
                            <a href="{{ route('attendance-scan') }}">
                                <i class="fa-solid fa-qrcode"></i><span class="nav-text">Attendance Qr Scan</span>
                            </a>
                        </li>
                    @endcan
                    @can('view_attendance_overview')
                        <li>
                            <a href="{{ route('attendance-overview') }}">
                                <i class="fa-solid fa-street-view"></i><span class="nav-text">Attendance Overview</span>
                            </a>
                        </li>
                    @endcan
                    @can('view_salary')
                        <li>
                            <a href="{{ route('salary.index') }}">
                                <i class="fa-solid fa-money-check-dollar"></i><span class="nav-text">Employee
                                    Salary</span>
                            </a>
                        </li>
                    @endcan
                    @can('view_payroll')
                        <li>
                            <a href="{{ route('payroll') }}">
                                <i class="fa-solid fa-money-bill-wave"></i><span class="nav-text">Employee Payroll</span>
                            </a>
                        </li>
                    @endcan
                    @can('view_delivery_task')
                        <li>
                            <a href="{{ route('delivery.index') }}">
                                <i class="fas fa-shipping-fast"></i><span class="nav-text">Delivery Task</span>
                            </a>
                        </li>
                    @endcan
                </ul>
                <ul class="metismenu" id="menu">
                    @can('view_wallet')
                        <li class="nav-label" style=" color : #4540f7">Wallet</li>
                    @endcan
                    @can('view_wallet')
                        <li>
                            <a href="{{ route('wallet.index') }}">
                                <i class="fa-solid fa-wallet"></i><span class="nav-text">User Wallet</span>
                            </a>
                        </li>
                    @endcan
                    @can('view_wallet_transaction')
                        <li>
                            <a href="{{ route('walletTransaction') }}">
                                <i class="fa-solid fa-newspaper"></i><span class="nav-text">Wallet Transaction</span>
                            </a>
                        </li>
                    @endcan
                    @can('view_add_wallet')
                        <li>
                            <a href="{{ route('addMony') }}">
                                <i class=" fas fa-money-bill"></i><span class="nav-text">Add Wallet Money</span>
                            </a>
                        </li>
                    @endcan
                </ul>
                <ul class="metismenu" id="menu">
                    @can('view_category')
                        <li class="nav-label" style=" color : #4540f7">Ecommerce</li>
                    @endcan
                    @can('view_category')
                        <li>
                            <a href="{{ route('category.index') }}">
                                <i class="fa-solid fa-list"></i><span class="nav-text">Category</span>
                            </a>
                        </li>
                    @endcan
                    @can('view_color')
                        <li>
                            <a href="{{ route('color.index') }}">
                                <i class="fa-solid fa-palette"></i><span class="nav-text">Color</span>
                            </a>
                        </li>
                    @endcan
                    @can('view_brand')
                        <li>
                            <a href="{{ route('brand.index') }}">
                                <i class="fa-brands fa-square-pied-piper"></i><span class="nav-text">Brand</span>
                            </a>
                        </li>
                    @endcan
                    @can('view_product')
                        <li>
                            <a href="{{ route('product.index') }}">
                                <i class="fa fa-product-hunt"></i><span class="nav-text">Product</span>
                            </a>
                        </li>
                    @endcan
                    @can('view_contact')
                        <li>
                            <a href="{{ route('contact') }}">
                                <i class="fa fa-product-hunt"></i><span class="nav-text">Contact</span>
                            </a>
                        </li>
                    @endcan
                </ul>
                </li>
                </ul>
            </div>
        </div>
        <!--Sidebar end-->

        <!--Content body start-->
        <div class="content-body">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
        <!--Content body end-->
    </div>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    {{--  --}}
    {{-- datatable --}}
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.13/features/mark.js/datatables.mark.js"></script>
    <script src="{{ asset('plugins/common/common.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/custom.min.js') }}"></script>
    <script src="{{ asset('js/settings.js') }}"></script>
    <script src="{{ asset('js/gleek.js') }}"></script>
    <script src="{{ asset('js/styleSwitcher.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('plugins/moment/moment.js') }}"></script>
    <script src="{{ asset('js/qr-scanner.umd.min.js') }}"></script>
    <script src="http://SortableJS.github.io/Sortable/Sortable.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.6/viewer.min.js"></script>
    <script src="{{ asset('plugins/moment/moment.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}">
    </script>
    <!-- Clock Plugin JavaScript -->
    <script src="{{ asset('plugins/clockpicker/dist/jquery-clockpicker.min.js') }}"></script>
    <!-- Date Picker Plugin JavaScript -->
    <script src="{{ asset('plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <!-- Date range Plugin JavaScript -->
    <script src="{{ asset('plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('js/push.js/bin/push.min.js') }}"></script>
    <script src="{{ asset('js/push.js/bin/push.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.min.js"
        integrity="sha512-7U4rRB8aGAHGVad3u2jiC7GA5/1YhQcQjxKeaVms/bT66i3LVBMRcBI9KwABNWnxOSwulkuSXxZLGuyfvo7V1A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/plugins-init/form-pickers-init.js') }}"></script>
    {{-- pdf export --}}
    <script
        src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js
                                                                                                                                                                                                                                                                                                                                                                            ">
    </script>
    <script
        src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js
                                                                                                                                                                                                                                                                                                                                                                            ">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.jsdelivr.net/g/mark.js(jquery.mark.min.js)"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <!-- include libraries(jQuery, bootstrap) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    @yield('script')
    <script>
        $(document).ready(function() {
            // csrf token
            let token = document.head.querySelector('meta[name="csrf-token"]')

            if (token) {
                $.ajaxSetup({
                    headers: {
                        'X_CSRF-TOKEN': token.content
                    }
                })
            }
            // new Viewer(document.getElementById('images'));
            $('.select2').select2();
            @if (session('error'))
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "{{ session('error') }}"
                });
            @endif
            @if (session('success'))
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
                Toast.fire({
                    icon: "success",
                    title: "{{ session('success') }}"
                });
                Push.create("{{ session('success') }}", {
                    icon: '/icon.png',
                    timeout: 5000,
                    onClick: function() {
                        window.focus();
                        this.close();
                    }
                });
            @endif

        })
    </script>

</body>

</html>
