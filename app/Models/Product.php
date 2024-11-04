<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'supplier_id',
        'brand_id',
        'name_en',
        'name_mm',
        'image',
        'description',
        'buy_price',
        'sale_price',
        'discount_price',
        'total_qty',
        'view',
    ];
    protected $appends = ['imageURL'];

    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image);
    }

    // product color pivot
    public function color()
    {
        return $this->belongsToMany(Color::class, 'product_color');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
