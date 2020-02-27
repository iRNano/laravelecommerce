<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Auth;
use App\Product;
use App\Status;
use Session;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() //only shows orders for those who are logged in
    {
        if(Auth::check()){
            if(Auth::user()->isAdmin){
                $orders = Order::all();
            }else{
                $orders = Order::where('user_id', auth()->user()->id)->get(); 
                //Note: ::find() was not used because it is only used for primary keys
            }
            
            return view('orders.orderlist', compact('orders'));
        }else{
            return redirect('/login');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Create a new order with total = 0
        $refNo = "B49".time();
        $new_order = new Order;
        $new_order->refNo = $refNo;
        $new_order->user_id = Auth::user()->id;
        $new_order->status_id = 1;
        $new_order->total = 0;
        $new_order->save(); //Save this new_order object, so we can use it as reference when attaching values to the pivot table(products_orders)
        //Attach the products to the new order
        $total = 0;
        foreach(Session::get('cart') as $item_id => $quantity){
            $product = Product::find($item_id);
            $subtotal = $product->price * $quantity;
            //checklist to attach: order_id ($order), item_id ($item_id), quantity ($quantity), subtotal($subtotal) to populate the products_orders table
            $new_order->products()->attach($item_id, ["quantity" => $quantity, "subtotal" => $subtotal]);
            //for this order, get the pivot table(products_orders) and create a new its order_id, item_id, quantity and subtotal fields.
            //the 2nd argument that starts with [] are the values for the pivot columns
            //update the total 
            $total += $subtotal;
        }
        //Update the new order's total
        $new_order->total = $total;
        $new_order->save(); //Update total property of new_order
        Session::forget('cart');
        return view('orders.result', compact('refNo'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $order->status_id = $request->status;
        $order->save();
        return redirect('/orders');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->status_id = 3;
        $order->save();
        return redirect('/orders');
    }
}
