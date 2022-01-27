<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostImage;
use Inertia\Inertia;

class PostImageController extends Controller
{
     /**
     * Show all Post Images
     *
     * @return Response
     */
    public function index()
    {
    }
  
    /**
     * Creates a new Post Image
     *
     * @return Response
     */
    public function store(Request $request)
    {
        if($request->hasFile('postimg')){
            $file = $request->file('postimg');
            $filename = $file->getClientOriginalName();
            $folder = uniqid() . '-' . now()->timestamp;
            $file->storeAs('public/postimgs/' . $folder , $filename);
            
            return 'postimgs/' . $folder . '/' . $filename;
        }
        
        return '';
    }

    /**
     * Reverts an uploaded image
     * @todo NOT YET WORKING!!!
     * @return Response
     */
    public function revert(Request $request)
    {
        $filePath = $request->getContent();
        \Storage::deleteDirectory('app/postimgs/tmp/' . $filePath);
        return 'deleted' . storage_path('app/postimgs/tmp/' . $filePath);

    }
  
    /**
     * Update a Post Image
     *
     * @return Response
     */
    public function update(Request $request)
    {
    }
  
    /**
     * Destroy a Post Image
     *
     * @return Response
     */
    public function destroy(Request $request)
    {
    }
    
    /**
     * Get all images of a post
     *
     * @return JSON
     */
    public function getPostImage($postID)
    {
        $postImages = PostImage::where('post_id', $postID)->get();
        return response()->json($postImages);
    }
}
