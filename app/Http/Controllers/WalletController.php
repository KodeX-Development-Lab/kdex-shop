<?php

namespace App\Http\Controllers;

use App\Helpers\CodeGenerate;
use App\Http\Controllers\Controller;
use App\Http\Requests\SentMoneyRequest;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Notifications\GeneralNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Yajra\DataTables\Facades\DataTables;

class WalletController extends Controller
{
    public function index()
    {
        if (!Auth::user()->can('view_wallet')) {
            return back();
        }
        $user = User::all();
        return view('employeeManagement.wallet.index', compact('user'));
    }

    // dataTable
    public function dataTable()
    {
        $wallet = Wallet::with('user');
        return DataTables::of($wallet)
            ->addColumn('employee', function ($each) {
                return $each->user ? $each->user->name : '-';
            })
            ->filterColumn('employee', function ($query, $keyword) {
                $query->whereHas('user', function ($q1) use ($keyword) {
                    $q1->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->editColumn('created_at', function ($each) {
                return Carbon::parse($each->created_at)->format('j-F-y');
            })
            ->editColumn('updated_at', function ($each) {
                return Carbon::parse($each->updated_at)->format('j-F-y');
            })
            ->addColumn('action', function ($each) {
                return '<a href="" data-id="' . $each->id . '" class="editBtn btn btn-sm btn-info"  data-toggle="modal" data-target=".editModel"><i class=" fas fa-edit"></i></a>
            <a href="" data-id="' . $each->id . '" class="deleteBtn btn btn-sm btn-danger"><i class=" fas fa-trash-alt"></i></a>';
            })
            ->addColumn('phone', function ($each) {
                return $each->user ? $each->user->phone : '-';
            })
            ->make(true);
    }

    // check phone
    public function phoneCheck($phone)
    {
        $user = User::where('phone', $phone)->with('wallet')->first();
        if (!$user) {
            return ['status' => 500, 'msg' => 'Invalid data'];
        }
        if ($user->phone == Auth::user()->phone) {
            return ['status' => 500, 'msg' => 'Your cant sent yourself back'];
        }
        return $user->name;
    }

    // password check
    public function passwordCheck($password)
    {
        if (Hash::check($password, Auth::user()->password)) {
            return ['status' => 200];
        }
        return [
            'status' => 500,
            'msg' => 'Incorrect Password',
        ];
    }

    // sent money
    public function sentMoney(SentMoneyRequest $request)
    {
        if ($request->to_phone == Auth::user()->phone) {
            return back()->with(['error' => 'Your cant sent yourself back']);
        }
        $wallet = Wallet::where('user_id', Auth::user()->id)->first();
        if ($request->amount > $wallet->amount) {
            return back()->with(['error' => 'Insufficient Balance']);
        }
        DB::beginTransaction();

        try {
            // add amount to phone
            $user = User::where('phone', $request->to_phone)->first();
            $wallet = Wallet::where('user_id', $user->id)->first();
            $wallet->update([
                'amount' => $wallet->amount + $request->amount,
            ]);
            // reduce amount auth user
            $authWallet = Wallet::where('user_id', Auth::user()->id)->first();
            $authWallet->update([
                'amount' => $authWallet->amount - $request->amount,
            ]);
            // transaction
            $refNo = CodeGenerate::refNumber();
            // sent money account transaction
            $sentTransaction = Transaction::create([
                'ref_no' => $refNo,
                'trx_no' => CodeGenerate::trxNumber(),
                'user_id' => Auth::user()->id,
                'source_id' => $user->id,
                'type' => 2,
                'amount' => $request->amount,
                'description' => $request->description,
            ]);
            // receive money account transaction
            $receiveTransaction = Transaction::create([
                'ref_no' => $refNo,
                'trx_no' => CodeGenerate::trxNumber(),
                'user_id' => $user->id,
                'source_id' => Auth::user()->id,
                'type' => 1,
                'amount' => $request->amount,
                'description' => $request->description,
            ]);
            // notification for auth
            $title = 'Money transfer';
            $message = 'Money Transfer ' . $request->amount . ' mmk to ' . $user->name . '-' . $user->phone;
            $source_id = Auth::user()->id;
            $source_type = Transaction::class;
            $web_link = url('walletTransaction', $sentTransaction->trx_no);
            Notification::send(Auth::user(), new GeneralNotification($title, $message, $source_id, $source_type, $web_link));
            // notification for receive
            $title = 'Money Received';
            $message = 'Money received ' . $request->amount . ' mmk from ' . Auth::user()->name . '-' . Auth::user()->phone;
            $source_id = $user->id;
            $source_type = Transaction::class;
            $web_link = url('walletTransaction', $receiveTransaction->trx_no);
            Notification::send($user, new GeneralNotification($title, $message, $source_id, $source_type, $web_link));
            DB::commit();
            return redirect()->route('walletTransactionDetail', $sentTransaction->trx_no)->with(['success' => 'You Sent ' . $request->amount . 'mmk to ' . $user->name]);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with(['error' => $e]);
        }
    }

    public function sentMoneyScan(SentMoneyRequest $request)
    {
        if (!Hash::check($request->password, Auth::user()->password)) {
            return [
                'status' => 500,
                'msg' => 'Incorrect Password',
            ];
        }

        if ($request->to_phone == Auth::user()->phone) {
            return [
                'status' => 500,
                'msg' => 'Your cant sent yourself back',
            ];
        }
        $wallet = Wallet::where('user_id', Auth::user()->id)->first();
        if ($request->amount > $wallet->amount) {
            return [
                'status' => 500,
                'msg' => 'Insufficient Balance',
            ];
        }
        DB::beginTransaction();

        try {
            // add amount to phone
            $user = User::where('phone', $request->to_phone)->first();
            $wallet = Wallet::where('user_id', $user->id)->first();
            $wallet->update([
                'amount' => $wallet->amount + $request->amount,
            ]);
            // reduce amount auth user
            $authWallet = Wallet::where('user_id', Auth::user()->id)->first();
            $authWallet->update([
                'amount' => $authWallet->amount - $request->amount,
            ]);
            // transaction
            $refNo = CodeGenerate::refNumber();
            // sent money account transaction
            $sentTransaction = Transaction::create([
                'ref_no' => $refNo,
                'trx_no' => CodeGenerate::trxNumber(),
                'user_id' => Auth::user()->id,
                'source_id' => $user->id,
                'type' => 2,
                'amount' => $request->amount,
                'description' => $request->description,
            ]);
            // sent money account transaction
            $receiveTransaction = Transaction::create([
                'ref_no' => $refNo,
                'trx_no' => CodeGenerate::trxNumber(),
                'user_id' => $user->id,
                'source_id' => Auth::user()->id,
                'type' => 1,
                'amount' => $request->amount,
                'description' => $request->description,
            ]);
            // notification for auth
            $title = 'Money transfer';
            $message = 'Money Transfer ' . $request->amount . ' mmk to ' . $user->name . '-' . $user->phone;
            $source_id = Auth::user()->id;
            $source_type = Transaction::class;
            $web_link = url('walletTransaction', $sentTransaction->trx_no);
            Notification::send(Auth::user(), new GeneralNotification($title, $message, $source_id, $source_type, $web_link));
            // notification for receive
            $title = 'Money Received';
            $message = 'Money received ' . $request->amount . ' mmk from ' . Auth::user()->name . '-' . Auth::user()->phone;
            $source_id = $user->id;
            $source_type = Transaction::class;
            $web_link = url('walletTransaction', $receiveTransaction->trx_no);
            Notification::send($user, new GeneralNotification($title, $message, $source_id, $source_type, $web_link));
            DB::commit();
            return [
                'status' => 200,
                'msg' => 'You Sent ' . $request->amount . 'mmk to ' . $user->name,
                'trx_no' => $sentTransaction->trx_no,
            ];
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with(['error' => $e]);
        }
    }

    // add wallet amount
    public function addAmount(Request $request)
    {
        $wallet = Wallet::where('user_id', $request->user_id)->first();
        $wallet->update([
            'amount' => $wallet->amount + $request->amount,
        ]);
        return back()->with(['success' => 'Add Amount successfully']);
    }

    // add wallet amount
    public function reduceAmount(Request $request)
    {
        $wallet = Wallet::where('user_id', $request->user_id)->first();
        if ($wallet->amount < $request->amount) {
            return back()->with(['error' => 'Cannot reduce Balance Insufficient']);
        }
        $wallet->update([
            'amount' => $wallet->amount - $request->amount,
        ]);
        return back()->with(['success' => 'Reduce Amount successfully']);
    }

}
