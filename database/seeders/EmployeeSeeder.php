<?php

namespace Database\Seeders;

use App\Helpers\CodeGenerate;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{

    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'image' => 'man.png',
            'email' => 'admin@gmail.com',
            'phone' => '09794257469',
            'nrc_number' => '12/mbn(192865)',
            'birthday' => '2001-04-23',
            'join_date' => '2023-04-23',
            'gender' => 'male',
            'group' => 'employee',
            'address' => 'Hmawbi Phugyi',
            'department_id' => '1',
            'is_present' => '1',
            'pin_code' => '000000',
            'employee_id' => 'Goody-000',
            'email_verified_at' => now(),
            'password' => Hash::make('123123'),
        ]);
        $admin->syncRoles([1]);
        Wallet::firstOrCreate([
            'user_id' => $admin->id,
        ], [
            'account_number' => CodeGenerate::accountNumber(),
        ]);

        //  Hr
        $Hr = User::create([
            'name' => 'Hr',
            'image' => 'hr.jpeg',
            'email' => 'hr@gmail.com',
            'phone' => '09111111111',
            'nrc_number' => '12/mbn(111111)',
            'birthday' => '2001-04-23',
            'join_date' => '2023-04-23',
            'gender' => 'male',
            'group' => 'employee',
            'address' => 'Hmawbi Phugyi',
            'department_id' => '4',
            'is_present' => '1',
            'pin_code' => '111111',
            'employee_id' => 'Goody-001',
            'email_verified_at' => now(),
            'password' => Hash::make('123123'),
        ]);
        $Hr->syncRoles([2]);
        Wallet::firstOrCreate([
            'user_id' => $Hr->id,
        ], [
            'account_number' => CodeGenerate::accountNumber(),
        ]);

        // delivery one
        $deliveryOne = User::create([
            'name' => 'deliveryOne',
            'image' => 'delivery1.jpg',
            'email' => 'deliveryOne@gmail.com',
            'phone' => '09222222222',
            'nrc_number' => '12/mbn(222222)',
            'birthday' => '2001-04-23',
            'join_date' => '2023-04-23',
            'gender' => 'male',
            'group' => 'employee',
            'address' => 'Hmawbi Phugyi',
            'department_id' => '4',
            'is_present' => '1',
            'pin_code' => '222222',
            'employee_id' => 'Goody-003',
            'email_verified_at' => now(),
            'password' => Hash::make('123123'),
        ]);
        $deliveryOne->syncRoles([3]);
        Wallet::firstOrCreate([
            'user_id' => $deliveryOne->id,
        ], [
            'account_number' => CodeGenerate::accountNumber(),
        ]);

        // delivery three
        $deliveryTwo = User::create([
            'name' => 'deliveryTwo',
            'image' => 'delivery2.jpg',
            'email' => 'deliveryTwo@gmail.com',
            'phone' => '09333333333',
            'nrc_number' => '12/mbn(333333)',
            'birthday' => '2001-04-23',
            'join_date' => '2023-04-23',
            'gender' => 'male',
            'group' => 'employee',
            'address' => 'Hmawbi Phugyi',
            'department_id' => '4',
            'is_present' => '1',
            'pin_code' => '333333',
            'employee_id' => 'Goody-004',
            'email_verified_at' => now(),
            'password' => Hash::make('123123'),
        ]);
        $deliveryTwo->syncRoles([3]);
        Wallet::firstOrCreate([
            'user_id' => $deliveryTwo->id,
        ], [
            'account_number' => CodeGenerate::accountNumber(),
        ]);
    }
}
