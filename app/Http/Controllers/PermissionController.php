<?php

namespace App\Http\Controllers;

use App\Http\Requests\createPermission;
use App\Http\Requests\updatePermission;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    public function index()
    {
        if (!Auth::user()->can('view_permission')) {
            return back();
        }
        return view('employeeManagement.permission.index');
    }

    // dataTable
    public function dataTable()
    {
        $permission = Permission::all();
        return DataTables::of($permission)
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

    public function store(createPermission $request)
    {
        if (!Auth::user()->can('create_permission')) {
            return back();
        }
        Permission::create(['name' => $request->name]);
        return back()->with(['success' => 'Permission successfully created']);
    }

    public function edit(string $id)
    {
        if (!Auth::user()->can('edit_permission')) {
            return back();
        }
        $permission = Permission::findOrFail($id);
        return $permission;
    }

    public function updatePermission(updatePermission $request)
    {
        if (!Auth::user()->can('edit_permission')) {
            return back();
        }
        $permission = Permission::findOrFail($request->id);
        // create
        $permission->update(['name' => $request->name]);
        return back()->with(['success' => 'Permission successfully updated']);
    }

    public function destroy(string $id)
    {
        if (!Auth::user()->can('delete_permission')) {
            return back();
        }
        Permission::where('id', $id)->delete();
        return 'success';
    }

}
