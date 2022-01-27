<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotifyUserBan;
use App\Mail\NotifyUserWarning;
use Symfony\Component\HttpFoundation\Response;

class MailController extends Controller
{
    /**
     * Sends an email to notify a user has been banned
     * 
     */
    public function sendEmail($email) {
        $email = $email;
   
        $mailData = [
            'title' => 'You are now banned.',
            'url' => 'e-barter.co/appeal'
        ];
  
        Mail::to($email)->send(new NotifyUserBan($mailData));
   
        return response()->json([
            'message' => 'Email has been sent.'
        ], Response::HTTP_OK);
    }
    
    /**
     * Sends an email to warn a user
     * 
     */
    public function sendWarningEmail($email, $category) {
        $email = $email;
   
        $mailData = [
            'title' => 'This is email serves as a warning.',
            'url' => 'e-barter.co/dashboard',
            'category' => $category,
        ];
  
        Mail::to($email)->send(new NotifyUserWarning($mailData));
   
        return response()->json([
            'message' => 'Email has been sent.'
        ], Response::HTTP_OK);
    }
}
