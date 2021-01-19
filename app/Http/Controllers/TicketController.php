<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;

class TicketController extends Controller
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
        ->select('ticket.merk', 'ticket.model', 'ticket.provider', 'ticket.contractType', 'ticket.prijs', 'ticket.provider', 'ticket.KlantID', 'ticket.userID', 'ticket.type',
        'ticket.due', 'ticket.state', 'ticket.id', 'ticket.schades', 'ticket.beschrijving', 'ticket.eerderGerepareerd', 'ticket.created_at', 'klant.voornaam', 'klant.tussenvoegsel', 'klant.achternaam')
        ->join('klant', 'ticket.klantID', '=', 'klant.id')
        ->orderBy($request->orderBy, $request->orderByType)
        ->get();

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
       ->select('ticket.merk', 'ticket.model', 'ticket.provider', 'ticket.contractType', 'ticket.prijs', 'ticket.provider', 'ticket.KlantID', 'ticket.userID', 'ticket.type',
       'ticket.due', 'ticket.state', 'ticket.id', 'ticket.schades', 'ticket.beschrijving', 'ticket.eerderGerepareerd', 'ticket.created_at', 'klant.voornaam', 'klant.tussenvoegsel', 'klant.achternaam')
       ->join('klant', 'ticket.klantID', '=', 'klant.id')
       ->where(function ($query) use ($request) {
              $query->where('klant.voornaam', 'like', $request->input.'%')
              ->orWhere('klant.achternaam', 'like', $request->input.'%')
              ->orWhere('ticket.id', 'like', $request->input.'%')
              ->orWhere('ticket.type', 'like', $request->input.'%')
              ->orWhere('ticket.created_at', 'like', $request->input.'%')
              ->orWhere('ticket.due', 'like', $request->input.'%')
              ->orWhere('ticket.state', 'like', $request->input.'%');
          })
       ->orderBy($request->orderBy, $request->orderByType)
       ->paginate(20);
     }
   }



}
