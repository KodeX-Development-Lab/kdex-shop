<?php

namespace Database\Seeders;

use App\Models\Salary;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SalarySeeder extends Seeder
{

    public function run(): void
    {
        $user = User::all();
        $month = ['01','02','03','04','05','06','07','08','09','10','11','12'];
        foreach($user as $u){
            foreach($month as $m){
                Salary::create([
                    'user_id' => $u->id,
                    'month' => $m,
                    'year' => '2023',
                    'amount' => '300000'
                ]);
            }
        }
    }
}
