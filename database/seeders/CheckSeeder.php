<?php

namespace Database\Seeders;

use App\Models\Check;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CheckSeeder extends Seeder
{

    public function run(): void
    {
       $user = User::all();
       $period = new CarbonPeriod('2023-01-01',  '2023-12-31');
       foreach ($user as $u) {
        foreach ($period as $p) {
            if(Carbon::parse($p)->format('D') != 'Sat' && Carbon::parse($p)->format('D') != 'Sun'){
                Check::create([
                    'user_id' => $u->id,
                    'date' => Carbon::parse($p)->format('Y-m-d'),
                    'checkin' => Carbon::parse('09:00:00')->subMinutes(rand(-10, 55))->format('H:i:s'),
                    'checkout' => Carbon::parse('18:00:00')->addMinutes(rand(1, 55))->format('H:i:s'),
                   ]);
            }

        }
       }
    }
}
