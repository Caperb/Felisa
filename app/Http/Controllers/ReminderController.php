<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;

class ReminderController extends Controller
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
        return DB::table('reminders')
        ->insert([
          'name' => $request->input,
          'done' => 0,
          'user' => $request->user,
          'created_at' => Carbon::now()->toDateString(),
        ]);
      }
    }

    public function getAll(Request $request)
    {
      if (Auth::check()) {

        $active = DB::table('reminders')
        ->where('done', '=', 0)
        ->orderBy('created_at', 'desc')
        ->paginate(17);

        $done = DB::table('reminders')
        ->where('done', '=', 1)
        ->orderBy('updated_at', 'desc')
        ->paginate(17);

        $recent = DB::table('reminders')
        ->orderBy('created_at', 'desc')
        ->take(10)
        ->get();

        return [$active, $done, $recent];

      }
    }

    public function getActive(Request $request)
    {
      if (Auth::check()) {

        return DB::table('reminders')
        ->where('done', '=', 0)
        ->orderBy('created_at', 'desc')
        ->paginate(17);
      }
    }

    public function getDone(Request $request)
    {
      if (Auth::check()) {

        return DB::table('reminders')
        ->where('done', '=', 1)
        ->orderBy('created_at', 'desc')
        ->paginate(17);
      }
    }


   public function delete(Request $request)
   {
     if (Auth::check()) {

       return DB::table('reminders')
       ->where('id', '=', $request->id)
       ->delete();

     }
   }

   public function edit(Request $request)
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



}
