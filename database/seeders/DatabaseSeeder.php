<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Brand;
use App\Models\Color;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            EmployeeSeeder::class,
            SalarySeeder::class,
            CheckSeeder::class,
            CompanySettingSeeder::class,
            DepartmentSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
        ]);

        $Brand = ['Apple', 'Samsung', 'I-Max', 'Nike'];
        $Brand_mm = ['ပန်းသီး', 'ဆမ်ဆောင်း', 'အိုင်းမတ်', 'နီကီ'];
        foreach ($Brand as $key => $b) {
            Brand::create([
                'name_mm' => $Brand_mm[$key],
                'name_en' => $b,
            ]);
        }

        $color = ['Red', 'Green', 'Blue', 'Black', 'Silver', 'White'];
        $color_mm = ['အနီေရာင်', 'အစိမ်းရောင်', 'အပြာရောင်', 'အနက်ရောင်', 'ငွေရောင်', 'အဖြူရောင်'];
        foreach ($color as $key => $c) {
            Color::create([
                'name_mm' => $color_mm[$key],
                'name_en' => $c,
            ]);
        }

        Supplier::create([
            'name_mm' => 'ပေးသွင်းသူ',
            'name_en' => 'Supplier One',
        ]);
    }
}
