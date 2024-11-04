<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Notifications\GeneralNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class OrderController extends Controller
{
    //addToCart
    public function addToCart(Request $request)
    {
        $product = Product::where('id', $request->product_id)->first();
        if ($product->total_qty < $request->qty) {
            return response()->json([
                'status' => 'fail',
                'msg' => 'this product is out of stock',
            ]);
        }
        $cart = Cart::where('product_id', $request->product_id)->where('user_id', $request->user_id)->first();
        if ($cart) {
            $cart->update([
                'qty' => $cart->qty + $request->qty,
            ]);
            return response()->json([
                'status' => 'success',
                'msg' => 'Add To Cart Successfully',
            ]);
        }

        Cart::create([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'qty' => $request->qty,
        ]);
        return response()->json([
            'status' => 'success',
            'msg' => 'Add To Cart Successfully',
        ]);
    }

    // cartCount
    public function cartCount($id)
    {
        $cart = Cart::where('user_id', $id)->with('product')->get();
        return response()->json([
            'cart' => $cart,
        ]);
    }

    // cart
    public function cart($id)
    {
        $cart = Cart::where('user_id', $id)->with('product')->get();
        return response()->json([
            'cart' => $cart,
        ]);
    }

    //add Qty
    public function addQty($id)
    {
        $addQtyCart = Cart::where('id', $id)->with('product')->first();
        $addQtyCart->update([
            'qty' => $addQtyCart->qty + 1,
        ]);
        return response()->json($addQtyCart->product->discount_price);
    }

    //remove Qty
    public function removeQty($id)
    {
        $removeQty = Cart::where('id', $id)->with('product')->first();
        $removeQty->update([
            'qty' => $removeQty->qty - 1,
        ]);
        return response()->json($removeQty->product->discount_price);
    }

    // delete cart
    public function deleteCart(Request $request)
    {
        Cart::where('id', $request->cart_id)->delete();
        return response()->json(['status' => 'success', 'msg' => 'Cart remove success!']);
    }

    // order
    public function order(Request $request)
    {
        $wallet = Wallet::where('user_id', $request->user_id)->first();
        if ($wallet->amount < $request->totalPrice) {
            return response()->json(['error' => 'Insufficient Balance']);
        }
        $cart = Cart::where('user_id', $request->user_id)->with('product')->get();
        foreach ($cart as $c) {
            if ($c->product->total_qty < $c->qty) {
                return response()->json(['error' => 'the product is out of stock']);
            }
            Order::create([
                'user_id' => $c->user_id,
                'product_id' => $c->product_id,
                'qty' => $c->qty,
                'total' => $c->qty * $c->product->discount_price,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);
            $c->delete();
            $user = User::where('id', 1)->first();
            // notification for sent
            $title = 'Order';
            $message = 'Get Order to customer ' . $wallet->user->name;
            $source_id = $user;
            $source_type = Transaction::class;
            $web_link = url('order');
            Notification::send($user, new GeneralNotification($title, $message, $source_id, $source_type, $web_link));
        }
        return response()->json(['status' => 'success', 'msg' => 'Order Success !']);

    }

    // get order data
    public function orderData(Request $request)
    {
        $order = Order::where('user_id', $request->id)->with('product')->paginate(3);
        return response()->json(['order' => $order]);
    }
}
