<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Income;
use App\Models\Outcome;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class IncomeOutcomeController extends Controller
{

    // income page
    public function income()
    {
        if (!Auth::user()->can('view_income')) {
            return back();
        }
        return view('ecommerce.income.index');
    }

    // income dataTable
    public function dataTableIncome()
    {
        $income = Income::all();
        return DataTables::of($income)
            ->editColumn('created_at', function ($each) {
                return $each->created_at->format('j/F/Y');
            })
            ->addColumn('delete', function ($each) {
                return '<input class="form-check-input checkbox_ids" name="ids" type="checkbox" value="' . $each->id . '" id="flexCheckDefault">';
            })
            ->rawColumns(['delete'])
            ->make(true);
    }

    // income selected delete
    public function deleteSelectedIncome(Request $request)
    {
        Income::whereIn('id', $request->ids)->delete();
        return 'success';
    }

    // outcome
    public function outcome()
    {
        return view('ecommerce.outcome.index');
    }

    // outcome dataTable
    public function dataTableOutcome()
    {
        $outcome = Outcome::all();
        return DataTables::of($outcome)
            ->editColumn('created_at', function ($each) {
                return $each->created_at->format('j/F/Y');
            })
            ->addColumn('delete', function ($each) {
                return '<input class="form-check-input checkbox_ids" name="ids" type="checkbox" value="' . $each->id . '" id="flexCheckDefault">';
            })
            ->rawColumns(['delete'])
            ->make(true);
    }

    // income selected delete
    public function deleteSelectedOutcome(Request $request)
    {
        Outcome::whereIn('id', $request->ids)->delete();
        return 'success';
    }
}
