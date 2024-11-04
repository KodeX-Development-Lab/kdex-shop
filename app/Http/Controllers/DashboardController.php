<?php

namespace App\Http\Controllers;

use App\Models\DeliveryTask;
use App\Models\Income;
use App\Models\Order;
use App\Models\Outcome;
use App\Models\Product;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        if (Auth::user()->group == 'employee') {
            $tasks = DeliveryTask::where('user_id', Auth::user()->id)->get();
            return view('dashboard', compact('tasks'));
        }
        if (Auth::user()->group == 'customer') {
            return back();
        }
    }

    // DataDashboard
    public function DataDashboard()
    {
        $product = Product::count();
        $customer = User::where('group', 'customer')->count();
        $income = Income::whereDay('created_at', date('d'))->sum('amount');
        $outcome = Outcome::whereDay('created_at', date('d'))->sum('amount');
        $month = [date('F')];
        $monthDay = [date('F d')];
        $yearMonth = [
            ['year' => date('Y'), 'month' => date('m')],
        ];
        $yearMonthDay = [
            ['year' => date('Y'), 'month' => date('m'), 'day' => date('d')],
        ];
        for ($i = 1; $i <= 5; $i++) {
            $month[] = date('F', strtotime("-$i month"));
            $yearMonth[] = ['year' => date('Y', strtotime("-$i month")), 'month' => date('m', strtotime("-$i month"))];
            $monthDay[] = date('F d', strtotime("-$i day"));
            $yearMonthDay[] = ['year' => date('Y', strtotime("-$i year")), 'month' => date('m', strtotime("-$i month")), 'day' => date('d', strtotime("-$i day"))];
        }
        $order = [];
        foreach ($yearMonth as $ym) {
            $order[] = Order::whereYear('created_at', $ym['year'])->whereMonth('created_at', $ym['month'])->count();
        }
        $incomeCount = [];
        $outcomeCount = [];
        foreach ($yearMonthDay as $d) {
            $incomeCount[] = Income::whereYear('created_at', $d['year'])->whereMonth('created_at', $d['month'])->whereDay('created_at', $d['day'])->sum('amount');
            $outcomeCount[] = Outcome::whereYear('created_at', $d['year'])->whereMonth('created_at', $d['month'])->whereDay('created_at', $d['day'])->sum('amount');
        }

        $products = Product::where('total_qty', '<', 4)->paginate(4);
        $companyWallet = Wallet::where('user_id', 1)->first();
        return view('ecommerce.dashboard.index', compact('product', 'companyWallet', 'customer', 'income', 'outcome', 'month', 'order', 'monthDay', 'outcomeCount', 'incomeCount', 'products'));
    }
}
