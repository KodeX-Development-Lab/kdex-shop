<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskDelivery;
use App\Http\Requests\updateTaskDelivery;
use App\Models\DeliveryTask;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryTaskController extends Controller
{
    public function index()
    {
        if (!Auth::user()->can('view_delivery_task')) {
            return back();
        }
        $product = Product::all();
        $users = User::with('roles')->get();
        $user = [];
        foreach ($users as $u) {
            foreach ($u->roles as $r) {
                if ($r->name == 'Delivery') {
                    $user[] = $u;
                }
            }
        }
        $tasks = DeliveryTask::with('user')->orderBy('serial_number', 'asc')->get();
        return view('employeeManagement.deliveryTask.index', compact('user', 'tasks', 'product'));
    }

    public function sortTask(Request $request)
    {

        if ($request->pending) {
            $pending = explode(',', $request->pending);
            foreach ($pending as $key => $p) {
                $task = DeliveryTask::where('id', $p)->first();
                if ($task) {
                    $task->serial_number = $key;
                    $task->status = 'pending';
                    $task->update();
                }
            }
        }

        if ($request->progress) {
            $progress = explode(',', $request->progress);
            foreach ($progress as $key => $p) {
                $task = DeliveryTask::where('id', $p)->first();
                if ($task) {
                    $task->serial_number = $key;
                    $task->status = 'in_progress';
                    $task->update();
                }
            }
        }

        if ($request->complete) {
            $complete = explode(',', $request->complete);
            foreach ($complete as $key => $p) {
                $task = DeliveryTask::where('id', $p)->first();
                if ($task) {
                    $task->serial_number = $key;
                    $task->status = 'complete';
                    $task->update();
                }
            }
        }
        return 'success';
    }

    public function store(CreateTaskDelivery $request)
    {
        if (!Auth::user()->can('create_delivery_task')) {
            return back();
        }
        DeliveryTask::create($request->only('title', 'user_id', 'product_id', 'description', 'start_date', 'deadline', 'priority', 'customer_address', 'phone', 'status'));
        return back()->with(['success' => 'Delivery Task successfully created']);
    }

    public function show(string $id)
    {
        $delivery = DeliveryTask::where('id', $id)->with('product', 'user')->first();
        return view('employeeManagement.deliveryTask.show', compact('delivery'));
    }

    public function edit(string $id)
    {
        if (!Auth::user()->can('edit_delivery_task')) {
            return back();
        }
        $product = Product::all();
        $user = User::with('roles')->get();
        $delivery = DeliveryTask::where('id', $id)->with('user', 'product')->first();
        return view('components.management.deliverTask.updateForm', compact('user', 'delivery', 'product'))->render();
    }

    public function deliveryTaskUpdate(updateTaskDelivery $request)
    {
        if (!Auth::user()->can('edit_delivery_task')) {
            return back();
        }
        DeliveryTask::where('id', $request->id)->update($request->only('title', 'user_id', 'product_id', 'description', 'start_date', 'deadline', 'priority', 'customer_address', 'phone', 'status'));
        return back()->with(['success' => 'Delivery Task successfully updated']);
    }

    public function destroy(string $id)
    {
        if (!Auth::user()->can('delete_delivery_task')) {
            return back();
        }
        DeliveryTask::where('id', $id)->delete();
        return back()->with(['success' => 'Task successfully deleted']);
    }
}
