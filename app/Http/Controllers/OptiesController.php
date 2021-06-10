<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;

class OptiesController extends Controller
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

     public function allOpties(Request $request)
     {
       if (Auth::check()) {

         return DB::table('opties')
         ->select('naam', 'type', 'id')
         ->get();

       }
     }

     public function getKeuzes(Request $request)
     {
       if (Auth::check()) {

         return DB::table('keuze_opties')
         ->where('optieID', '=', $request->id)
         ->get();


       }
     }

     public function add(Request $request)
     {
       if (Auth::check()) {

         $optieID = DB::table('opties')
         ->insertGetId([
           'naam' => $request->naam,
           'type' => $request->type]);

           if ($request->keuzes != []) {
             foreach ($request->keuzes as $keuze) {

               DB::table('keuze_opties')
               ->insert([
                 'optieID' => $optieID,
                 'value' => $keuze,
               ]);
             }
           }

        return $optieID;

       }
     }


     public function editOptie(Request $request)
     {
       if (Auth::check()) {

         $optie = DB::table('opties')
         ->where('id', '=', $request->main['id'])
         ->update([
           'naam' => $request->main['naam'],
           'type' => $request->main['type'],
         ]);

         foreach ($request->keuzes as $keuze) {
           DB::table('keuze_opties')
           ->where('id', '=', $keuze['id'])
           ->update([
             'value' => $keuze['value'],
           ]);
         }

         return $optie;

       }
     }

     public function delete(Request $request)
     {
       if (Auth::check()) {

         $optie = DB::table('opties')
         ->where('id', '=', $request->id)
         ->delete();

         DB::table('keuze_opties')
         ->where('optieID', '=', $request->id)
         ->delete();

         return $optie;

       }
     }

     public function deleteKeuze(Request $request)
     {
       if (Auth::check()) {

         return DB::table('keuze_opties')
         ->where('id', '=', $request->id)
         ->delete();

       }
     }
}
