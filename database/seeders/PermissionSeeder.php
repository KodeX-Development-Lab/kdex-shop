<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{

    public function run(): void
    {
        $permission = [
            'view_income', 'view_outcome', 'view_order', 'view_dashboard', 'view_profile',
            'view_company_setting', 'create_company_setting', 'edit_company_setting', 'delete_company_setting',
            'view_department', 'create_department', 'edit_department', 'delete_department',
            'view_employee', 'create_employee', 'edit_employee', 'delete_employee',
            'view_role', 'create_role', 'edit_role', 'delete_role',
            'view_permission', 'create_permission', 'edit_permission', 'delete_permission',
            'view_attendance', 'create_attendance', 'edit_attendance', 'delete_attendance',
            'view_QrScan',
            'view_attendance_overview', 'create_attendance_overview', 'edit_attendance_overview', 'delete_attendance_overview',
            'view_salary', 'create_salary', 'edit_salary', 'delete_salary',
            'view_delivery_task', 'create_delivery_task', 'edit_delivery_task', 'delete_delivery_task',
            'view_payroll', 'create_payroll', 'edit_payroll', 'delete_payroll',
            'view_wallet', 'create_wallet', 'edit_wallet', 'delete_wallet',
            'view_wallet_transaction',
            'view_add_wallet', 'create_add_wallet', 'edit_add_wallet', 'delete_add_wallet',
            'view_category', 'create_category', 'edit_category', 'delete_category',
            'view_color', 'create_color', 'edit_color', 'delete_color',
            'view_brand', 'create_brand', 'edit_brand', 'delete_brand',
            'view_product', 'create_product', 'edit_product', 'delete_product',
            'view_contact', 'view_customer',
        ];
        foreach ($permission as $p) {
            Permission::create(['name' => $p]);
        }
    }
}
