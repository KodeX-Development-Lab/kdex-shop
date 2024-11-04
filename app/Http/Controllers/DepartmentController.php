<?php

namespace App\Http\Controllers;

use App\Http\Requests\createDepartment;
use App\Http\Requests\updateDepartment;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class DepartmentController extends Controller
{
    public function index()
    {
        if (!Auth::user()->can('view_department')) {
            return back();
        }
        return view('employeeManagement.department.index');
    }

    // dataTable
    public function dataTable()
    {
        $department = Department::all();
        return DataTables::of($department)
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
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(createDepartment $request)
    {
        if (!Auth::user()->can('create_department')) {
            return back();
        }
        Department::create(['name' => $request->name]);
        return back()->with(['success' => 'Department successfully created']);
    }

    public function edit(string $id)
    {
        if (!Auth::user()->can('edit_department')) {
            return back();
        }
        $department = Department::findOrFail($id);
        return $department;
    }

    public function updateDepartment(updateDepartment $request)
    {
        if (!Auth::user()->can('edit_department')) {
            return back();
        }
        $department = Department::findOrFail($request->id);
        // create
        $department->update(['name' => $request->name]);
        return back()->with(['success' => 'Department successfully updated']);
    }

    public function destroy(string $id)
    {
        if (!Auth::user()->can('delete_department')) {
            return back();
        }
        Department::where('id', $id)->delete();
        return 'success';
    }

}
