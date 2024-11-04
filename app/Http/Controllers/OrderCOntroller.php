<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DeliveryTask;
use App\Models\Income;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Wallet;
use App\Notifications\GeneralNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Yajra\DataTables\Facades\DataTables;

class OrderCOntroller extends Controller
{
    public function index()
    {
        if (!Auth::user()->can('view_order')) {
            return back();
        }
        return view('ecommerce.order.index');
    }

    // dataTable
    public function dataTable(Request $request)
    {
        if ($request->status) {
            $order = Order::where('status', $request->status)->with('product', 'user');
        } else {
            $order = Order::with('product', 'user');
        };
        return DataTables::of($order)
            ->editColumn('created_at', function ($each) {
                return $each->created_at->format('j/F/Y');
            })
            ->addColumn('image', function ($each) {
                return '<img  src="' . asset('storage/' . $each->product->image) . '" class=" img-thumbnail"">';
            })
            ->addColumn('productName', function ($each) {
                return $each->product->name_en;
            })
            ->filterColumn('productName', function ($query, $keyword) {
                $query->whereHas('product', function ($q1) use ($keyword) {
                    $q1->where('name_en', 'like', '%' . $keyword . '%');
                });
            })
            ->addColumn('customer_name', function ($each) {
                return $each->user->name;
            })
            ->filterColumn('customer_name', function ($query, $keyword) {
                $query->whereHas('user', function ($q1) use ($keyword) {
                    $q1->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->editColumn('status', function ($each) {
                if ($each->status == 'pending') {
                    return ' <button type="button" data-id="' . $each->id . '" class="btn btn-warning changeStatus text-white" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">' . $each->status . '</button>';
                }
                if ($each->status == 'accept') {
                    return ' <button type="button" class="btn btn-success text-white" disabled data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">' . $each->status . '</button>';
                }
                if ($each->status == 'reject') {
                    return ' <button type="button" class="btn btn-danger text-white" disabled data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">' . $each->status . '</button>';
                }
            })
            ->addColumn('checkBox', function ($each) {
                return '<input class="form-check-input checkbox_ids" name="ids" type="checkbox" value="' . $each->id . '" id="flexCheckDefault">';
            })
            ->rawColumns(['image', 'status', 'checkBox'])
            ->make(true);
    }

    // order form
    public function orderForm($id)
    {
        $order = Order::where('id', $id)->first();
        $user = User::where('group', 'employee')->get();
        return view('components.orderForm', compact('order', 'user'))->render();
    }

    // order status change
    public function orderChangeStatus(Request $request)
    {
        $order = Order::where('id', $request->order_id)->first();
        $user = User::where('id', $order->user_id)->first();
        if ($order->total > $user->wallet->amount) {
            // notification for reject to customer
            $title = 'Reject Order';
            $message = 'Your Wallet balance insufficient';
            $source_id = $user->id;
            $source_type = User::class;
            $web_link = url('something', );
            Notification::send($user, new GeneralNotification($title, $message, $source_id, $source_type, $web_link));
            $order->update([
                'status' => 'reject',
            ]);
            return back()->with(['error' => 'Order Customer Wallet balance insufficient']);
        }
        if ($request->status == 'reject') {
            // notification for reject to customer
            $title = 'Reject Order';
            $message = $request->message;
            $source_id = $user->id;
            $source_type = User::class;
            $web_link = url('something', );
            Notification::send($user, new GeneralNotification($title, $message, $source_id, $source_type, $web_link));
            $order->update([
                'status' => 'reject',
            ]);
            return back()->with(['success' => 'Order Status Change success']);
        }
        DB::beginTransaction();

        try {
            // notification for success to customer
            $title = 'Success Order';
            $message = 'Order Success !Thanks for your encouragement';
            $source_id = $user->id;
            $source_type = User::class;
            $web_link = url('something', );
            Notification::send($user, new GeneralNotification($title, $message, $source_id, $source_type, $web_link));
            $order->update([
                'status' => 'accept',
            ]);
            Wallet::where('user_id', $user->id)->update([
                'amount' => $user->wallet->amount - $order->total,
            ]);
            $admin = User::where('id', 1)->first();
            Wallet::where('user_id', $admin->id)->update([
                'amount' => $admin->wallet->amount + $order->total,
            ]);
            $product = Product::where('id', $order->product_id)->first();
            $product->update([
                'total_qty' => $product->total_qty - $order->qty,
            ]);
            $delivery = User::where('id', $request->delivery_id)->first();
            DeliveryTask::create([
                'user_id' => $delivery->id,
                'product_id' => $order->product_id,
                'title' => 'Delivery to ' . $order->address,
                'description' => 'delivery',
                'start_date' => Carbon::now(),
                'deadline' => Carbon::now()->addDays(3),
                'priority' => 'middle',
                'phone' => $order->phone,
                'customer_address' => $order->address,
            ]);
            // add to income
            Income::create([
                'title' => 'Sale Product',
                'message' => $order->product->name_en . ' was bought by ' . $order->user->name,
                'amount' => $order->total,
            ]);
            // notification for delivery
            $title = 'Delivery';
            $message = 'Delivery to ' . $order->address;
            $source_id = $delivery->id;
            $source_type = User::class;
            $web_link = url('dashboard', );
            Notification::send($delivery, new GeneralNotification($title, $message, $source_id, $source_type, $web_link));
            DB::commit();
            return back()->with(['success' => 'Order Status Change success']);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with(['error' => $e->getMessage()]);
        }

    }

    // delete selected
    public function deleteSelected(Request $request)
    {
        Order::whereIn('id', $request->ids)->delete();
        return 'success';
    }
}
