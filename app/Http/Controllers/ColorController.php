<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\createColorRequest;
use App\Http\Requests\updateColorRequest;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ColorController extends Controller
{
    public function index()
    {
        if (!Auth::user()->can('view_color')) {
            return back();
        }
        return view('ecommerce.color.index');
    }

    // dataTable
    public function dataTable()
    {
        $color = Color::all();
        return DataTables::of($color)
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

    public function store(createColorRequest $request)
    {
        if (!Auth::user()->can('create_color')) {
            return back();
        }
        $data = $this->formData($request);
        Color::create($data);
        return back()->with(['success' => 'Color successfully created']);
    }

    public function edit(string $id)
    {
        if (!Auth::user()->can('edit_color')) {
            return back();
        }
        $color = Color::findOrFail($id);
        return $color;
    }

    public function updateColor(updateColorRequest $request)
    {
        if (!Auth::user()->can('edit_color')) {
            return back();
        }
        $data = $this->formData($request);
        $color = Color::findOrFail($request->id);
        // create
        $color->update($data);
        return back()->with(['success' => 'Color successfully updated']);
    }

    public function destroy(string $id)
    {
        if (!Auth::user()->can('delete_color')) {
            return back();
        }
        Color::where('id', $id)->delete();
        return 'success';
    }

    // delete select data
    public function deleteSelectedColor(Request $request)
    {
        if (!Auth::user()->can('delete_color')) {
            return back();
        }
        Color::whereIn('id', $request->ids)->delete();
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
