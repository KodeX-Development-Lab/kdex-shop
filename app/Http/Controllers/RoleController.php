<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\createRole;
use App\Http\Requests\updateRole;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission as ModelsPermission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    public function index()
    {
        if (!Auth::user()->can('view_role')) {
            return back();
        }
        $permission = ModelsPermission::all();
        return view('employeeManagement.role.index', compact('permission'));
    }

    // dataTable
    public function dataTable()
    {
        $role = Role::with('permissions');
        return DataTables::of($role)
            ->addColumn('permission', function ($each) {
                $output = '';
                foreach ($each->permissions->pluck('name') as $p) {
                    $output .= '<span class=" badge badge-sm badge-info badge-pill">' . $p . '</span>';
                }
                return $output;
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
            ->rawColumns(['action', 'permission'])
            ->make(true);
    }

    public function store(createRole $request)
    {
        if (!Auth::user()->can('create_role')) {
            return back();
        }
        $role = Role::create(['name' => $request->name]);
        $role->givePermissionTo($request->permissions);
        return back()->with(['success' => 'Role successfully created']);
    }

    public function edit(string $id)
    {
        if (!Auth::user()->can('edit_role')) {
            return back();
        }
        $role = Role::where('id', $id)->first();
        $oldPermission = $role->permissions->pluck('name')->toArray();
        $permission = ModelsPermission::all();
        return view('components.updateRoleForm', compact('permission', 'oldPermission', 'role'))->render();
    }

    public function updateRole(updateRole $request)
    {
        if (!Auth::user()->can('edit_role')) {
            return back();
        }
        $role = Role::findOrFail($request->id);
        $role->update(['name' => $request->name]);
        $role->revokePermissionTo($request->permissions);
        $role->syncPermissions($request->permissions);
        return back()->with(['success' => 'Role successfully updated']);
    }

    public function destroy(string $id)
    {
        if (!Auth::user()->can('delete_role')) {
            return back();
        }
        Role::where('id', $id)->delete();
        return 'success';
    }

}
