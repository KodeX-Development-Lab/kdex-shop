<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryCreate;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{

    public function index()
    {
        if (!Auth::user()->can('view_category')) {
            return back();
        }
        return view('ecommerce.category.index');
    }

    // dataTable
    public function dataTable()
    {
        $category = Category::all();
        return DataTables::of($category)
            ->editColumn('image', function ($each) {
                return '<img id="images" src="' . asset('storage/' . $each->image) . '" class=" img-thumbnail">';
            })
            ->editColumn('created_at', function ($each) {
                return $each->created_at->format('j/F/Y');
            })
            ->editColumn('updated_at', function ($each) {
                return $each->updated_at->format('j/F/Y');
            })
            ->addColumn('action', function ($each) {
                return '<a href="" data-id="' . $each->id . '" class="editBtn btn btn-sm btn-info"  data-toggle="modal" data-target=".editModel"><i class=" fas fa-edit"></i></a>
            <a href="" data-id="' . $each->id . '" class="deleteBtn btn btn-sm btn-danger"><i class=" fas fa-trash-alt"></i></a>';
            })
            ->addColumn('check', function ($each) {
                return '<input class="form-check-input checkbox_ids" name="ids" type="checkbox" value="' . $each->id . '" id="flexCheckDefault">';
            })
            ->rawColumns(['image', 'action', 'check'])
            ->make(true);
    }

    public function store(CategoryCreate $request)
    {
        if (!Auth::user()->can('create_category')) {
            return back();
        }
        $data = $this->formData($request);
        // image upload
        $image = uniqid() . $request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('public/', $image);
        $data['image'] = $image;
        // create
        Category::create($data);
        return back()->with(['success' => 'Category successfully created']);
    }

    public function edit(string $id)
    {
        if (!Auth::user()->can('edit_category')) {
            return back();
        }
        $category = Category::findOrFail($id);
        return $category;
    }

    public function UpdateData(UpdateCategoryRequest $request)
    {
        if (!Auth::user()->can('edit_category')) {
            return back();
        }
        $data = $this->formData($request);
        $category = Category::findOrFail($request->id);
        // image upload
        if ($request->hasFile('image')) {
            $image = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/', $image);
            $data['image'] = $image;
        } else {
            $data['image'] = $category->image;
        }
        // create
        $category->update($data);
        return back()->with(['success' => 'Category successfully updated']);
    }

    public function destroy(string $id)
    {
        if (!Auth::user()->can('delete_category')) {
            return back();
        }
        Category::where('id', $id)->delete();
        Product::where('category_id', $id)->delete();
        return 'success';
    }

    // check all data deleted
    public function deleteSelectedCategory(Request $request)
    {
        if (!Auth::user()->can('delete_category')) {
            return back();
        }
        Category::whereIn('id', $request->ids)->delete();
        Product::whereIn('category_id', $request->ids)->delete();
        return 'success';
    }

    // form data
    public function formData($request)
    {
        return [
            'name' => $request->name,
        ];
    }
}
