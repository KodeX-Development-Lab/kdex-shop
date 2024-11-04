<?php

namespace App\Http\Controllers;

use App\Helpers\CodeGenerate;
use App\Http\Requests\createEmployee;
use App\Http\Requests\PasswordChangeRequest;
use App\Http\Requests\updateEmployee;
use App\Models\Department;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    public function index()
    {
        if (!Auth::user()->can('view_employee')) {
            return back();
        }
        return view('employeeManagement.employee.index');
    }

    // dataTable
    public function dataTable()
    {
        $employee = User::where('group', 'employee')->with('department');
        return DataTables::of($employee)
            ->editColumn('image', function ($each) {
                return '<img class=" img-thumbnail pp" src="' . asset('storage/' . $each->image) . '"/>';
            })
            ->addColumn('department', function ($each) {
                return $each->department ? $each->department->name : '-';
            })
            ->editColumn('is_present', function ($each) {
                $output = '';
                if ($each->is_present == 1) {
                    $output .= '<span class=" btn btn-success btn-sm">Present</span>';
                }
                if ($each->is_present == 0) {
                    $output .= '<span class=" btn btn-danger btn-sm">leave</span>';
                }
                return $output;
            })
            ->addColumn('checkBox', function ($each) {
                return '<input class="form-check-input checkbox_ids" name="ids" type="checkbox" value="' . $each->id . '" id="flexCheckDefault">';
            })
            ->addColumn('action', function ($each) {
                return '<a class=" btn btn-sm btn-info mx-1" href="' . route('employee.edit', $each->id) . '"><i class="fas fa-edit"></i></a>
                <a class=" btn btn-sm btn-secondary mx-1 text-white" href="' . route('employee.show', $each->id) . '"><i class="fas fa-eye"></i></a>
                   <a class=" btn btn-sm btn-danger deleteBtn" data-id="' . $each->id . '"><i class=" fas fa-trash-alt text-white"></i></a>';
            })
            ->rawColumns(['action', 'image', 'is_present', 'checkBox'])
            ->make(true);
    }

    public function create()
    {
        if (!Auth::user()->can('create_employee')) {
            return back();
        }
        $department = Department::all();
        $role = Role::all();
        return view('employeeManagement.employee.create', compact('department', 'role'));
    }

    public function store(createEmployee $request)
    {
        if (!Auth::user()->can('create_employee')) {
            return back();
        }
        DB::beginTransaction();
        try {
            $data = $this->formData($request);
            // image
            $image = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/', $image);
            $data['image'] = $image;
            $user = User::create($data);
            $user->syncRoles([$request->role]);
            Wallet::firstOrCreate([
                'user_id' => $user->id,
            ], [
                'account_number' => CodeGenerate::accountNumber(),
            ]);
            DB::commit();
            return redirect()->route('employee.index')->with(['success' => 'Employee successfully created']);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('employee.index')->with(['error' => $e]);
        }
    }

    public function show(string $id)
    {
        if (!Auth::user()->can('view_employee')) {
            return back();
        }
        $employee = User::findOrFail($id);
        return view('employeeManagement.employee.show', compact('employee'));
    }

    public function edit(string $id)
    {
        if (!Auth::user()->can('edit_employee')) {
            return back();
        }
        $role = Role::all();
        $department = Department::all();
        $employee = User::where('id', $id)->first();
        $oldRole = $employee->roles->pluck('name')->toArray();
        return view('employeeManagement.employee.edit', compact('employee', 'oldRole', 'role', 'department'));
    }

    public function update(updateEmployee $request, string $id)
    {
        if (!Auth::user()->can('edit_employee')) {
            return back();
        }
        $employee = User::where('id', $id)->first();
        $data = $this->formData($request);
        // image
        if ($request->hasFile('image')) {
            $image = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/', $image);
            $data['image'] = $image;
        } else {
            $data['image'] = $employee->image;
        }
        $request->password ? $data['password'] = Hash::make($request->password) : $data['password'] = $employee->password;
        $request->pin_code ? $data['pin_code'] = $request->pin_code : $data['pin_code'] = $employee->pin_code;

        $employee->syncRoles([$request->role]);
        $employee->update($data);
        return redirect()->route('employee.index')->with(['success' => 'Employee successfully updated']);
    }

    public function destroy(string $id)
    {
        if (!Auth::user()->can('delete_employee')) {
            return back();
        }
        User::where('id', $id)->delete();
        Wallet::where('user_id', $id)->delete();
        return 'success';
    }

    // delete check data
    public function deleteSelectedEmployee(Request $request)
    {
        if (!Auth::user()->can('delete_employee')) {
            return back();
        }
        User::whereIn('id', $request->ids)->delete();
        return 'success';
    }

    // change Password
    public function changePassword(PasswordChangeRequest $request)
    {
        if (Hash::check($request->currentPassword, Auth::user()->password)) {
            User::where('id', Auth::user()->id)->update([
                'password' => Hash::make($request->newPassword),
            ]);
            return back()->with(['success' => 'Your password successfully changed!']);
        }
        return back()->with(['error' => 'Your current password incorrect!']);
    }

    // form data
    public function formData($request)
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'pin_code' => $request->pin_code,
            'phone' => $request->phone,
            'nrc_number' => $request->nrc_number,
            'birthday' => $request->birthday,
            'gender' => $request->gender,
            'address' => $request->address,
            'employee_id' => $request->employee_id,
            'department_id' => $request->department_id,
            'join_date' => $request->join_date,
            'is_present' => $request->is_present,
            'group' => 'employee',
        ];
    }
}
