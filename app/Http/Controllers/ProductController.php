<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use Illuminate\Http\Request;
use Session;
use Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() //catalog
    {
        //get all the products from the database
        // $products = Product::all();
        $products = Product::withTrashed()->get();
        //Gets alll the products even those soft deleted
        return view('products.catalog', compact("products")); //catalog.blade.php in views/products with products that corespond to $products
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // retrieve all categories via the all() method of the category model
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category_id = $request->category;

        //manage the image upload
        $image = $request->file('image'); //follows the name field in the form
        //actual file name when stored in project directory
        //date and time concatenated with a . concatenated with the file extension
        $image_name = time().'.'.$image->getClientOriginalExtension();
        //specify the subdirectory within the project's public folder where the image file will be saved
        $destination = "images/";
        //perform the actual saving of the image file by passing in the target directory and the desired file name to the move() method of the $image variable
        $image->move($destination, $image_name);
        //set the relative link pointing to the location of the image asset as the value for the product's img_path property
        $product->img_path = $destination.$image_name;
        //save the product in the database
        $product->save();
        $request->session()->flash('message', $request->name . " has been added");
        return redirect('products/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        //Product $product finds the specific product via the ID of the product, the id comes from the url that was specified in the route file.
        
        $product = Product::withTrashed()->where('id', $id)->first();
        // dd($product);
        $category = $product->category;
        
        return view('products.product', compact("product", "category"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        //use this function to have a view showing the details of the item in a form. (edit.blade.php)
        //create the form in edit.blade.ph
        return view('products.edit', compact("product", "categories"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category_id = $request->category;
        
        if($request->file('image') == ""){
            $product->img_path = $product->img_path;
        }else{
            $image = $request->file('image');
            $image_name = time().'.'.$image->getClientOriginalExtension();
            $destination = "images/";
            $image->move($destination, $image_name);
            $product->img_path = $destination.$image_name;
        }

        $product->save();
        $request->session()->flash('message', $request->name . " has been modified");
        return redirect("products/".$product->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        Session::flash('message', $product->name . " has been removed");
        $product->delete();

        return redirect("/products"); //route back to the catalog
    }

    public function restore($id){
        
        $product = Product::withTrashed()->where('id', $id)->first();

        $product->restore();
        return redirect('/products');
    }
}
