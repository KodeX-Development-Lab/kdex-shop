<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AddWalletAmount;
use App\Models\User;
use App\Models\Wallet;
use App\Notifications\GeneralNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Yajra\DataTables\Facades\DataTables;

class AddWalletMoneyController extends Controller
{
    //add money list page
    public function index()
    {
        // permission
        if (!Auth::user()->can('view_add_wallet')) {
            return back();
        }
        return view('employeeManagement.addMoney.index');
    }

    public function dataTable()
    {
        $addMoney = AddWalletAmount::with('user');
        return DataTables::of($addMoney)
            ->editColumn('created_at', function ($each) {
                return $each->created_at->format('j/F/Y');
            })
            ->addColumn('image', function ($each) {
                return '<img  src="' . asset('storage/' . $each->image) . '" class=" img-thumbnail"">';
            })
            ->addColumn('name', function ($each) {
                return $each->user->name;
            })
            ->addColumn('phone', function ($each) {
                return $each->user->phone;
            })
            ->editColumn('status', function ($each) {
                return '<select class="form-control statusChange w-50" data-id="' . $each->id . '">
                <option value="pending" ' . ($each->status == 'pending' ? 'selected' : '') . '>Pending</option>
                <option value="success" ' . ($each->status == 'success' ? 'selected' : '') . ' >Success</option>
                <option value="cancel" ' . ($each->status == 'cancel' ? 'selected' : '') . ' >Cancel</option>
            </select>';
            })
            ->addColumn('checkBox', function ($each) {
                return '<input class="form-check-input checkbox_ids" name="ids" type="checkbox" value="' . $each->id . '" id="flexCheckDefault">';
            })
            ->rawColumns(['image', 'status', 'checkBox'])
            ->make(true);
    }

    // add money process
    public function addWalletMoney(Request $request)
    {
        // permission
        if (!Auth::user()->can('create_add_wallet')) {
            return back();
        }
        $addMoney = AddWalletAmount::where('id', $request->id)->with('user')->first();
        $user = User::where('id', $addMoney->user_id)->first();
        $wallet = Wallet::findOrFail($user->id);
        if ($request->status == 'success') {
            $wallet->update([
                'amount' => $wallet->amount + $addMoney->amount,
            ]);
            $addMoney->update([
                'status' => 'success',
            ]);
            // notification for success
            $title = 'Success Add Money';
            $message = 'Add ' . $addMoney->amount . ' money to your wallet';
            $source_id = $addMoney->user->id;
            $source_type = User::class;
            $web_link = url('/');
            Notification::send($user, new GeneralNotification($title, $message, $source_id, $source_type, $web_link));
            return response()->json(['success' => 'Successfully Success Changed']);
        }
        if ($request->status == 'cancel') {
            $addMoney->update([
                'status' => 'cancel',
            ]);
            // notification for reject
            $title = 'Cancel Add Money';
            $message = 'Invalid Image,We have not received the money';
            $source_id = $addMoney->user_id;
            $source_type = User::class;
            $web_link = url('/');
            Notification::send(Auth::user(), new GeneralNotification($title, $message, $source_id, $source_type, $web_link));
            return response()->json(['success' => 'Successfully Cancel Changed']);
        }
    }

    // delete all selected data
    public function deleteSelectedAddMoney(Request $request)
    {
        // permission
        if (!Auth::user()->can('delete_add_wallet')) {
            return back();
        }
        AddWalletAmount::whereIn('id', $request->ids)->delete();
        return 'success';
    }
}
