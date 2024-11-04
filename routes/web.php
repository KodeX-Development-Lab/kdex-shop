<?php

use App\Http\Controllers\AddWalletMoneyController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendanceOverviewController;
use App\Http\Controllers\AttendanceQrScannerController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\CompanySettingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeliveryTaskController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\IncomeOutcomeController;
use App\Http\Controllers\OrderCOntroller;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\TransferNotificationCOntroller;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\WalletTransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

// language
Route::get('/api/locale', function () {
    return response()->json(['locale' => app()->getLocale()]);
});

Route::get('checkin-checkout', [CheckController::class, 'check'])->name('check');
Route::get('checkInOut/{pinCode}', [CheckController::class, 'checkInOut'])->name('checkInOut');
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware(['auth'])->group(function () {

    // category
    Route::resource('category', CategoryController::class);
    Route::put('UpdateData', [CategoryController::class, 'UpdateData'])->name('UpdateData');
    Route::post('deleteSelectedCategory', [CategoryController::class, 'deleteSelectedCategory']);
    Route::get('dataTable/category', [CategoryController::class, 'dataTable']);
    // color
    Route::resource('color', ColorController::class);
    Route::put('updateColor', [ColorController::class, 'updateColor'])->name('updateColor');
    Route::get('dataTable/color', [ColorController::class, 'dataTable']);
    Route::post("deleteSelectedColor", [ColorController::class, 'deleteSelectedColor']);
    // brand
    Route::resource('brand', BrandController::class);
    Route::put('updateBrand', [BrandController::class, 'updateBrand'])->name('updateBrand');
    Route::get('dataTable/brand', [BrandController::class, 'dataTable']);
    //  product
    Route::resource('product', ProductController::class);
    Route::put('product/addQty/{id}', [ProductController::class, 'addQty'])->name('addQty');
    Route::put('product/reduceQty/{id}', [ProductController::class, 'reduceQty'])->name('reduceQty');
    Route::get('dataTable/product', [ProductController::class, 'dataTable']);
    Route::post('deleteSelectedProduct', [ProductController::class, 'deleteSelectedProduct']);
    // brand
    Route::resource('department', DepartmentController::class);
    Route::put('updateDepartment', [DepartmentController::class, 'updateDepartment'])->name('updateDepartment');
    Route::get('dataTable/department', [DepartmentController::class, 'dataTable']);
    Route::post('deleteSelectedBrand', [BrandController::class, 'deleteSelectedBrand']);
    // order
    Route::resource('order', OrderCOntroller::class);
    Route::get('dataTable/order', [OrderCOntroller::class, 'dataTable']);
    Route::post('deleteSelected', [OrderCOntroller::class, 'deleteSelected']);
    Route::get('orderForm/{id}', [OrderCOntroller::class, 'orderForm'])->name('orderForm');
    Route::post('orderChangeStatus', [OrderCOntroller::class, 'orderChangeStatus'])->name('orderChangeStatus');
    // income outcome
    Route::get('income', [IncomeOutcomeController::class, 'income'])->name('income');
    Route::get('dataTable/income', [IncomeOutcomeController::class, 'dataTableIncome']);
    Route::post('deleteSelectedIncome', [IncomeOutcomeController::class, 'deleteSelectedIncome']);
    Route::get('outcome', [IncomeOutcomeController::class, 'outcome'])->name('outcome');
    Route::post('deleteSelectedOutcome', [IncomeOutcomeController::class, 'deleteSelectedOutcome']);
    Route::get('dataTable/outcome', [IncomeOutcomeController::class, 'dataTableOutcome']);
    // employee
    Route::resource('employee', EmployeeController::class);
    Route::post('deleteSelectedEmployee', [EmployeeController::class, 'deleteSelectedEmployee']);
    Route::get('dataTable/employee', [EmployeeController::class, 'dataTable']);
    // change password
    Route::post('changePassword', [EmployeeController::class, 'changePassword'])->name('changePassword');
    // permission
    Route::resource('permission', PermissionController::class);
    Route::put('updatePermission', [PermissionController::class, 'updatePermission'])->name('updatePermission');
    Route::get('dataTable/permission', [PermissionController::class, 'dataTable']);
    //  role
    Route::resource('role', RoleController::class);
    Route::put('updateRole', [RoleController::class, 'updateRole'])->name('updateRole');
    Route::get('permissions', [RoleController::class, 'permissions'])->name('permissions');
    Route::get('dataTable/role', [RoleController::class, 'dataTable']);
    //  company setting
    Route::resource('company-setting', CompanySettingController::class);
    // dashboard
    Route::get('DataDashboard', [DashboardController::class, 'DataDashboard'])->name('DataDashboard');
    // attendance
    Route::resource('attendance', AttendanceController::class);
    Route::get('myAttendance', [AttendanceController::class, 'myAttendance'])->name('myAttendance');
    Route::get('myAttendanceOverview', [AttendanceController::class, 'myAttendanceOverview'])->name('myAttendanceOverview');
    Route::put('updateAttendance', [AttendanceController::class, 'updateAttendance'])->name('updateAttendance');
    Route::get('dataTable/attendance', [AttendanceController::class, 'dataTable']);
    Route::post('deleteSelectedAttendance', [AttendanceController::class, 'deleteSelectedAttendance']);
    // attendance scanner
    Route::get('attendance-scan', [AttendanceQrScannerController::class, 'attendanceScan'])->name('attendance-scan');
    Route::post('attendanceScan', [AttendanceQrScannerController::class, 'attendanceScanStore'])->name('attendanceScanStore');
    // attendance overview
    Route::get('attendance-overview', [AttendanceOverviewController::class, 'attendanceOverview'])->name('attendance-overview');
    Route::get('attendance-overview-table-filter', [AttendanceOverviewController::class, 'attendanceOverviewTable'])->name('attendanceOverviewTable');
    // salary
    Route::resource('salary', SalaryController::class);
    Route::put('updateSalary', [SalaryController::class, 'updateSalary'])->name('updateSalary');
    Route::get('dataTable/salary', [SalaryController::class, 'dataTable']);
    Route::post('deleteSelectedSalary', [SalaryController::class, 'deleteSelectedSalary']);
    // attendance overview
    Route::get('payroll', [PayrollController::class, 'payroll'])->name('payroll');
    Route::get('payroll-filter', [PayrollController::class, 'payrollFilter'])->name('payroll-filter');
    // delivery task
    Route::resource('delivery', DeliveryTaskController::class);
    Route::put('deliveryTaskUpdate', [DeliveryTaskController::class, 'deliveryTaskUpdate'])->name('deliveryTaskUpdate');
    Route::get('sortTask', [DeliveryTaskController::class, 'sortTask'])->name('sortTask');
    // employee wallet
    Route::resource('wallet', WalletController::class);
    Route::post('addAmount', [WalletController::class, 'addAmount'])->name('addAmount');
    Route::post('reduceAmount', [WalletController::class, 'reduceAmount'])->name('reduceAmount');
    Route::get('dataTable/Wallet', [WalletController::class, 'dataTable']);
    // check wallet phone number
    Route::get('phoneCheck/{phone}', [WalletController::class, 'phoneCheck'])->name('phoneCheck');
    Route::get('passwordCheck/{password}', [WalletController::class, 'passwordCheck'])->name('passwordCheck');
    Route::post('sentMoney', [WalletController::class, 'sentMoney'])->name('sentMoney');
    Route::post('sentMoneyScan', [WalletController::class, 'sentMoneyScan'])->name('sentMoneyScan');
    // wallet transaction
    Route::get('walletTransaction', [WalletTransactionController::class, 'walletTransaction'])->name('walletTransaction');
    Route::get('walletTransactionData', [WalletTransactionController::class, 'walletTransactionData'])->name('walletTransactionData');
    Route::get('walletTransaction/{trx_id}', [WalletTransactionController::class, 'walletTransactionDetail'])->name('walletTransactionDetail');
    // transfer notification
    Route::get('transferNotification', [TransferNotificationCOntroller::class, 'transferNotification'])->name('transferNotification');
    Route::get('transferNotification/{id}', [TransferNotificationCOntroller::class, 'transferNotificationDetail'])->name('transferNotificationDetail');
    // add wallet money
    Route::get('addMoney', [AddWalletMoneyController::class, 'index'])->name('addMony');
    Route::get('dataTable/addMoney', [AddWalletMoneyController::class, 'dataTable']);
    Route::post('addWalletMoney', [AddWalletMoneyController::class, 'addWalletMoney']);
    Route::post('deleteSelectedAddMoney', [AddWalletMoneyController::class, 'deleteSelectedAddMoney']);
    // contact us
    Route::get('contact', [ContactController::class, 'index'])->name('contact');
    Route::get('dataTable/contact', [ContactController::class, 'dataTable']);
    Route::post('deleteSelectedContact', [ContactController::class, 'deleteSelectedContact']);
    // customer
    Route::get('customer', [CustomerController::class, 'index'])->name('customer');
    Route::get('dataTable/customer', [CustomerController::class, 'dataTable']);

});

require __DIR__ . '/auth.php';
