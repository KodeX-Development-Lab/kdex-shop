<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    //home page
    public function allProduct(Request $request){
        if(!$request->category_id){
            $product = Product::paginate(8);
            return response()->json([
                'data' => $product,
            ]);
        }else{
            $product = Product::where('category_id',$request->category_id)->paginate(8);
            return response()->json([
                'data' => $product,
            ]);
        }
    }
    // category
    public function category(){
        $category = Category::withCount('product')->get();
        return response()->json([
            'data' => $category,
        ]);
    }
    // product
    public function eachProduct($id){
        $product = Product::where('id',$id)->with('color','brand')->first();
        return response()->json([
            'data' => $product
        ]);
    }
}
