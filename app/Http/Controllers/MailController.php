<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function send(Request $request)
    {
      $data = array('name'=>"Virat Gandhi");
      
      Mail::send(['text'=>'mail'], $data, function($message) {
      $message->to('casperbosma@gmail.com', 'Tutorials Point')->subject
         ('Laravel Basic Testing Mail');
      $message->from('xyz@gmail.com','Virat Gandhi');
   });
   return "Basic Email Sent. Check your inbox.";
    }



}
