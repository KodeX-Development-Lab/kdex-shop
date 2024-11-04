<?php

namespace App\Http\Controllers;

use App\Http\Requests\createSalary;
use App\Http\Requests\updateSalary;
use App\Models\Salary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class SalaryController extends Controller
{
    public function index()
    {
        if (!Auth::user()->can('view_salary')) {
            return back();
        }
        $year = [date('Y')];
        for ($i = 1; $i <= 5; $i++) {
            $year[] = date('Y', strtotime("-$i year"));
        }
        return view('employeeManagement.salary.index', compact('year'));
    }

    public function create()
    {
        if (!Auth::user()->can('create_salary')) {
            return back();
        }
        $user = User::all();
        return view('employeeManagement.salary.createSalary', compact('user'))->render();
    }

    // dataTable
    public function dataTable(Request $request)
    {
        $salary = Salary::with('user');
        if ($request->month) {
            $salary = $salary->where('month', $request->month);
        }
        if ($request->year) {
            $salary = $salary->where('year', $request->year);
        }

        return DataTables::of($salary)
            ->addColumn('employee', function ($each) {
                return $each->user ? $each->user->name : '-';
            })
            ->filterColumn('employee', function ($query, $keyword) {
                $query->whereHas('user', function ($q1) use ($keyword) {
                    $q1->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->addColumn('check', function ($each) {
                return '<input class="form-check-input checkbox_ids" name="ids" type="checkbox" value="' . $each->id . '" id="flexCheckDefault">';
            })
            ->addColumn('action', function ($each) {
                return '<a href="" data-id="' . $each->id . '" class="editBtn btn btn-sm btn-info"  data-toggle="modal" data-target=".editModel"><i class=" fas fa-edit"></i></a>
            <a href="" data-id="' . $each->id . '" class="deleteBtn btn btn-sm btn-danger"><i class=" fas fa-trash-alt"></i></a>';
            })
            ->rawColumns(['action', 'check'])
            ->make(true);
    }

    public function store(createSalary $request)
    {
        if (!Auth::user()->can('create_salary')) {
            return back();
        }
        Salary::create($request->only('user_id', 'month', 'year', 'amount'));
        return back()->with(['success' => 'Salary successfully created']);
    }

    public function edit(string $id)
    {
        if (!Auth::user()->can('edit_salary')) {
            return back();
        }
        $user = User::all();
        $salary = Salary::where('id', $id)->with('user')->first();
        return view('employeeManagement.salary.updateSalary', compact('salary', 'user'))->render();
    }

    public function updateSalary(updateSalary $request)
    {
        if (!Auth::user()->can('edit_salary')) {
            return back();
        }
        $salary = Salary::findOrFail($request->id);
        // create
        $salary->update($request->only('user_id', 'month', 'year', 'amount'));
        return back()->with(['success' => 'Salary successfully updated']);
    }

    public function destroy(string $id)
    {
        if (!Auth::user()->can('delete_salary')) {
            return back();
        }
        Salary::where('id', $id)->delete();
        return 'success';
    }

    // delete all selected
    public function deleteSelectedSalary(Request $request)
    {
        if (!Auth::user()->can('delete_salary')) {
            return back();
        }
        Salary::whereIn('id', $request->ids)->delete();
        return 'success';
    }
}
