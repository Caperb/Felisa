<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;

class HomeController extends Controller
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

        //Tickets
        $activeTickets = DB::table('ticket')
        ->where('state', '=', 'Nieuw')
        ->orWhere(function($query) {
          $query->orWhere('state', '=','Due')
                ->orWhere('state', '=', 'In progress')
                ->orWhere('state', '=', 'Waiting for delivery');
                })
        ->count();

        $newTickets = DB::table('ticket')
        ->where('state', '=', 'Nieuw')
        ->count();

        $dueTickets = DB::table('ticket')
        ->where('state', '=', 'Due')
        ->count();

        $inProgressTickets = DB::table('ticket')
        ->where('state', '=', 'In progress')
        ->count();

        $waitingForDeliveryTickets = DB::table('ticket')
        ->where('state', '=', 'Waiting for delivery')
        ->count();

        $doneTickets = DB::table('ticket')
        ->where('state', '=', 'Done')
        ->count();

        //Repairs

        $activeRepairs = DB::table('ticket')
        ->where('type', '=', 'Repair')
        ->orWhere(function($query) {
          $query->Where('state', '=','Due')
                ->Where('state', '=', 'In progress')
                ->Where('state', '=', 'Nieuw')
                ->Where('state', '=', 'Waiting for delivery');
                })
        ->count();

        $newRepairs = DB::table('ticket')
        ->where('type', '=', 'Repair')
        ->where('state', '=', 'Nieuw')
        ->count();

        $dueRepairs = DB::table('ticket')
        ->where('type', '=', 'Repair')
        ->where('state', '=', 'Due')
        ->count();

        $inProgressRepairs = DB::table('ticket')
        ->where('type', '=', 'Repair')
        ->where('state', '=', 'In progress')
        ->count();

        $waitingForDeliveryRepairs = DB::table('ticket')
        ->where('type', '=', 'Repair')
        ->where('state', '=', 'Waiting for delivery')
        ->count();

        $doneRepairs = DB::table('ticket')
        ->where('type', '=', 'Repair')
        ->where('state', '=', 'Done')
        ->count();

        //Orders

        $activeOrders = DB::table('ticket')
        ->where('type', '=', 'Order')
        ->orWhere(function($query) {
          $query->Where('state', '=','Due')
                ->Where('state', '=', 'In progress')
                ->Where('state', '=', 'Nieuw')
                ->Where('state', '=', 'Waiting for delivery');
                })
        ->count();

        $newOrders = DB::table('ticket')
        ->where('type', '=', 'Order')
        ->where('state', '=', 'Nieuw')
        ->count();

        $dueOrders = DB::table('ticket')
        ->where('type', '=', 'Order')
        ->where('state', '=', 'Due')
        ->count();

        $inProgressOrders = DB::table('ticket')
        ->where('type', '=', 'Order')
        ->where('state', '=', 'In progress')
        ->count();

        $waitingForDeliveryOrders = DB::table('ticket')
        ->where('type', '=', 'Order')
        ->where('state', '=', 'Waiting for delivery')
        ->count();

        $doneOrders = DB::table('ticket')
        ->where('type', '=', 'Order')
        ->where('state', '=', 'Done')
        ->count();

        //Reminders

        $reminders = DB::table('reminders')
        ->where('done', '=', 0)
        ->orderBy('created_at', 'asc')
        ->paginate(7);

        $activeReminders = DB::table('reminders')
        ->where('done', '=', 0)
        ->count();

        //Contracts

        $contracts = DB::table('klant')
        ->select('voornaam', 'achternaam', 'verloopDatumAbbonement', 'contractStatus', 'id')
        ->where('verloopDatumAbbonement', '>', Carbon::now()->subDays(90))
        ->where('contractStatus', '=', null)
        ->orderBy('verloopDatumAbbonement', 'asc')
        ->paginate(7);

        $datumVandaag = Carbon::now();

        return [$newTickets, $dueTickets, $inProgressTickets, $waitingForDeliveryTickets, $doneTickets, $newOrders, $dueOrders,
        $inProgressOrders, $waitingForDeliveryOrders, $doneOrders, $newRepairs, $dueRepairs, $inProgressRepairs,
        $waitingForDeliveryRepairs, $doneRepairs, $reminders, $contracts, $datumVandaag, $activeTickets, $activeRepairs, $activeOrders, $activeReminders];

      }
    }


   public function editReminder(Request $request)
   {
     if (Auth::check()) {
         return DB::table('reminders')
         ->where('id', '=', $request->id)
         ->update([
           'done' => 1,
           'updated_at' => Carbon::now(),
         ]);
     }
   }

   public function refreshReminders(Request $request)
   {
     if (Auth::check()) {
       return DB::table('reminders')
       ->where('done', '=', 0)
       ->orderBy('created_at', 'desc')
       ->paginate(7);
     }
   }

   public function editContract(Request $request){
     if (Auth::check()) {
       return DB::table('klant')
       ->where('id', '=', $request->id)
       ->update([
         'contractStatus' => 'checked',
         'updated_at' => Carbon::now(),
       ]);
     }
   }

   public function refreshContracts(Request $request)
   {
     if (Auth::check()) {
       return DB::table('klant')
       ->select('voornaam', 'achternaam', 'verloopDatumAbbonement', 'contractStatus', 'id')
       ->where('verloopDatumAbbonement', '>', Carbon::now()->subDays(90))
       ->where('contractStatus', '=', null)
       ->orderBy('verloopDatumAbbonement', 'desc')
       ->paginate(7);
     }
   }



}
