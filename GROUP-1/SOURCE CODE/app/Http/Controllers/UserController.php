<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Offer;
use App\Models\Conversation;
use App\Models\Barter;
use App\Models\Category;
use App\Models\QuantityType;
use App\Models\Promotion;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Show all User
     *
     * @return Response
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    /**
     * Get a single user
     *
     * @return Response
     */
    public function get($userID)
    {
        $user = User::find($userID);
        $filtered =$user->only(['name','city']);
        return response()->json($filtered);
    }

    /**
     * Get data of a user
     * 
     * @param UserID
     * @return JSON
     */
    public function getUser($id){
        $user = User::find($id);
        $filtered = $user->only(['name','city', 'profile_photo_path', 'id', 'contact_number', 'email','bio', 'access_level']);
        return response()->json($filtered);
    }

    /**
     * Display user profile
     * 
     * @param UserID
     * @return Inertia
     */
    public function getProfile($id){
        $user = User::findOrFail($id);

        if(str_contains($user->email, 'banned_')){
            return Inertia::render('BannedProfile');
        }

        $posts = Post::where('user_id', $id)->orderBy('updated_at','desc')->paginate(12);
        
        $categories = Category::orderBy('id', 'asc')->get();
        $qtyType = QuantityType::orderBy('id', 'asc')->get();

        // get trades count
        // Check existence of search params
        $posts2 = Post::where('user_id', $id)
                ->orderBy('updated_at', 'desc')
                ->get();
        
        $off = Offer::orderBy('updated_at', 'desc')
                ->get();
        
        $offerss = $off->filter(function ($offer, $key) use($posts2, $id) {
            return $offer->user_id == $id || $posts2->contains('id', $offer->post_id);
        });
        
        $offers = $offerss->isEmpty() 
                ? 0
                : $offerss->filter(function ($offer, $key){
                    return $offer->status == 'sold';
                })->count();

        return Inertia::render('Profile', [
            'posts' => $posts,
            'id' => $id,
            'categories' => $categories,
            'qtyTypes' => $qtyType,
            'offers' => $offers,
        ]);
    }

    /**
     * Get Current Authenticated User
     * 
     * @return JSON
     */
    public function getCurrentUser(){
        return response()->json(Auth::user());
    }

    /**
     * Get name of a user
     * 
     * @return String
     */
    public function getName($id){

        $user = User::findOrFail($id);

        return $user->name;
    }

     /**
     * Displays the transaction history
     *
     * @return Inertia
     */
    public function getTransactionHistory (Request $request){

        // Check existence of search params
        $transactionType = isset($request->query()['category']) ? $request->query()['category'] : null;

        $categories = Category::orderBy('id', 'asc')->get();
        $qtyType = QuantityType::orderBy('id', 'asc')->get();

        $posts = Post::where('user_id', Auth::user()->id)
                ->orderBy('updated_at', 'desc')
                ->get();
        
        $off = Offer::orderBy('updated_at', 'desc')
                ->get();
        
        $offerss = $off->filter(function ($offer, $key) use($posts) {
            return $offer->user_id == Auth::user()->id || $posts->contains('id', $offer->post_id);
        });
        
        $offers = $offerss->isEmpty() 
                ? Offer::where('id', '<', 0)->paginate(12)
                : $offerss->customPaginate(12)->withQueryString();

        if($offers && $transactionType){

            $type;

            if($transactionType == 'success'){
                $type = 'sold';
            }else if($transactionType == 'negotiating'){
                $type = 'negotiating';
            }else if($transactionType == 'rejected'){
                $type = 'rejected';
            }else if($transactionType == 'pending'){
                $type = null;
            }else if($transactionType == 'deleted'){
                $type = 'post deleted';
            }

            $offers = $offers->filter(function ($offer, $key) use($type){
                return $offer->status == $type;
            })->customPaginate(12)->withQueryString();

        }

        return Inertia::render('TransactionHistory', 
            ['offers' => $offers,
            'categories' => $categories,
            'qtyTypes' => $qtyType]);
    }

    /**
     * Displays The types 
     * 
     * @return Inertia
     */
    public function modifyTypes(){
        if(Auth::user()->access_level && Auth::user()->access_level === 1){

            $categories = Category::orderBy('id', 'asc')->get();
            $qtyType = QuantityType::orderBy('id', 'asc')->get();

            return Inertia::render('ModifyTypes',  ['categories' => $categories, 'qtyTypes' => $qtyType] );
            
        }else{
            return abort(403);
        }
    }

    /**
     * Displays the list of moderators
     * 
     * @return Inertia
     */
    public function viewModerators(){
        if(Auth::user()->access_level && Auth::user()->access_level == 1){

            $moderators = User::where('access_level', 2)->get();

            $promotions = Promotion::latest()->get();

            return Inertia::render('ViewModerators',['moderators' => $moderators, 'promotions' => $promotions]);
        }else{
            return abort(403);
        }
    }

    /**
     * Promote or Demote a user
     * 
     * @return Redirect
     */
    public function setPromotion(Request $request){
        if(Auth::user()->access_level && Auth::user()->access_level == 1){
            Validator::make($request->all(), [
                'user_id' => ['required', 'numeric'],
                'promoted_to' => ['required', 'numeric'],
            ])->validate();
            
            // Insert promotion record to database
            Promotion::create([
                'user_id' => $request->user_id,
                'promoted_to' => $request->promoted_to,
                'promoted_by' => Auth::user()->id,
            ]);
            

            // If user is demoted, clear access level
            // Otherwise, set access level
            if($request->promoted_to > 2){
                User::where('id', $request->user_id)->update([
                    'access_level' => null
                ]);
            }else if($request->promoted_to <= 2){
                User::where('id', $request->user_id)->update([
                    'access_level' => $request->promoted_to,
                ]);
            }

            $request->session()->flash('flash.bannerId', uniqid());
            $request->session()->flash('flash.banner', 'Added Moderator!');
            $request->session()->flash('flash.bannerStyle', 'success');
    
            return redirect()->back()
                        ->with('message', 'Added Moderator Succesfully.');
            

        }else{
            return abort(403);
        }
    }

    /**
     * Get a user's promotion
     * 
     * @return JSON
     */
    public function getPromotion(Request $request, $id){
        if(Auth::user()->access_level && Auth::user()->access_level == 1){
            $promoter = Promotion::where('user_id', $id)
            ->latest()
            ->first();

            return response()->json($promoter);
        }else{
            return abort(403);
        }
    }

    /**
     * Give appeal for reported users
     * 
     * @return JSON
     */
    public function appeal(Request $request){
        return Inertia::render('Appeal');
    }
}
