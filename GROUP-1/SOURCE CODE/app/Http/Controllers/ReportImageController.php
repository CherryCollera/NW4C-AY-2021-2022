<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReportImage;

class ReportImageController
 extends Controller
{
    /**
     * Creates a new Post Image
     *
     * @return Response
     */
    public function store(Request $request)
    {

        if($request->hasFile('reportimg')){
            $file = $request->file('reportimg');
            $filename = $file->getClientOriginalName();
            $folder = uniqid() . '-' . now()->timestamp;
            $file->storeAs('public/reportimgs/' . $folder , $filename);
            
            return 'reportimgs/' . $folder . '/' . $filename;
        }
        
        return response('file does not exists', 500);
    }

    /**
     * Reverts an uploaded image
     * @todo NOT YET WORKING!!!
     * @return Response
     */
    public function revert(Request $request)
    {
        $filePath = $request->getContent();
        \Storage::deleteDirectory('app/reportimgs/tmp/' . $filePath);
        return 'deleted' . storage_path('app/reportimgs/tmp/' . $filePath);

    }

    /**
     * Get the images of a report 
     * 
     * @return JSON
     */
    public function get($reportID){
        $reportImages = ReportImage::where('report_id', $reportID)->get();
        return response()->json($reportImages);
    }
}
