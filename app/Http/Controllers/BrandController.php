<?php

namespace App\Http\Controllers;

use App\Http\Requests\createBrandRequest;
use App\Http\Requests\updateBrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class BrandController extends Controller
{
    public function index()
    {
        if (!Auth::user()->can('view_brand')) {
            return back();
        }
        return view('ecommerce.brand.index');
    }

    // dataTable
    public function dataTable()
    {
        $brand = Brand::all();
        return DataTables::of($brand)
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

    public function store(createBrandRequest $request)
    {
        if (!Auth::user()->can('create_brand')) {
            return back();
        }
        $data = $this->formData($request);
        Brand::create($data);
        return back()->with(['success' => 'Brand successfully created']);
    }

    public function edit(string $id)
    {
        if (!Auth::user()->can('edit_brand')) {
            return back();
        }
        $brand = Brand::findOrFail($id);
        return $brand;
    }

    public function updateBrand(updateBrandRequest $request)
    {
        if (!Auth::user()->can('edit_brand')) {
            return back();
        }
        $data = $this->formData($request);
        $brand = Brand::findOrFail($request->id);
        // create
        $brand->update($data);
        return back()->with(['success' => 'Brand successfully updated']);
    }

    public function destroy(string $id)
    {
        if (!Auth::user()->can('delete_brand')) {
            return back();
        }
        Brand::where('id', $id)->delete();
        return 'success';
    }

    public function deleteSelectedBrand(Request $request)
    {
        if (!Auth::user()->can('delete_brand')) {
            return back();
        }
        Brand::whereIn('id', $request->ids)->delete();
        return 'success';
    }

    // form data
    public function formData($request)
    {
        return [
            'name_mm' => $request->name_mm,
            'name_en' => $request->name_en,
        ];
    }
}
