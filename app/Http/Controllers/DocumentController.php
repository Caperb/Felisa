<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
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


     public function getAlgemeneVoorwaarden(Request $request)
     {
           return Storage::download('Algemene voorwaarden.pdf');
     }

     public function getPrivacyPolicy(Request $request)
     {
           return Storage::download('Privacy policy.pdf');
     }

     public function getReturnForm(Request $request)
     {
           return Storage::download('Terugstuur formulier.pdf');
     }

}
