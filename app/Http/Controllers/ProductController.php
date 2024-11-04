<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCreate;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Outcome;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index()
    {
        if (!Auth::user()->can('view_product')) {
            return back();
        }
        return view('ecommerce.product.index');
    }

    // dataTable
    public function dataTable()
    {
        $product = Product::with('category', 'supplier', 'brand');
        return DataTables::of($product)
            ->editColumn('image', function ($each) {
                return '<img  src="' . asset('storage/' . $each->image) . '" class=" img-thumbnail"">';
            })
            ->editColumn('supplier', function ($each) {
                return $each->supplier ? $each->supplier->name_en : '-';
            })
            ->filterColumn('supplier', function ($query, $keyword) {
                $query->whereHas('supplier', function ($q1) use ($keyword) {
                    $q1->where('name_en', 'like', '%' . $keyword . '%');
                });
            })
            ->editColumn('category', function ($each) {
                return $each->category ? $each->category->name_en : '-';
            })
            ->filterColumn('category', function ($query, $keyword) {
                $query->whereHas('category', function ($q1) use ($keyword) {
                    $q1->where('name_en', 'like', '%' . $keyword . '%');
                });
            })
            ->editColumn('brand', function ($each) {
                return $each->brand ? $each->brand->name_en : '-';
            })
            ->filterColumn('brand', function ($query, $keyword) {
                $query->whereHas('brand', function ($q1) use ($keyword) {
                    $q1->where('name_en', 'like', '%' . $keyword . '%');
                });
            })
            ->addColumn('price', function ($each) {
                return '<p>Buy Price -' . $each->buy_price . '</p><p> Sale Price -' . $each->sale_price . '</p><p> Discount Price' . $each->discount_price . '</p>';
            })
            ->addColumn('total_qty', function ($each) {
                return '<a data-id="' . $each->id . '" href="" class="reduceQty btn btn-primary"><i class=" fas fa-minus"></i></a> ' . $each->total_qty . ' <a href="" data-id="' . $each->id . '" class=" btn btn-primary qtyPlus"><i class=" fas fa-plus"></i></a>';
            })
            ->addColumn('check', function ($each) {
                return '<input class="form-check-input checkbox_ids" name="ids" type="checkbox" value="' . $each->id . '" id="flexCheckDefault">';
            })
            ->addColumn('action', function ($each) {
                return '<a class=" btn btn-info mx-3" href="' . route('product.edit', $each->id) . '"><i class="fas fa-edit"></i></a>
                   <a class=" btn btn-danger deleteBtn" data-id="' . $each->id . '"><i class=" fas fa-trash-alt text-white"></i></a>';
            })
            ->rawColumns(['image', 'price', 'action', 'total_qty', 'check'])
            ->make(true);
    }

    public function create()
    {
        if (!Auth::user()->can('view_product')) {
            return back();
        }
        $supplier = Supplier::all();
        $color = Color::all();
        $brand = Brand::all();
        $category = Category::all();
        return view('ecommerce.product.create', compact('color', 'category', 'brand', 'supplier'));
    }

    public function store(ProductCreate $request)
    {
        if (!Auth::user()->can('create_product')) {
            return back();
        }
        DB::beginTransaction();
        try {
            $data = $this->formData($request);
            //  image
            $image = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/', $image);
            $data['image'] = $image;
            $product = Product::create($data);
            $product->color()->sync($request->color_id);
            Outcome::create([
                'title' => 'Buy Product',
                'message' => 'Bought ' . $product->name_en,
                'amount' => $product->total_qty * $product->buy_price,
            ]);
            $adminWallet = Wallet::find(1);
            $adminWallet->update([
                'amount' => $adminWallet->amount - ($product->total_qty * $product->buy_price),
            ]);

            DB::commit();
            return redirect()->route('product.index')->with(['success' => 'Product successfully created']);
        } catch (\Exception $e) {
            DB::rollback();
        }

    }

    public function edit(string $id)
    {
        if (!Auth::user()->can('edit_product')) {
            return back();
        }
        $product = Product::where('id', $id)->with('category', 'color', 'brand', 'supplier')->first();
        $supplier = Supplier::all();
        $color = Color::all();
        $brand = Brand::all();
        $category = Category::all();
        return view('ecommerce.product.edit', compact('supplier', 'color', 'product', 'brand', 'category'));
    }

    public function update(UpdateProductRequest $request, string $id)
    {
        if (!Auth::user()->can('edit_product')) {
            return back();
        }
        DB::beginTransaction();
        try {
            $data = $this->formData($request);
            $product = Product::where('id', $id)->first();
            //  image
            if ($request->hasFile('image')) {
                $image = uniqid() . $request->file('image')->getClientOriginalName();
                $request->file('image')->storeAs('public/', $image);
                $data['image'] = $image;
            } else {
                $data['image'] = $product->image;
            }
            $product->update($data);
            $product->color()->sync($request->color_id);
            DB::commit();
            return redirect()->route('product.index')->with(['success' => 'Product successfully created']);
        } catch (\Exception $e) {
            DB::rollback();
        }
    }

    public function destroy(string $id)
    {
        if (!Auth::user()->can('delete_product')) {
            return back();
        }
        Product::where('id', $id)->delete();
        return 'success';
    }

    // add quantity
    public function addQty($id)
    {
        $product = Product::where('id', $id)->first();
        $product->update(['total_qty' => $product->total_qty + 1]);
        Outcome::create([
            'title' => 'Buy Product',
            'message' => 'Bought ' . $product->name_en,
            'amount' => $product->buy_price,
        ]);
        $adminWallet = Wallet::find(1);
        $adminWallet->update([
            'amount' => $adminWallet->amount - $product->buy_price,
        ]);
        return 'success';
    }

    // add quantity
    public function reduceQty($id)
    {
        $product = Product::where('id', $id)->first();
        $product->update(['total_qty' => $product->total_qty - 1]);
        return 'success';
    }

    // delete all selected
    public function deleteSelectedProduct(Request $request)
    {
        if (!Auth::user()->can('delete_product')) {
            return back();
        }
        Product::whereIn('id', $request->ids)->delete();
        return 'success';
    }

    // data
    public function formData($request)
    {
        return [
            'name_mm' => $request->name_mm,
            'name_en' => $request->name_en,
            'description' => $request->description,
            'buy_price' => $request->buy_price,
            'sale_price' => $request->sale_price,
            'discount_price' => $request->discount_price,
            'category_id' => $request->category_id,
            'supplier_id' => $request->supplier_id,
            'brand_id' => $request->brand_id,
            'color' => $request->color_id,
            'total_qty' => $request->total_qty,
        ];
    }
}
