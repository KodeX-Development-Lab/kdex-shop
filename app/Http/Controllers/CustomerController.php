<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{
    public function index()
    {
        if (!Auth::user()->can('view_customer')) {
            return back();
        }

        return view('employeeManagement.customer.index');
    }

    // dataTable
    public function dataTable()
    {
        $customer = User::where('group', 'customer')->get();
        return DataTables::of($customer)
            ->editColumn('image', function ($each) {
                return ' <img class=" img-thumbnail pp" src="' . asset('storage/' . $each->image) . '"/>';
            })
            ->rawColumns(['image'])
            ->make(true);
    }

}
