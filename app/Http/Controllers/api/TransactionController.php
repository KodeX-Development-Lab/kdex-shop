<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    //transaction
    public function transaction(Request $request)
    {

        if ($request->type == 'undefined') {
            $transaction = Transaction::where('user_id', $request->user_id)->orderBy('created_at', 'desc')->with('source', 'user')->paginate(5);
        } elseif ($request->type == 'all') {
            $transaction = Transaction::where('user_id', $request->user_id)->orderBy('created_at', 'desc')->with('source', 'user')->paginate(5);
        } else {
            $transaction = Transaction::where('user_id', $request->user_id)->where('type', $request->type)->orderBy('created_at', 'desc')->with('source', 'user')->paginate(5);
        }
        return response()->json([
            'data' => $transaction,
        ]);
    }

    // transaction detail
    public function transactionDetail($id)
    {
        $transaction = Transaction::where('trx_no', $id)->with('source', 'user')->first();
        return response()->json($transaction, 200);
    }
}
