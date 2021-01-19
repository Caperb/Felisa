<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ContractController extends Controller
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
    public function upload(Request $request)
    {
      if (Auth::check()) {

        $exists = Storage::disk('public')->exists('contracts/'.$request->userID.'/'.$request->name);

        if ($exists == 1) {
          return 'Exists';
        }else {
          Storage::disk('public')->putFileAs('contracts/'.$request->userID, $request->file, $request->name);

        return DB::table('contract')->insert([
            'name' => $request->name,
            'size' => $request->size,
            'userID' => $request->userID,
            'created_at' => Carbon::now(),
          ]);
        }
      }
    }

    public function allContracts(Request $request)
    {
      if (Auth::check()) {
      return DB::table('contract')
      ->where('userID', '=', $request->userID)
      ->orderBy('id', 'desc')
      ->paginate(5);
      }
    }

    public function download(Request $request)
    {
      if (Auth::check()) {
    return Storage::disk('public')->download('contracts/'.$request->userID.'/'.$request->name);
      }
    }

    public function delete(Request $request)
    {
      if (Auth::check()) {
    Storage::disk('public')->delete('contracts/'.$request->userID.'/'.$request->name);

    return DB::table('contract')
    ->where('id', '=', $request->id)
    ->delete();
      }
    }


}
