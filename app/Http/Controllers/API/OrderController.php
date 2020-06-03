<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Order;
use App\OrderDetail;
use App\Product;
use App\User;

class OrderController extends Controller
{
    protected $successStatus = 200;

    public function addToCart(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'ean_number' => 'required',
            'qty' => 'required',
            'api_token' => 'required'
        ]);

        if($validator->fails())
            return response()->json($validator->errors(), $this->successStatus);

        //Check user
        $user = User::where('api_token',$request->api_token)->first();
        if(empty($user))
            return response()->json(['message' => 'Unauthorised'], $this->successStatus);

        $product = Product::where('ean_number',$request->ean_number)->first();
        if(empty($product))
            return response()->json(['message' => 'Product Not Found'], 404);

        //Check if use has exist order not checkout yet
        $order = Order::where('user_id',$user->id)->where('status','cart')->first();
        $subtotal = $request->qty*$product->price;

        if(empty($order))
        {
            $order = new Order();
            $order->user_id = $user->id;
            $order->order_barcode = rand(pow(10, 13-1), pow(10, 13)-1);
            $order->total = $subtotal;
            $order->status = 'cart';
        }
        else{
            $order->total = $order->total + $subtotal;
        }

        $order->save();

        //Check existing product id
        $orderDetail = OrderDetail::where('product_id',$product->id)->where('order_id',$order->id)->first();
        if(empty($orderDetail))
        {
            $orderDetail = new OrderDetail();
            $orderDetail->order_id = $order->id;
            $orderDetail->product_id = $product->id;
            $orderDetail->qty = $request->qty;
            $orderDetail->product_price = $product->price;
            $orderDetail->subtotal = $subtotal;
        }
        else{
            $orderDetail->qty = $orderDetail->qty + $request->qty;
            $orderDetail->subtotal = $orderDetail->subtotal + $subtotal;
        }

        $orderDetail->save();

        $message = $request->qty.' '.$product->name.' has been added to cart';
        if($order->save())
            return response()->json(['success' => true,'message' => $message], $this->successStatus);
    }

    public function checkout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_barcode' => 'required',
            'api_token' => 'required'
        ]);

        if($validator->fails())
            return response()->json($validator->errors(), $this->successStatus);

        $user = User::where('api_token',$request->api_token)->first();
        if(empty($user))
            return response()->json(['message' => 'Unauthorised'], 401);

        $order = Order::where('order_barcode',$request->order_barcode)->where('user_id',$user->id)->where('status','cart')->first();

        if(empty($order))
            return response()->json(['message' => 'Order not found'], 404);

        $isBalanceEnough = true;
        $billAmount = $order->total;
        $userBalance = $user->balance;

        if($userBalance < $billAmount)
            $isBalanceEnough = false;

        if(!$isBalanceEnough)
            return response()->json(['message' => 'Insuficient Balance'], 200);

        $order->status = 'fulfilled';
        $order->save();

        $user->balance = $userBalance - $billAmount;
        $user->save();

        return response()->json(['success' => true, 'message' => 'Checkout complete'], $this->successStatus);
    }
}
