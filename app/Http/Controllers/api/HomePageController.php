<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    //home page
    public function allProduct(Request $request)
    {
        if (!$request->category_id) {
            $product = Product::paginate(8);
            return response()->json([
                'data' => $product,
            ]);
        } else {
            $product = Product::where('category_id', $request->category_id)->paginate(8);
            return response()->json([
                'data' => $product,
            ]);
        }
    }

    // review
    public function getReview($id)
    {
        $review = Review::where('product_id', $id)->with('user')->get();
        return $review;
    }

    // category
    public function category()
    {
        $category = Category::withCount('product')->get();
        return response()->json([
            'data' => $category,
        ], 200);
    }

    // color
    public function color()
    {
        $color = Color::all();
        return response()->json([
            'data' => $color,
        ], 200);
    }

    // brand
    public function brand()
    {
        $brand = Brand::all();
        return response()->json([
            'data' => $brand,
        ], 200);
    }

    // product
    public function eachProduct($id)
    {
        $product = Product::where('id', $id)->with('color', 'brand')->first();
        $review = Review::where('product_id', $product->id)->with('user')->get();
        $product->update([
            'view' => $product->view + 1,
        ]);
        return response()->json([
            'data' => $product,
            'review' => $review,
        ]);
    }

    // on sale
    public function onSale()
    {
        $product = Product::take(3)->get();
        return response()->json([
            'data' => $product,
        ]);
    }

    // new
    public function new ()
    {
        $product = Product::take(3)->latest()->get();
        return response()->json([
            'data' => $product,
        ]);
    }

    // view
    public function view()
    {
        $product = Product::take(3)->orderBy('view', 'desc')->get();
        return response()->json([
            'data' => $product,
        ]);
    }

    // review
    public function review(Request $request)
    {
        $request->validate([
            'review' => 'required',
        ]);
        Review::create([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'review' => $request->review,
            'rating' => $request->rating,
        ]);
        $review = Review::where('product_id', $request->product_id)->get();
        return response()->json([
            'status' => 'success',
            'review' => $review,
        ]);
    }

    // productList
    public function productList(Request $request)
    {

        if ($request->paginate == 'all' && $request->sort == 'all') {
            $product = Product::all();
            return response()->json([
                'data' => $product,
            ]);

        } elseif ($request->sort == 'expensive') {
            $product = Product::orderBy('discount_price', 'desc')->get();
            return response()->json([
                'data' => $product,
            ]);
        } elseif ($request->sort == 'cheapest') {
            $product = Product::orderBy('discount_price', 'asc')->get();
            return response()->json([
                'data' => $product,
            ]);
        } elseif ($request->paginate) {
            $product = Product::paginate($request->paginate);
            return response()->json([
                'paginateData' => $product,
            ]);
        }

    }
}
