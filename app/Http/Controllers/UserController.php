<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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

         return DB::table('users')
         ->select('id', 'name', 'role', 'telefoonNummer', 'email')
         ->orderBy($request->orderBy, $request->orderByType)
         ->paginate(20);

       }
     }

     public function userList(Request $request)
     {
       if (Auth::check()) {

         return DB::table('users')
         ->select('id', 'name')
         ->get();
       }
     }


    public function add(Request $request)
    {
      if (Auth::check()) {

        return DB::table('users')
        ->insert([
          'name' => $request->name,
          'role' => $request->role,
          'telefoonNummer' => $request->telefoonNummer,
          'email' => $request->email,
          'password' => Hash::make($request->password),
          'created_at' => Carbon::now(),
        ]);

      }
    }

    public function delete(Request $request)
    {
      if (Auth::check()) {

        return DB::table('users')
        ->where('id', '=', $request->id)
        ->delete();

      }
    }

    public function search(Request $request)
    {
      if (Auth::check()) {

        return DB::table('users')
        ->where('name', 'like', $request->input.'%')
        ->orWhere('id', 'like', $request->input.'%')
        ->orWhere('role', 'like', $request->input.'%')
        ->orWhere('telefoonNummer', 'like', $request->input.'%')
        ->orWhere('email', 'like', $request->input.'%')
        ->orderBy($request->orderBy, $request->orderByType)
        ->paginate(20);

      }
    }

    public function edit(Request $request)
    {
      if (Auth::check()) {

        if ($request->newPassword != ''){
          return DB::table('users')
          ->where('id', '=', $request->id)
          ->update([
            'name' => $request->name,
            'role' => $request->role,
            'telefoonNummer' => $request->telefoonNummer,
            'email' => $request->email,
            'password' => Hash::make($request->newPassword),
            'updated_at' => Carbon::now(),
          ]);
        }else {
          return DB::table('users')
          ->where('id', '=', $request->id)
          ->update([
            'name' => $request->name,
            'role' => $request->role,
            'telefoonNummer' => $request->telefoonNummer,
            'email' => $request->email,
            'updated_at' => Carbon::now(),
          ]);
        }

      }
    }
}
