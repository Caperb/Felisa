<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;

class OrderController extends Controller
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

     public function getAll(Request $request)
     {
       if (Auth::check()) {

         return DB::table('ticket')
         ->select('ticket.merk', 'ticket.model', 'ticket.contractType', 'ticket.provider', 'ticket.prijs', 'ticket.KlantID', 'ticket.userID',
         'ticket.due', 'ticket.state', 'ticket.id', 'ticket.created_at', 'klant.voornaam', 'klant.tussenvoegsel', 'klant.achternaam')
         ->join('klant', 'ticket.klantID', '=', 'klant.id')
         ->where('type', '=', 'Order')
         ->orderBy($request->orderBy, $request->orderByType)
         ->paginate(20);

       }
     }

    public function add(Request $request)
    {
      if (Auth::check()) {

        $positionT = strpos($request->due, "T");
        $date = substr($request->due, 0, $positionT);
        $time = substr($request->due, $positionT+1, 8);
        $datetime = $date.' '.$time;

         $orderID = DB::table('ticket')
        ->insertGetId([
          'type' => 'Order',
          'klantID' => $request->klantID,
          'userID' => $request->geholpenDoor,
          'handtekeningID' => 0,
          'merk' => $request->merk,
          'model' => $request->model,
          'prijs' => $request->prijs,
          'contractType' => $request->contractType,
          'provider' => $request->provider,
          'due' => $datetime,
          'state' => $request->state,
          'created_at' => Carbon::now(),
        ]);

        foreach ($request->extraArtikelen as $extraArtikel) {

          DB::table('extra_artikelen')
          ->insert([
            'orderID' => $orderID,
            'naam' => $extraArtikel['naam'],
            'prijs' => $extraArtikel['prijs'],
          ]);

        }

        return $orderID;
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
        ->select('ticket.merk', 'ticket.model', 'ticket.contractType', 'ticket.provider', 'ticket.prijs', 'ticket.KlantID', 'ticket.userID',
        'ticket.due', 'ticket.state', 'ticket.id', 'ticket.created_at', 'klant.voornaam', 'klant.tussenvoegsel', 'klant.achternaam')
        ->join('klant', 'ticket.klantID', '=', 'klant.id')
        ->where('type', '=', 'Order')
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

        $positionT = strpos($request->due, "T");
        $date = substr($request->due, 0, $positionT);
        $time = substr($request->due, $positionT+1, 8);
        $datetime = $date.' '.$time;

        if (isset($request->klantID)) {
          $ticket = DB::table('ticket')
          ->where('id', '=', $request->id)
          ->where('type', '=', 'Order')
          ->update([
            'handtekeningID' => 0,
            'merk' => $request->merk,
            'model' => $request->model,
            'prijs' => $request->prijs,
            'contractType' => $request->contractType,
            'provider' => $request->provider,
            'due' => $datetime,
            'state' => $request->state,
            'klantID' => $request->klantID,
            'updated_at' => Carbon::now(),
          ]);
        }else {
          $ticket = DB::table('ticket')
          ->where('id', '=', $request->id)
          ->where('type', '=', 'Order')
          ->update([
            'handtekeningID' => 0,
            'merk' => $request->merk,
            'model' => $request->model,
            'prijs' => $request->prijs,
            'contractType' => $request->contractType,
            'provider' => $request->provider,
            'due' => $datetime,
            'state' => $request->state,
            'updated_at' => Carbon::now(),
          ]);
        }


          foreach ($request->extraArtikelen as $extraArtikel) {

            if (isset($extraArtikel['id'])) {

              DB::table('extra_artikelen')
              ->where('id', '=', $extraArtikel['id'])
              ->update([
                'naam' => $extraArtikel['naam'],
                'prijs' => $extraArtikel['prijs'],
              ]);
            }else {

              DB::table('extra_artikelen')
              ->insert([
                'orderID' => $request->id,
                'naam' => $extraArtikel['naam'],
                'prijs' => $extraArtikel['prijs'],
              ]);
            }
          }

          return $ticket;
      }
    }

    public function getArtikelen(Request $request){
      if (Auth::check()) {
        return DB::table('extra_artikelen')
        ->where('orderID', '=', $request->id)
        ->get();
      }
    }
}
