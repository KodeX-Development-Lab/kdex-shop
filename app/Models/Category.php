<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name_mm','image','name_en'];

    public function product(){
        return $this->hasMany(Product::class);
    }

    protected $appends = ['imageURL'];

    public function getImageUrlAttribute(){
        return asset('storage/'.$this->image);
    }
}
