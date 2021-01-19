<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class KlantController extends Controller
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

         return DB::table('klant')
         ->orderBy($request->orderBy, $request->orderByType)
         ->paginate(20);

       }
     }

    public function add(Request $request)
    {
      if (Auth::check()) {


        return DB::table('klant')
        ->insert([
          'voornaam' => $request->voornaam,
          'tussenvoegsel' => $request->tussenvoegsel,
          'achternaam' => $request->achternaam,
          'telefoonNummer' => $request->telefoonNummer,
          'emailAdres' => $request->emailAdres,
          'postcode' => $request->postcode,
          'huisNummer' => $request->huisNummer,
          'created_at' => Carbon::now(),
        ]);

      }
    }

    public function delete(Request $request)
    {
      if (Auth::check()) {

        // return Storage::disk('public')->allDirectories();

        Storage::disk('public')->deleteDirectory('/handtekeningen\/'.$request->userID);

        Storage::disk('public')->deleteDirectory('/contracts\/'.$request->userID);

        DB::table('contract')
        ->where('userID', '=', $request->id)
        ->delete();

        DB::table('ticket')
        ->where('klantID', '=', $request->id)
        ->delete();

        return DB::table('klant')
        ->where('id', '=', $request->id)
        ->delete();

      }
    }

    public function search(Request $request)
    {
      if (Auth::check()) {
        if ($request->nameInput == '') {
          return DB::table('klant')
          ->where('telefoonnummer', 'like', $request->numberInput.'%')
          ->get();
        }elseif ($request->numberInput == '') {
          return DB::table('klant')
          ->where('voornaam', 'like', $request->nameInput.'%')
          ->orWhere('achternaam', 'like', $request->nameInput.'%')
          ->get();
        }else {
          return DB::table('klant')
          ->where('voornaam', 'like', $request->nameInput.'%')
          ->orWhere('achternaam', 'like', $request->nameInput.'%')
          ->orWhere('telefoonnummer', 'like', $request->numberInput.'%')
          ->get();
        }
      }
    }

    public function dashboardSearch(Request $request)
    {
      if (Auth::check()) {

        if ($request->input != '') {
          $input = $request->input.'%';
          return DB::table('klant')
          ->where('voornaam', 'like', $input)
          ->orWhere('achternaam', 'like', $input)
          ->orWhere('telefoonnummer', 'like', $input)
          ->orWhere('id', 'like', $input)
          ->orWhere('emailAdres', 'like', $input)
          ->orWhere('geboortedatum', 'like', $input)
          ->orderBy($request->orderBy, $request->orderByType)
          ->paginate(20);
        }else {
          return DB::table('klant')
          ->orderBy($request->orderBy, $request->orderByType)
          ->paginate(20);
        }
      }
    }

    public function edit(Request $request)
    {
      if (Auth::check()) {

        return DB::table('klant')
        ->where('id', '=', $request->id)
        ->update([
          'IDnummer' => $request->IDnummer,
          'IBAN' => $request->IBAN,
          'aanschafdatum' => $request->aanschafdatum,
          'achternaam' => $request->achternaam,
          'afgeslotenViaOns' => $request->afgeslotenViaOns,
          'contractType' => $request->contractType,
          'duurAbbonement' => $request->duurAbbonement,
          'emailAdres' => $request->emailAdres,
          'geboortedatum' => $request->geboortedatum,
          'huisNummer' => $request->huisNummer,
          'maandelijkseKosten' => $request->maandelijkseKosten,
          'merk' => $request->merk,
          'model' => $request->model,
          'postcode' => $request->postcode,
          'provider' => $request->provider,
          'soortID' => $request->soortID,
          'telefoonNummer' => $request->telefoonNummer,
          'tussenvoegsel' => $request->tussenvoegsel,
          'uitgeefDatumAbbonement' => $request->uitgeefDatumAbbonement,
          'updated_at' => Carbon::now(),
          'verloopDatumAbbonement' => $request->verloopDatumAbbonement,
          'voornaam' => $request->voornaam,
          'contractStatus' => $request->contractStatus,
        ]);

      }
    }

    public function dashboardAdd(Request $request){
      if (Auth::check()) {

        $positionT = strpos($request->geboortedatum, "T");
        $date = substr($request->geboortedatum, 0, $positionT);
        $time = substr($request->geboortedatum, $positionT+1, 8);
        $dateTimeGeboorteDatum = $date.' '.$time;

        $positionT = strpos($request->uitgeefDatumAbbonement, "T");
        $date = substr($request->uitgeefDatumAbbonement, 0, $positionT);
        $time = substr($request->uitgeefDatumAbbonement, $positionT+1, 8);
        $dateTimeUitgeefDatumAbbonement = $date.' '.$time;

        $positionT = strpos($request->aanschafdatum, "T");
        $date = substr($request->aanschafdatum, 0, $positionT);
        $time = substr($request->aanschafdatum, $positionT+1, 8);
        $dateTimeAanschafdatum = $date.' '.$time;

        $positionT = strpos($request->verloopDatumAbbonement, "T");
        $date = substr($request->verloopDatumAbbonement, 0, $positionT);
        $time = substr($request->verloopDatumAbbonement, $positionT+1, 8);
        $dateTimeVerloopDatumAbbonement = $date.' '.$time;

        return DB::table('klant')
        ->insert([
          'IDnummer' => $request->IDnummer,
          'IBAN' => $request->IBAN,
          'aanschafdatum' => $dateTimeAanschafdatum,
          'achternaam' => $request->achternaam,
          'afgeslotenViaOns' => $request->afgeslotenViaOns,
          'contractType' => $request->contractType,
          'duurAbbonement' => $request->duurAbbonement,
          'emailAdres' => $request->emailAdres,
          'geboortedatum' => $dateTimeGeboorteDatum,
          'huisNummer' => $request->huisNummer,
          'maandelijkseKosten' => $request->maandelijkseKosten,
          'merk' => $request->merk,
          'model' => $request->model,
          'postcode' => $request->postcode,
          'provider' => $request->provider,
          'soortID' => $request->soortID,
          'telefoonNummer' => $request->telefoonNummer,
          'uitgeefDatumAbbonement' => $dateTimeUitgeefDatumAbbonement,
          'created_at' => Carbon::now(),
          'verloopDatumAbbonement' => $dateTimeVerloopDatumAbbonement,
          'voornaam' => $request->voornaam,
        ]);

      }
    }



}
