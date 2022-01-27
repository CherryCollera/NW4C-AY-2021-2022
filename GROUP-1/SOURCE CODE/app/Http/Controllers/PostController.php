<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\PostImage;
use App\Models\Conversation;
use App\Models\Offer;
use App\Models\Message;
use App\Models\Category;
use App\Models\QuantityType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use App\Events\NewChatMessage;

class PostController extends Controller
{
    /**
     * Show all Post
     *
     * @return Response
     */
    public function index()
    {
        $posts = Post::all();
        return response()->json($posts);
    }

    /**
     * Get a single Post
     *
     * @return Response
     */
    public function get($postID)
    {
        $post = Post::find($postID);

        return response()->json($post);
    }

    /**
     * Get all Post of Authenticated User
     *
     * @return Response
     */
    public function getAuthUserPosts()
    {
        $posts = Post::where('user_id', Auth::user()->id)
                    ->orderBy('id','desc')
                    ->get();


        return response()->json($posts);
    }
  
    /**
     * Get all Post of User
     *
     * @return Response
     */
    public function getUserPosts($userID)
    {
        $posts = Post::where('user_id', $userID)
                    ->orderBy('id','desc')
                    ->get();

        return response()->json($posts);
    }
  
    /**
     * Creates a new Post
     *
     * @return Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'post_title' => ['required', 'string'],
            'post_desc' => ['required', 'string'],
            'prod_name' => ['required', 'string'],
            'prod_qty' => ['required','numeric','gt:0'],
            'category' => ['required', 'string'],
            'qty_type' => ['required', 'string'],
            'date_produced' => ['required','date','before_or_equal:today'], // only accept dates before or today
            'date_expired' => ['required','date','after_or_equal:date_produced'],
            'pref_prod' => ['required', 'string'],
        ])->validate();

        $newPost = Post::create([
            'user_id' => Auth::user()->id,
            'title' => $request->post_title,
            'description' => $request->post_desc,
            'prod_name' => $request->prod_name,
            'prod_qty' => $request->prod_qty,
            'qty_type' => $request->qty_type,
            'date_produced' => $request->date_produced,
            'date_expiree' => $request->date_expired,
            'status' => 'available',
            'category' => $request->category,
            'views' => 0,
            'preferred_prod' => $request->pref_prod,
            'est_price' => 0,
        ]);

        // check if images are empty
        if($request->filled('postimg_filepath')){
            $imgPaths = $request->postimg_filepath;
            
            foreach($imgPaths as $imgPath){
                PostImage::create([
                    'post_image_path' => $imgPath,
                    'post_id' => $newPost->id,
                ]);
            }

        }

        $request->session()->flash('flash.bannerId', uniqid());
        $request->session()->flash('flash.banner', 'New Post Created!');
        $request->session()->flash('flash.bannerStyle', 'success');

        return redirect()->back()
                    ->with('message', 'Post Created Successfully.');
    }
  
    /**
     * Update a Post
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        Validator::make($request->all(), [
            'post_title' => ['required', 'string'],
            'post_desc' => ['required', 'string'],
            'prod_name' => ['required', 'string'],
            'prod_qty' => ['required','numeric','gt:0'],
            'category' => ['required', 'string'],
            'qty_type' => ['required', 'string'],
            'date_produced' => ['required','date','before_or_equal:today'], // only accept dates before or today
            'date_expired' => ['required','date','after_or_equal:date_produced'],
            'pref_prod' => ['required', 'string'],
        ])->validate();

        Post::where('id', $request->post_id)
                ->update([
                    'user_id' => Auth::user()->id,
                    'title' => $request->post_title,
                    'description' => $request->post_desc,
                    'prod_name' => $request->prod_name,
                    'prod_qty' => $request->prod_qty,
                    'qty_type' => $request->qty_type,
                    'date_produced' => $request->date_produced,
                    'date_expiree' => $request->date_expired,
                    'status' => 'available',
                    'category' => $request->category,
                    'views' => 0,
                    'preferred_prod' => $request->pref_prod,
                    'est_price' => 0,
                ]);

        // check if images are empty
        if($request->filled('postimg_filepath')){
            $imgPaths = $request->postimg_filepath;

            // Delete all images of post then re-upload
            Postimage::where('post_id', $request->post_id)->delete();

            foreach($imgPaths as $imgPath){
                PostImage::create([
                    'post_image_path' => $imgPath,
                    'post_id' => $request->post_id,
                ]);
            }

        }

        $request->session()->flash('flash.bannerId', uniqid());
        $request->session()->flash('flash.banner', 'Post Edited!');
        $request->session()->flash('flash.bannerStyle', 'success');

        return redirect()->back()
                    ->with('message', 'Post Created Successfully.');
        
    }
  
    /**
     * Destroy a Post
     *
     * @return Response
     */
    public function destroy($id, Request $request)
    {

        $conversation = Conversation::where('post_id', $id)->first();
        
        Offer::where('post_id', $id)->update([
            'status' => 'post deleted'
        ]);

        if($conversation && $conversation->post_id){
            $newMessage = Message::create([
                'post_id' => $id,
                'convo_id' => $conversation->id,
                'sender_id' => Auth::user()->id,
                'content' => 'Y44OpG1tkc6XXe1eJD0U6zkjpz2WSg5EQwUqCzktqNFLQyZZnnjMcHo1NuWIg3TgXZ8y6FASjOZX97NR5NJ4IslpmFeao6ZK3fDJISMyQ1wdcJjdnIqSudjbwSxEa6H6W0sHli5Dr1eLASnhfNUuqLd0qfrXtQCaJsuNMcsXQIqMHSNY8SruMpj4gCANUmbiHMezuYcSF4Ir3WHzgkbK7vmbeTkMrT8lGoE4v8roHvH5TAK1UAQoODgK8fGzeJk3',
                'is_read' => false
            ]);
    
            broadcast(new NewChatMessage($newMessage));
        }

        Validator::make($request->all(), [
            'password' => ['required','current_password'],
        ])->validate();

        Post::destroy($id);
        PostImage::where('post_id', $id)->delete();
        
        $request->session()->flash('flash.bannerId', uniqid());
        $request->session()->flash('flash.banner', "Post Deleted");
        $request->session()->flash('flash.bannerStyle', 'success');

        return redirect()->back()
                    ->with('message', 'Post Created Successfully.');

    }

    public function extractUser ($postID, Request $request){

        $post = Post::find($postID);
        $user = User::find($post->user_id);

        return response()->json($user);

    }

    /**
     * Sorts the post and displays the dashboard page
     *
     * @return Inertia
     */
    public function sortPosts (Request $request){
        // Check existence of search params
        $search = isset($request->query()['searchKeyword']) ? $request->query()['searchKeyword'] : null;

        // Check existence of params
        $category = isset($request->query()['category']) ? $request->query()['category'] : 'all';
        $location = isset($request->query()['location']) ? $request->query()['location'] : null;
        $price = isset($request->query()['price']) ? $request->query()['price'] : null; 
        $price2 = isset($request->query()['price2']) ? $request->query()['price2'] : null; 
        $hideOwnPost = isset($request->query()['hideOwnPost']) ? $request->query()['hideOwnPost'] : null;
        $producedDate = isset($request->query()['producedDate']) ? $request->query()['producedDate'] : null;
        $expiredDate = isset($request->query()['expiredDate']) ? $request->query()['expiredDate'] : null;
        $status = isset($request->query()['status']) ? $request->query()['status'] : null;
        
        $allUsers = Post::with(['user'])->latest()->get();
        
        $queryHolder = $allUsers
                        ->filterLocation($location)
                        ->filterPrice($price, $price2)
                        ->filterHideOwnPost($hideOwnPost)
                        ->filterProducedDate($producedDate)
                        ->filterExpiredDate($expiredDate)
                        ->filterStatus($status)
                        ->filterCategory($category)
                        ->searchKeyword($search);
                        
        $posts = $queryHolder->isEmpty() 
                ? Post::where('id', '<', 0)->paginate(12)
                : $queryHolder->customPaginate(12)->withQueryString();

        $categories = Category::orderBy('id', 'asc')->get();
        $qtyType = QuantityType::orderBy('id', 'asc')->get();

        return Inertia::render('Dashboard', ['posts' => $posts, 
                                             'categories' => $categories,
                                             'qtyTypes' => $qtyType ]);
    }

    /**
     * Check if a post exists in a conversation
     * Used to determine the status of a post
     * 
     * @return Boolean
     */
    public function postExistsInConversation($postID){
        $existInConversation = Conversation::where('post_id', $postID)->get();
        return $existInConversation->isEmpty() ? false : true;
    }
    
    /**
     * Get all offers of a post
     * 
     * @return JSON
     */
    public function getPostOffers($postID){
        $postOffers = Offer::where('post_id', $postID)->get();
        return response()->json($postOffers);
    }

    /**
     * Check if a posts exists
     * 
     * @return Boolean
     */
    public function exists($postID){   
        
        $post = Post::find($postID);

        return response()->json($post ? true : false);
    }


}
