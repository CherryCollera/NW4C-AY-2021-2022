<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Post;
use App\Models\ReportImage;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ReportController extends Controller
{
    public function store(Request $request){
        Validator::make($request->all(), [
            'report_type' => ['required', 'string'],
            'report_desc' => ['required','string'],
        ])->validate();

        $newReport = Report::create([
            'user_id' => Auth::user()->id,
            'reported_post_id' => $request->reported_post_id,
            'reported_user_id' => $request->reported_user_id,
            'description' => $request->report_desc,
            'report_type' => $request->report_type,
        ]);

        // check if images are empty
        if($request->filled('reportimg_filepath')){
            $imgPaths = $request->reportimg_filepath;
            
            foreach($imgPaths as $imgPath){
                ReportImage::create([
                    'report_image_file_path' => $imgPath,
                    'report_id' => $newReport->id,
                ]);
            }

        }

        // if($request->reported_post_id != 0){
        //     $post = Post::find($request->reported_post_id);
        //     $post->delete();
        // }

        $request->session()->flash('flash.bannerId', uniqid());
        $request->session()->flash('flash.banner', 'Reported succesfully! Administrators will review this report.');
        $request->session()->flash('flash.bannerStyle', 'success');

        return redirect()->back()
                    ->with('message', 'Reported Successfully.');
    }

    public function viewReports(Request $request){
        if(Auth::user()->access_level && Auth::user()->access_level === 1 || Auth::user()->access_level === 2){

            $reports = Report::orderBy('id', 'desc')->get();

            return Inertia::render('ViewReports',  ['reports' => $reports] );
            
        }else{
            return abort(403);
        }
    }

    /**
     * Absolve a report
     * 
     * @return JSON
     */
    public function absolve(Request $request){
        if(Auth::user()->access_level && Auth::user()->access_level === 1 || Auth::user()->access_level === 2){
            $report = Report::where('id', $request->report['id'])
                            ->update([
                                'action_taken' => 'Absolved',
                                'is_resolved' => true,
                                'mod_assigned' => Auth::user()->id,
                            ]);

            $request->session()->flash('flash.bannerId', uniqid());
            $request->session()->flash('flash.banner', 'User has been absolved.');
            $request->session()->flash('flash.bannerStyle', 'success');
    
            return redirect()->back()
                        ->with('message', 'Report Resolved.');
        }else{
            return abort(403);
        }
    }
    
    /**
     * Ban a report
     * 
     * @return JSON
     */
    public function ban(Request $request){
        if(Auth::user()->access_level && Auth::user()->access_level === 1 || Auth::user()->access_level === 2){

            $report = Report::where('id', $request->report['id'])
                            ->update([
                                'action_taken' => 'Banned',
                                'is_resolved' => true,
                                'mod_assigned' => Auth::user()->id,
                            ]);
            
            //If a post is reported, delete post
            if($request->report['reported_post_id']){
                Post::where('id', $request->report['reported_post_id'])->delete();
            }else if($request->report['reported_user_id']){
                $reportedUser = User::find($request->report['reported_user_id']);

                User::where('id', $request->report['reported_user_id'])->update([
                    'password' => 'qwerty', //to disable a user
                    'email' => 'banned_' . $reportedUser->email,
                ]);

                app(MailController::class)->sendEmail($reportedUser->email);
            }

            $request->session()->flash('flash.bannerId', uniqid());
            $request->session()->flash('flash.banner', 'User has been reprimanded');
            $request->session()->flash('flash.bannerStyle', 'success');

    
            return redirect()->back()
                        ->with('message', 'Report Resolved.');
            
        }else{
            return abort(403);
        }
    }

    /**
     * Send a warning
     * 
     * @return JSON
     */
    public function warn(Request $request){
        if(Auth::user()->access_level && Auth::user()->access_level === 1 || Auth::user()->access_level === 2){

            $report = Report::where('id', $request->report['id'])
                            ->update([
                                'action_taken' => 'Warned',
                                'is_resolved' => true,
                                'mod_assigned' => Auth::user()->id,
                            ]);
            
            // Send warning by email
            $reportedUser = User::find($request->report['reported_user_id']);
            $category = $this->getReportCategory($request->report['report_type']);
            app(MailController::class)->sendWarningEmail($reportedUser->email, $category);

            $request->session()->flash('flash.bannerId', uniqid());
            $request->session()->flash('flash.banner', 'User has been warned by email');
            $request->session()->flash('flash.bannerStyle', 'success');

            return redirect()->back()
                        ->with('message', 'Report Resolved.');
            
        }else{
            return abort(403);
        }
    }

    /**
     * Get Report Category Type
     * 
     */
    public function getReportCategory($type) {
        switch ($type) {
          case "categ-1":
            return "Offensive Language";
          case "categ-2":
            return "Harassment";
          case "categ-3":
            return "Sexually Explicit Contents";
          case "categ-4":
            return "Fraud";
          case "categ-5":
            return "Inappropriate Contents";
          default:
            return "Unknown";
        }
      }

    /**
     * Get how many times a user has been reported
     * 
     */
    public function getOffenseLevel($userID){
        $reports = Report::where('reported_user_id', $userID)->orderBy('id', 'asc')->get();
        return response()->json($reports);
    }
}
