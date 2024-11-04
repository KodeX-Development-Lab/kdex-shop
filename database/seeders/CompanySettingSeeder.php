<?php

namespace Database\Seeders;

use App\Models\CompanySetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySettingSeeder extends Seeder
{

    public function run(): void
    {
        CompanySetting::create([
            'name' =>  'Goody',
            'email' => 'goody@gmail.com',
            'phone' => '09794257469',
            'address' => 'Yangon,Hmawbi,Phugyi',
            'office_start_time' => '09:00:00',
            'office_end_time' => '18:00:00',
            'break_start_time' => '12:00:00',
            'break_end_time' => '13:00:00'
        ]);
    }
}
