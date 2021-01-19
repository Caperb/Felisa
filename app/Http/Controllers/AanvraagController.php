<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AanvraagController extends Controller
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
          'type' => 'Order',
          'klantID' => $request->klantID,
          'userID' => $request->userID,
          'handtekeningID' => $request->handtekeningID,
          'merk' => $request->merk,
          'model' => $request->model,
          'prijs' => $request->prijs,
          'contractType' => $request->contractType,
          'provider' => $request->provider,
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

        $data = $request->handtekening;
        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);
        $data = base64_decode($data);

        Storage::disk('public')
        ->put('/handtekeningen\/'.$request->userID.'/'.$orderID.'.png', $data, 'private');


        return $orderID;
      }
    }



}
