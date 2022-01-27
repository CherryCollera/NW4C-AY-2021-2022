<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Cart;
use App\Models\Post;
use App\Models\Category;
use App\Models\QuantityType;
use Inertia\Inertia;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Creates a new cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $alreadyExists = Cart::where([
            ['post_id', '=', $request->post_id],
            ['user_id', '=', Auth::user()->id],
        ])->first();

        if($alreadyExists){
            $request->session()->flash('flash.bannerId', uniqid());
            $request->session()->flash('flash.banner', 'Item already added to cart');
            $request->session()->flash('flash.bannerStyle', 'danger');

            return redirect()->back()
                    ->with('message', 'Added to cart Successfully.');
        }

        Validator::make($request->all(), [
            'post_id' => ['required', 'integer', 'exists:posts,id'],
        ])->validate();

        Cart::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::user()->id,
        ]);

        $request->session()->flash('flash.bannerId', uniqid());
        $request->session()->flash('flash.banner', 'Added to cart!');
        $request->session()->flash('flash.bannerStyle', 'success');

        return redirect()->back()
                    ->with('message', 'Added to cart Successfully.');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($postID, Request $request)
    {
        
        Cart::where([
            ['post_id', '=', $postID],
            ['user_id', '=', Auth::user()->id],
        ])->delete();
        
        $request->session()->flash('flash.bannerId', uniqid());
        $request->session()->flash('flash.banner', "Cart Item Deleted");
        $request->session()->flash('flash.bannerStyle', 'success');

        return redirect()->back()
                    ->with('message', 'Cart Item Deleted Successfully.');
    }

    /**
     * Display the cart of current user
     *
     * @return Inertia
     */
    public function showCart()
    {
        // Get the content of the user's cart
        $cart = Cart::where('user_id', Auth::user()->id)->get();

        $postIds = [];
        
        // Store all the post id's in postIds Array
        foreach($cart as $cartItem) {
            array_push($postIds, $cartItem->post_id);
        }

        // Get all posts containg the gathered postIds
        $posts = Post::whereIn('id', $postIds)->paginate(12);

        $categories = Category::orderBy('id', 'asc')->get();
        $qtyType = QuantityType::orderBy('id', 'asc')->get();

        return Inertia::render('Cart', [
            'posts' => $posts,
            'categories' => $categories,
            'qtyTypes' => $qtyType
        ]);
    }
}
