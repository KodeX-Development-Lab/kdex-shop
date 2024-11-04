<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{

    public function run(): void
    {
        $department = ['Hr','Marketing','Customer_Service','Delivery'];
        foreach($department as $d){
            Department::create([
                'name' => $d
            ]);
        }
    }
}
