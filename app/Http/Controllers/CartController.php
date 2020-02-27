<?php

namespace App\Http\Controllers;

use App\Cart;
use Illuminate\Http\Request;
use Session;
use App\Product;
use Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(Session::get('cart'));
        //use the session cart to get the details for the items
        $details_of_items_in_cart = [];
        $total = 0;
        if(!is_null(Session::get('cart')) || Session::exists('cart')){
            foreach(Session::get('cart') as $item_id => $quantity){
            //because session cart has keys($item_id) and values($quantity)
                //find the item
                $product = Product::find($item_id);
                if($product !== null){
                     //get the details needed
                    $product->quantity = $quantity;
                    $product->subtotal = $product->price * $quantity;
                    $total += $product->subtotal;
                    //Note: these properties (quantity and subtotal ARE NOT part of the Product stored in the database, they are only for $product)

                    //push to array containing the details
                    //google how to push data in an array
                    //Syntax: array_push (target array, data to be pushed)
                    array_push($details_of_items_in_cart, $product);

                }
               
            }
        }
        return view('products.cart', compact('details_of_items_in_cart', 'total'));
        // dd();
        //send the array to the view
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // if(is_null($cart)){

        // }
        // $cart[$request->item_id] = $request->quantity;
        // dd($cart);
        //way to create an array
        //$cart = array(values);
        //$cart = [value1,value2,etc];
        //What happens: when an item is added to cart, it will assign the quantity to index number equal to the item_id
        //To use a session:
        // Session::put('cart', $cart); //adds a session variable called cart with the content from $cart
        // dd(Session::get('cart'));

        //this is only halfway done, why? Because the Session::put overwrites the original content. Find a way to prevent it from overwriting. (i.e. revapm the entire logic)
        //1. Check if we already have a cart
        //1a. If there is a no cart, create a new one
        //1b. If there already is a cart, call the cart and update the content.
        //2b. Save the updated cart in the session.

        $cart = [];
        if($request->session()->has('cart')){
            $cart = $request->session()->get('cart');
            // $cart = Session::get("cart");
            // dd(Session::get("cart"));
        }

        // if(intval($cart[$id]) > 0){
        //     $cart[$id] = intval($cart[$id]) + intval($request->quantity);
        // }else{
        $cart[$request->item_id] = $request->quantity; //update the cart
        // dd($request->session()->get('cart'));
        $request->session()->put('cart', $cart);
        // Session::put("cart", $cart); //push it back to the session cart
        // //Syntax: put into $cart into a session variable called 'cart';
         // dd($request->session()->get('cart'));
        Session::flash('message', $request->quantity. " items added to cart");
        return redirect('/products'); //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cart = Session::get('cart');
        $cart[$id] = $request->quantity;  
        Session::put("cart", $cart);
        // $updatedItems = Session::get('cart');
        // dd($updatedItems);
        return redirect('/cart');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {  
        Session::forget('cart.'.$id); //unset($_SESSION['cart'][$id])

        return redirect('/cart');
    }

    public function emptyCart()
    {

        if(Session::exists('cart')){
            Session::forget('cart');
        }

        return redirect('/cart');
    }

    public function confirmOrder(){
        //Check if the user is logged in
        //if the user is logged in, get the cart again, recalculate the subtotal and total, and it to a view called orders.confirm
        //if the user is not logged in, redirect the user to the login page.
        if(Auth::check()){
            $details_of_items_in_cart = [];
            $total = 0;
            if(Session::exists('cart') || !is_null(Session::get('cart'))){
                foreach(Session::get('cart') as $item_id => $quantity){
                    $product = Product::find($item_id);
                    $product->quantity = $quantity;
                    $product->subtotal = $product->price * $product->quantity;
                    $total += $product->subtotal;

                    array_push($details_of_items_in_cart, $product);
                }

                return view('orders.confirm', compact('details_of_items_in_cart', 'total'));
            }

        }else{
            return redirect('/login');
        }
    }
}
