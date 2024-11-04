<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{

    public function run(): void
    {
        // phone
        $product = ['iPhone 6', 'iPhone 7', 'iPhone 7 Plus', 'iPhone 8 Plus', 'iPhone XS MAX', 'iPhone 11 Pro Max', 'iPhone 12 Pro Max',
            'iPhone 12', 'iPxhone 13', 'iPhone 13 Pro', ' iPhone 13 Pro Max', 'iPhone 14', 'iPhone 14 Pro Max',
        ];
        $product_mm = ['အိုင်ဖုန်း ၆', 'အိုင်ဖုန်း ၇', 'အိုင်ဖုန်း ၇ အပေါင်း', 'အိုင်ဖုန်း ၈ အပေါင်း', 'အိုင်ဖုန်း XS အများဆုံး', 'အိုင်ဖုန်း ၁၁ Pro Max', 'အိုင်ဖုန်း ၁၂ Pro အများဆုံး',
            'အိုင်ဖုန်း ၁၂', 'အိုင်ဖုန်း ၁၃', 'အိုင်ဖုန်း ၁၃ Pro', ' အိုင်ဖုန်း ၁၃ Pro အများဆုံး', 'အိုင်ဖုန်း ၁၄', 'အိုင်ဖုန်း ၁၄ Pro အများဆုံး',
        ];
        $images = ['iphone6.jpg', 'iphone7.jpg', 'iphone7plus.webp', 'iphone8plus.jpeg', 'iphoneXsMax.webp', 'iphone11promax.jpg',
            'iphone12promax.jpg', 'iphon12.png', 'iphone13.jpg', 'iphone13pro.jpg', 'iphone13promax.jpg', 'iphone14.png', 'iphone14promax.jpg',
        ];

        foreach ($product as $key => $p) {
            $product = Product::create([
                'name_mm' => $product_mm[$key], // Replace with the actual Myanmar name if needed
                'name_en' => $p,
                'category_id' => '1',
                'supplier_id' => '1',
                'brand_id' => '1',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in',
                'buy_price' => '300',
                'sale_price' => '350',
                'discount_price' => '340',
                'total_qty' => '10',
                'image' => $images[$key],
            ]);

            $product->color()->sync([4, 5, 6]);
        }

        // laptop
        $product_mm = ['မက်ဘုတ်အဲ M2', 'မက်ဘုတ်အဲ M1', 'မက်ဘုတ်အဲပရို M3'];
        $product = ['Mac Book Air M2', 'Mac Book Air M1', 'Mac Book Pro M3'];
        $images = ['macbookairm2.jpeg', 'macbookairm1.jpeg', 'Mac Book Pro M3.jpeg'];

        foreach ($product as $key => $p) {
            $product = Product::create([
                'name_mm' => $product_mm[$key],
                'name_en' => $p,
                'category_id' => '2',
                'supplier_id' => '1',
                'brand_id' => '1',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in',
                'buy_price' => '400',
                'sale_price' => '450',
                'discount_price' => '440',
                'total_qty' => '10',
                'image' => $images[$key],
            ]);

            $product->color()->sync([4, 5, 6]);
        }

        // shirt
        $product = ['Men cotton shirt', 'Men Antler shirt', 'Men Cartoon & Slogan', 'Men Expression Print', 'Men 1pc Random'];
        $product_mm = ['အမျိုးသားဝတ်အင်္ကျီ', 'ယောက်ျား သမင်ချိုအင်္ကျီ', 'ယောက်ျားပုံးပုံးဆောင်ပုဒ်', 'ယောက်ျားအသုံးအနှုန်း', 'အမျိုးသားများ 1pc ကျပန်း'];

        $images = ['shirt1.jpg', 'shirt2.jpg', 'shirt3.jpg', 'shirt4.jpg', 'shirt5.jpg'];

        foreach ($product as $key => $p) {
            $product = Product::create([
                'name_mm' => $product_mm[$key],
                'name_en' => $p,
                'category_id' => '4',
                'supplier_id' => '1',
                'brand_id' => '3',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in',
                'buy_price' => '40',
                'sale_price' => '50',
                'discount_price' => '45',
                'total_qty' => '10',
                'image' => $images[$key],
            ]);

            $product->color()->sync([4, 5, 6]);
        }

        // shoe
        $product = ['Nike Air Max Shoes', 'Nike Air Max Brown', 'Nike Jordan Pro Strong', 'Nike Air Trainer', 'Custom Sneakers'];
        $product_mm = ['နီကီအဲမက်ဖိနပ်', 'နီကီအဲမက်ဘရောင်း', 'နီကီဂျော်ဒန်ခိုင်မာတယ်။', 'နီကီလေကြောင်းသင်တန်းဆရာ', 'စိတ်ကြိုက်ဖိနပ်'];
        $images = ['shoe1.jpg', 'shoe2.jpg', 'shoe3.jpg', 'shoe4.jpg', 'shoe5.jpg'];

        foreach ($product as $key => $p) {
            $product = Product::create([
                'name_mm' => $product_mm[$key],
                'name_en' => $images[$key],
                'category_id' => '3',
                'supplier_id' => '1',
                'brand_id' => '3',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in',
                'buy_price' => '40',
                'sale_price' => '50',
                'discount_price' => '45',
                'total_qty' => '10',
                'image' => $images[$key],
            ]);

            $product->color()->sync([4, 5, 6]);
        }

        // toy
        $product_mm = ['လော့ဖန်စီ', 'ကြီးမားသောမစ္စစင်ဒီ ', 'ချစ်စရာကာတွန်းအကြီးကြီး', 'ချစ်စရာရုပ်လေး'];
        $product = ['LotFancy', 'Misscindy Giant ', 'Cute Cartoon Big', 'Cute Teddy'];
        $images = ['toy1.jpg', 'toy2.jpg', 'toy3.jpg', 'toy4.jpg'];

        foreach ($product as $key => $p) {
            $product = Product::create([
                'name_mm' => $product_mm[$key],
                'name_en' => $p,
                'category_id' => '5',
                'supplier_id' => '1',
                'brand_id' => '3',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in',
                'buy_price' => '20',
                'sale_price' => '30',
                'discount_price' => '25',
                'total_qty' => '10',
                'image' => $images[$key],
            ]);

            $product->color()->sync([4, 5, 6]);
        }
    }
}
