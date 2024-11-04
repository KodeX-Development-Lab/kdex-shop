<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletTransactionController extends Controller
{
    //wallet transaction page
    public function walletTransaction()
    {
        if (!Auth::user()->can('view_wallet_transaction')) {
            return back();
        }
        return view('employeeManagement.wallet.transaction');
    }

    public function walletTransactionData(Request $request)
    {
        if ($request->date) {
            $transaction = Transaction::where('user_id', Auth::user()->id)->whereDate('created_at', $request->date)->with('user', 'source')->paginate(4);
        } elseif ($request->type) {
            $transaction = Transaction::where('user_id', Auth::user()->id)->where('type', $request->type)->with('user', 'source')->paginate(4);
        } else {
            $transaction = Transaction::where('user_id', Auth::user()->id)->with('user', 'source')->paginate(4);
        }

        // return $transaction;
        return view('components.walletTransactionData', compact('transaction'));
    }

    // wallet transaction detail
    public function walletTransactionDetail($id)
    {
        $transaction = Transaction::where('trx_no', $id)->with('user', 'source')->first();
        return view('employeeManagement.wallet.transactionDetail', compact('transaction'));
    }
}
