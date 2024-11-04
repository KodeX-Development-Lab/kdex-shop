<?php

namespace App\Http\Controllers\api;

use App\Helpers\CodeGenerate;
use App\Http\Controllers\Controller;
use App\Models\AddWalletAmount;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Notifications\GeneralNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

class WalletController extends Controller
{
    //check Phone
    public function checkPhone(Request $request)
    {
        $user = User::where('phone', $request->to_phone)->first();
        if (!$user) {
            return response()->json(['error' => 'Invalid Data!']);
        }
        if ($request->authUser) {
            if ($user->id == $request->authUser) {
                return response()->json(['error' => 'You cannot pay yourself back !']);
            }
        }
        return response()->json(['success' => $user]);
    }

    // transfer money with phone and scan
    public function transferWithPhone(Request $request)
    {
        $request->validate([
            'to_phone' => 'required',
            'amount' => 'required',
            'description' => 'required',
            'password' => 'required',
        ]);
        $authUser = User::where('id', $request->user_id)->first();
        if (!Hash::check($request->password, $authUser->password)) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Your password incorrect',
            ]);
        }
        if ($request->to_phone == $authUser->phone) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Your cant sent yourself back',
            ]);
        }
        $wallet = Wallet::where('user_id', $authUser->id)->first();
        if ($request->amount > $wallet->amount) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Insufficient Balance',
            ]);
        }
        DB::beginTransaction();

        try {
            // add amount to phone
            $toUser = User::where('phone', $request->to_phone)->first();
            $wallet = Wallet::where('user_id', $toUser->id)->first();
            $wallet->update([
                'amount' => $wallet->amount + $request->amount,
            ]);
            // reduce amount auth user
            $authWallet = Wallet::where('user_id', $authUser->id)->first();
            $authWallet->update([
                'amount' => $authWallet->amount - $request->amount,
            ]);
            // transaction
            $refNo = CodeGenerate::refNumber();
            // sent money account transaction
            $sentTransaction = Transaction::create([
                'ref_no' => $refNo,
                'trx_no' => CodeGenerate::trxNumber(),
                'user_id' => $authUser->id,
                'source_id' => $toUser->id,
                'type' => 2,
                'amount' => $request->amount,
                'description' => $request->description,
            ]);
            // receive money account transaction
            $receiveTransaction = Transaction::create([
                'ref_no' => $refNo,
                'trx_no' => CodeGenerate::trxNumber(),
                'user_id' => $toUser->id,
                'source_id' => $authUser->id,
                'type' => 1,
                'amount' => $request->amount,
                'description' => $request->description,
            ]);
            // notification for auth
            $title = 'Money transfer';
            $message = 'Money Transfer ' . $request->amount . ' mmk to ' . $authUser->name . '-' . $authUser->phone;
            $source_id = $authUser->id;
            $source_type = Transaction::class;
            $web_link = url('walletTransaction', $sentTransaction->trx_no);
            Notification::send($authUser, new GeneralNotification($title, $message, $source_id, $source_type, $web_link));
            // notification for receive
            $title = 'Money Received';
            $message = 'Money received ' . $request->amount . ' mmk from ' . $authUser->name . '-' . $authUser->phone;
            $source_id = $toUser->id;
            $source_type = Transaction::class;
            $web_link = url('walletTransaction', $receiveTransaction->trx_no);
            Notification::send($toUser, new GeneralNotification($title, $message, $source_id, $source_type, $web_link));
            DB::commit();
            return response()->json([
                'status' => 'success',
                'msg' => 'You Sent ' . $request->amount . 'mmk to ' . $toUser->name,
                'trx_no' => $sentTransaction->trx_no,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'msg' => $e->getMessage(),
            ]);
        }
    }

    // transferUser
    public function transferUser($phone)
    {
        $user = User::where('phone', $phone)->first();
        return response()->json($user);
    }

    // add money
    public function addMoney(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        $request->validate([
            'image' => 'required|mimes:png,jpg,jpeg,webp',
            'amount' => 'required|min:4',
        ]);
        $image = uniqid() . $request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('public/', $image);
        AddWalletAmount::create([
            'user_id' => $request->id,
            'amount' => $request->amount,
            'image' => $image,
        ]);
        // notification for receive
        $admin = User::find(1);
        $title = 'Add Wallet amount';
        $message = 'Add Wallet Amount to ' . $user->name;
        $source_id = 1;
        $source_type = Wallet::class;
        $web_link = url('addMoney');
        Notification::send($admin, new GeneralNotification($title, $message, $source_id, $source_type, $web_link));
        return response()->json([
            'status' => 'success',
            'msg' => 'Request Success ! Wait to accept',
        ]);
    }

}
