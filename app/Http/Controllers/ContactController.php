<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class ContactController extends Controller
{
    public function index()
    {
        if (!Auth::user()->can('view_contact')) {
            return back();
        }
        return view('ecommerce.contact.index');
    }

    // dataTable
    public function dataTable(Request $request)
    {
        $contact = ContactUs::query();

        return DataTables::of($contact)

            ->addColumn('check', function ($each) {
                return '<input class="form-check-input checkbox_ids" name="ids" type="checkbox" value="' . $each->id . '" id="flexCheckDefault">';
            })

            ->rawColumns(['check'])
            ->make(true);
    }

    public function destroy(string $id)
    {
        ContactUs::where('id', $id)->delete();
        return 'success';
    }

    // delete all selected
    public function deleteSelectedContact(Request $request)
    {
        ContactUs::whereIn('id', $request->ids)->delete();
        return 'success';
    }
}
