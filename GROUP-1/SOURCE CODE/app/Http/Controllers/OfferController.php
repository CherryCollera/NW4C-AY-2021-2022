<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Offer;
use App\Models\Post;
use App\Models\Conversation;
use App\Models\OfferImage;
use App\Models\Message;
use App\Models\Category;
use App\Models\QuantityType;
use Inertia\Inertia;

class OfferController extends Controller
{
    /**
     * Show all Offers
     *
     * @return Response
     */
    public function index()
    {
    }

    /**
     * Get a single offer
     *
     * @return Response
     */
    public function get($offerID)
    {
        $offer = Offer::find($offerID);

        return response()->json($offer);
    }

    /**
     * Creates a new offer
     *
     * @return Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'prod_name' => ['required', 'string'],
            'prod_qty' => ['required','numeric','gt:0'],
            'qty_type' => ['required', 'string'],
            'category' => ['required', 'string'],
            'date_produced' => ['required','date','before_or_equal:today'], // only accept dates before or today
            'date_expired' => ['required','date','after_or_equal:date_produced'],
            'post_id' => ['required', 'exists:posts,id']
        ])->validate();

        $newOffer = Offer::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::user()->id,
            'prod_name' => $request->prod_name,
            'prod_qty' => $request->prod_qty,
            'qty_type' => $request->qty_type,
            'date_produced' => $request->date_produced,
            'date_expiree' => $request->date_expired,
            'category' => $request->category,
            'est_price' => 0,
        ]);

        // check if images are empty
        if($request->filled('offerimg_filepath')){
            $imgPaths = $request->offerimg_filepath;
            
            foreach($imgPaths as $imgPath){
                OfferImage::create([
                    'offer_image_path' => $imgPath,
                    'offer_id' => $newOffer->id,
                ]);
            }

        }

        $request->session()->flash('flash.bannerId', uniqid());
        $request->session()->flash('flash.banner', 'Offer made succesfully! Check the offers made section.');
        $request->session()->flash('flash.bannerStyle', 'success');

        return redirect()->back()
                    ->with('message', 'Offer Made Successfully.');
    }
  
    /**
     * Update an offer
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        Validator::make($request->all(), [
            'prod_name' => ['required', 'string'],
            'prod_qty' => ['required','numeric','gt:0'],
            'qty_type' => ['required', 'string'],
            'category' => ['required', 'string'],
            'date_produced' => ['required','date','before_or_equal:today'], // only accept dates before or today
            'date_expired' => ['required','date','after_or_equal:date_produced'],
            'post_id' => ['required', 'exists:posts,id']
        ])->validate();

        Offer::where('id', $id)
        ->update([
            'prod_name' => $request->prod_name,
            'prod_qty' => $request->prod_qty,
            'qty_type' => $request->qty_type,
            'category' => $request->category,
            'date_produced' => $request->date_produced, 
            'date_expiree' => $request->date_expired,
            'est_price' => 0,
            'post_id' => $request->post_id
        ]);

         // check if images are empty
         if($request->filled('offerimg_filepath')){
            $imgPaths = $request->offerimg_filepath;

            // Delete all images then re-upload
            OfferImage::where('offer_id', $id)->delete();
            
            foreach($imgPaths as $imgPath){
                OfferImage::create([
                    'offer_image_path' => $imgPath,
                    'offer_id' => $id,
                ]);
            }
        }


        $request->session()->flash('flash.bannerId', uniqid());
        $request->session()->flash('flash.banner', 'Offer edited succesfully!');
        $request->session()->flash('flash.bannerStyle', 'success');

        return redirect()->back()
                    ->with('message', 'Offer Made Successfully.');

    }
  
    /**
     * Destroy an offer
     *
     * @return Response
     */
    public function destroy($offerID, Request $request)
    {
        Validator::make($request->all(), [
            'offerID' => ['required']
        ])->validate();

        Offer::destroy($offerID);
        
        $request->session()->flash('flash.bannerId', uniqid());
        $request->session()->flash('flash.banner', "Offer Deleted");
        $request->session()->flash('flash.bannerStyle', 'success');

        return redirect()->back()
                    ->with('message', 'Offer Deleted Successfully.');
    }

    /**
     * Reject an Offer
     *
     * @return Response
     */
    public function rejectOffer($offerID, Request $request){

        Validator::make($request->all(), [
            'offerID' => ['required'],
        ]);

        $offer = Offer::findOrFail($offerID);
        $offer->status = 'rejected';
        $offer->save();

        $request->session()->flash('flash.bannerId', uniqid());
        $request->session()->flash('flash.banner', "Offer Rejected");
        $request->session()->flash('flash.bannerStyle', 'success');

        return redirect()->back()
                    ->with('message', 'Offer Rejected Successfully.');
    }

    /**
     * Determine if an offer for a specific post
     * Already exists
     * 
     * @return JSON
     */
    public function offerExists($postID,$userID, Request $request){
        $alreadyExists = Offer::where([
            ['post_id', '=', $postID],
            ['user_id', '=', $userID],
        ])->first();

        if($alreadyExists){    
            return response()->json(true);
        }else{
            return response()->json(false);
        }
    }

    /**
     * Show the offers page
     * 
     * @return Inertia
     */
    public function showOffers(){
        $offersMade = Offer::where('user_id', Auth::user()->id)->latest()->paginate(12);
        $categories = Category::orderBy('id', 'asc')->get();
        $qtyType = QuantityType::orderBy('id', 'asc')->get();

        return Inertia::render('OffersMade', ['offersMade' => $offersMade,
                                    'categories' => $categories,
                                    'qtyTypes' => $qtyType]);
    }

    /**
     * Accept Offer
     * 
     * @return Inertia
     */
    public function acceptOffer($offerID, Request $request){

        $offer = Offer::find($offerID);
        $post = Post::find($offer->post_id);

        Offer::where('id', $offerID)->update(['status' => 'negotiating']);
        Post::where('id', $post->id)->update(['status' => 'negotiating']);

        $newConvo = Conversation::create([
            'sender_user_id' => $offer->user_id,
            'receiver_user_id' => $post->user_id,
            'post_id' => $offer->post_id,
        ]);

        Message::create([
            'convo_id' => $newConvo->id,
            'sender_id' => Auth::user()->id,
            'post_id' => $offer->post_id,
            'offer_id' => $offerID,
            'content' => "I have accepted your offer, let's negotiate!",
            'image_path' => null,
            'is_read' => false
        ]);

        return response(200);
    }

    /**
     * Gets an offer based on post id and current auth user id
     * 
     * @return JSON
     */
    public function getOfferOfAuthUser($postID, $otherUserID){

        $offer = Offer::where('post_id', '=', $postID)
                ->whereIn('user_id', [Auth::user()->id, $otherUserID])
                ->get();

        if($offer->isEmpty()) return response()->json();

        return response()->json($offer[0]);

    }

    /**
     * Gets the count of Offers
     * 
     * @return Integer
     */
    public function getOfferCount($postID){
        $count = Offer::where('post_id',  $postID)->get()->count();

        return $count;
    }

    /**
     * Get offers targeted to a user
     * 
     * @return JSON
     */
    public function getOfferToUser($userID){

        $posts = Post::where('user_id', Auth::user()->id)->get();
        
        $posts->transform(function ($post, $key) {
            return $post->id;
        });

        $offers = Offer::whereIn('post_id', $posts)->get();

        return response()->json($offers);
    }
    
}
