<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OfferImage;

class OfferImagesController extends Controller
{
    /**
     * Get all images of an offer
     *
     * @return Response
     */
    public function getOfferImage($offerID){
        $offerImages = OfferImage::where('offer_id', $offerID)->get();
        return response()->json($offerImages);
    }
}
