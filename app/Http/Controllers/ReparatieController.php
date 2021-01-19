<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ReparatieController extends Controller
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
    public function add(Request $request)
    {
      if (Auth::check()) {

        $orderID = DB::table('ticket')
        ->insertGetId([
          'type' => 'Repair',
          'merk' => $request->merk,
          'model' => $request->model,
          'provider' => $request->provider,
          'eerderGerepareerd' => $request->eerderGerepareerd,
          'schades' => $request->schades,
          'beschrijving' => $request->beschrijving,
          'prijs' => $request->kosten,
          'userID' => $request->userID,
          'klantID' => $request->klantID,
          'created_at' => Carbon::now(),
        ]);

        $data = $request->handtekening;
        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);
        $data = base64_decode($data);
        Storage::disk('public')
        ->put('/handtekeningen\/'.$request->userID.'/'.$orderID.'.png', $data, 'private');

        return $orderID;
      }
    }

    public function getAll(Request $request)
    {
      if (Auth::check()) {

        return DB::table('ticket')
        ->select('ticket.merk', 'ticket.model', 'ticket.provider', 'ticket.prijs', 'ticket.KlantID', 'ticket.userID',
        'ticket.due', 'ticket.state', 'ticket.id', 'ticket.schades', 'ticket.beschrijving', 'ticket.eerderGerepareerd', 'ticket.created_at', 'klant.voornaam', 'klant.tussenvoegsel', 'klant.achternaam')
        ->join('klant', 'ticket.klantID', '=', 'klant.id')
        ->where('type', '=', 'Repair')
        ->orderBy($request->orderBy, $request->orderByType)
        ->paginate(20);

      }
    }

   public function dashboardAdd(Request $request)
   {
     if (Auth::check()) {

       $positionT = strpos($request->due, "T");
       $date = substr($request->due, 0, $positionT);
       $time = substr($request->due, $positionT+1, 8);
       $datetime = $date.' '.$time;

       return DB::table('ticket')
       ->insert([
         'type' => 'Repair',
         'klantID' => $request->klantID,
         'userID' => $request->geholpenDoor,
         'handtekeningID' => 0,
         'merk' => $request->merk,
         'model' => $request->model,
         'prijs' => $request->prijs,
         'provider' => $request->provider,
         'due' => $datetime,
         'state' => $request->state,
         'schades' => $request->schades,
         'beschrijving' => $request->beschrijving,
         'eerderGerepareerd' => $request->eerderGerepareerd,
         'created_at' => Carbon::now(),
       ]);

     }
   }

   public function delete(Request $request)
   {
     if (Auth::check()) {

       return DB::table('ticket')
       ->where('id', '=', $request->id)
       ->delete();

     }
   }

   public function search(Request $request)
   {
     if (Auth::check()) {

       return DB::table('ticket')
       ->select('ticket.merk', 'ticket.model', 'ticket.provider', 'ticket.prijs', 'ticket.KlantID', 'ticket.userID',
       'ticket.due', 'ticket.state', 'ticket.id', 'ticket.schades', 'ticket.beschrijving', 'ticket.eerderGerepareerd', 'ticket.created_at', 'klant.voornaam', 'klant.tussenvoegsel', 'klant.achternaam')
       ->join('klant', 'ticket.klantID', '=', 'klant.id')
       ->where('type', '=', 'Repair')
       ->where(function ($query) use ($request) {
              $query->where('klant.voornaam', 'like', $request->input.'%')
              ->orWhere('klant.achternaam', 'like', $request->input.'%')
              ->orWhere('ticket.id', 'like', $request->input.'%')
              ->orWhere('ticket.created_at', 'like', $request->input.'%')
              ->orWhere('ticket.due', 'like', $request->input.'%')
              ->orWhere('ticket.state', 'like', $request->input.'%');
          })
       ->orderBy($request->orderBy, $request->orderByType)
       ->paginate(20);
     }
   }

   public function edit(Request $request)
   {
     if (Auth::check()) {
       if (isset($request->klantID)) {
         return DB::table('ticket')
         ->where('id', '=', $request->id)
         ->where('type', '=', 'Repair')
         ->update([
           'userID' => $request->userID,
           'handtekeningID' => 0,
           'merk' => $request->merk,
           'model' => $request->model,
           'prijs' => $request->prijs,
           'provider' => $request->provider,
           'due' => $request->due,
           'state' => $request->state,
           'schades' => $request->schades,
           'beschrijving' => $request->beschrijving,
           'eerderGerepareerd' => $request->eerderGerepareerd,
           'klantID' => $request->klantID,
           'updated_at' => Carbon::now(),
         ]);
       }else {
         return DB::table('ticket')
         ->where('id', '=', $request->id)
         ->where('type', '=', 'Repair')
         ->update([
           'userID' => $request->userID,
           'handtekeningID' => 0,
           'merk' => $request->merk,
           'model' => $request->model,
           'prijs' => $request->prijs,
           'provider' => $request->provider,
           'due' => $request->due,
           'state' => $request->state,
           'schades' => $request->schades,
           'beschrijving' => $request->beschrijving,
           'eerderGerepareerd' => $request->eerderGerepareerd,
           'updated_at' => Carbon::now(),
         ]);
       }
         return DB::table('ticket')
         ->where('id', '=', $request->id)
         ->where('type', '=', 'Repair')
         ->update([
           'userID' => $request->userID,
           'handtekeningID' => 0,
           'merk' => $request->merk,
           'model' => $request->model,
           'prijs' => $request->prijs,
           'provider' => $request->provider,
           'due' => $request->due,
           'state' => $request->state,
           'schades' => $request->schades,
           'beschrijving' => $request->beschrijving,
           'eerderGerepareerd' => $request->eerderGerepareerd,
           'klantID' => $request->klantID,
           'updated_at' => Carbon::now(),
         ]);


     }
   }



}
