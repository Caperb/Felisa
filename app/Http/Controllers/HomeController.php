<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

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

        $oldAccessTokenDate = DB::table('access_token')
        ->where('name', '=', 'instagram')
        ->value('updated_at');

        if ($oldAccessTokenDate < Carbon::now()->subDays(7)->toDateTimeString()){
          $oldAccessToken = DB::table('access_token')
          ->where('name', '=', 'instagram')
          ->value('value');

          $newAccessToken = Http::get('https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token='.$oldAccessToken);

          DB::table('access_token')
          ->where('name', '=', 'instagram')
          ->update([
            'value' => $newAccessToken['access_token'],
            'updated_at' => Carbon::now()
          ]);
        }

        //Tickets
        $activeTickets = DB::table('orders')
        ->where('deliveryStatus', '=', 'Nieuw')
        ->count();

        $newTickets = DB::table('orders')
        ->where('deliveryStatus', '=', 'Nieuw')
        ->count();

        $dueTickets = DB::table('orders')
        ->where('deliveryStatus', '=', 'Nieuw')
        ->where('created_at', '<=', Carbon::now()->subDays(7)->toDateTimeString())
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
        ->paginate(5);

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

        //Bestelling in progress

        $bestellingenInProgress =
        DB::table('orders')
        ->where('deliveryStatus', '=', 'workingOn')
        ->count();

        $dueBestellingenInProgress =
        DB::table('orders')
        ->where('deliveryStatus', '=', 'workingOn')
        ->where('updated_at', '<=', Carbon::now()->subDays(7)->toDateTimeString())
        ->count();

        //Bestelling klaar

        $bestellingenKlaar =
        DB::table('orders')
        ->where('deliveryStatus', '=', 'BestellingLigtKlaar')
        ->count();

        $dueBestellingKlaar =
        DB::table('orders')
        ->where('deliveryStatus', '=', 'BestellingLigtKlaar')
        ->where('updated_at', '<=', Carbon::now()->subDays(7)->toDateTimeString())
        ->count();

        //Bestelling klaar

        $verstuurdeBestellingen =
        DB::table('orders')
        ->where('deliveryStatus', '=', 'BestellingVerstuurd')
        ->count();


        $datumVandaag = Carbon::now();

        return [$newTickets, $dueTickets, $inProgressTickets, $waitingForDeliveryTickets, $doneTickets,
                $newOrders, $dueOrders, $inProgressOrders, $waitingForDeliveryOrders, $doneOrders,
                $newRepairs, $dueRepairs, $inProgressRepairs, $waitingForDeliveryRepairs, $doneRepairs,
                $reminders, $contracts, $datumVandaag, $activeTickets, $activeRepairs,
                $activeOrders, $activeReminders, $bestellingenInProgress, $dueBestellingenInProgress, $bestellingenKlaar,
                $dueBestellingKlaar, $verstuurdeBestellingen];

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
       $reminders = DB::table('reminders')
       ->where('done', '=', 0)
       ->orderBy('created_at', 'desc')
       ->paginate(5);

       return $reminders;
     }
   }

   public function refreshReminderCount(Request $request){
     if (Auth::check()) {
       return DB::table('reminders')
       ->where('done', '=', 0)
       ->count();
     }
   }

   // public function editContract(Request $request){
   //   if (Auth::check()) {
   //     return DB::table('klant')
   //     ->where('id', '=', $request->id)
   //     ->update([
   //       'contractStatus' => 'checked',
   //       'updated_at' => Carbon::now(),
   //     ]);
   //   }
   // }
   //
   // public function refreshContracts(Request $request)
   // {
   //   if (Auth::check()) {
   //     return DB::table('klant')
   //     ->select('voornaam', 'achternaam', 'verloopDatumAbbonement', 'contractStatus', 'id')
   //     ->where('verloopDatumAbbonement', '>', Carbon::now()->subDays(90))
   //     ->where('contractStatus', '=', null)
   //     ->orderBy('verloopDatumAbbonement', 'desc')
   //     ->paginate(7);
   //   }
   // }



}
