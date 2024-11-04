<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanySettingRequest;
use App\Models\CompanySetting;
use Illuminate\Support\Facades\Auth;

class CompanySettingController extends Controller
{

    public function show(string $id)
    {
        if (!Auth::user()->can('view_company_setting')) {
            return back();
        }
        $company = CompanySetting::findOrFail($id);
        return view('companySetting', compact('company'));
    }

    public function update(CompanySettingRequest $request, string $id)
    {
        $company = CompanySetting::findOrFail($id);
        $company->update($request->only('name', 'email', 'address', 'phone', 'office_start_time', 'office_end_time', 'break_start_time', 'break_end_time'));
        return back()->with(['success' => 'Company Setting Successfully updated']);
    }

}
