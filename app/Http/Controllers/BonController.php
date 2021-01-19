<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;
use App;

class BonController extends Controller
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

    public function getBon(Request $request)
    {
      if (Auth::check()) {
        $subtotaal = $request->prijs*0.79;
        $btw = $request->prijs*0.21;

        $werknemer = DB::table('users')
        ->select('name')
        ->where('id', '=', $request->geholpenDoor)
        ->get();

        $date = Carbon::now();
        $customPaper = array(0,0,512.00,1200.00);
        $pdf = App::make('dompdf.wrapper', compact('request'));
        $pdf->loadHTML('
        <style>
        .bon{
          width: 1100px;
          height: 2700px;
          // border: solid;
          font-size: 48px;
        }

        .bon-header{
          width: 1100px;
          height: 900px;
          border-bottom-style: dashed;
          border-bottom-color: lightgray;
          border-bottom-width: 10px;
          text-align: center;
          line-height: 20px;
        }

        .bon-info{
          width: 1100px;
          height: 275px;
          border-bottom-style: dashed;
          border-bottom-color: lightgray;
          border-bottom-width: 10px;
          text-align: left;
          line-height: 20px;
        }

        .top-logo{
          width: 500px;
          margin-left: 300px;
          margin-right: 300px;
        }

        .row{
          width: 1100px;
          height: 80px;
          display: flex;
        }

        .half-row{
          width: 549px;
          margin-left: 30px;
        }

        .half-row2{
          width: 549px;
          margin-left: 550px;
        }

        .container-border{
          border-bottom-style: dashed;
          border-bottom-color: lightgray;
          border-bottom-width: 10px;
          text-align: left;
          line-height: 20px;
          width: 1100px;
        }

        .artikel-container{
          height: 180px;
        }

        .btw-container{
          height: 180px;
        }

        .totaal-container{
          height: 100px;
        }

        .betaling-container{
          height: 180px;
        }

        .footer{
          text-align: left;
          line-height: 20px;
          padding-left: 30px;
        }

        </style>
        <div class="bon">
        <div class="bon-header">
        <img src="\images\cropped-logo.png" class="top-logo">
        <p>GSM Brielle</p>
        <p>Nobelstraat 6</p>
        <p>3231BC Brielle </p>
        <p style="margin-top: 150px;">Telefoon: 0181-880231</p>
        <p>E-mail: info@gsmbrielle.nl</p>
        <p>Kamer van Koophandel: 61469645</p>
        <p>BTW-nummer: NL001571834B47</p>
        <p>IBAN-nummer: NL23INGB008082616</p>
        </div>

        <div class="bon-info">

        <div class="row">
        <div class="half-row">
        <p>Bonnummer:</p>
        </div>
        <div class="half-row2">
        <p>'.$request->id.'</p>
        </div>
        </div>

        <div class="row">
        <div class="half-row">
        <p>Datum:</p>
        </div>
        <div class="half-row2">
        <p>'.$date.'</p>
        </div>
        </div>

        <div class="row">
        <div class="half-row">
        <p>Geholpen door:</p>
        </div>
        <div class="half-row2">
        <p>'.$werknemer[0]->name.'</p>
        </div>
        </div>

        </div>

        <div class="container-border artikel-container">


        <div class="row" style="font-weight: 900;">
        <div class="half-row">
        <p>#      Artikel</p>
        </div>
        <div class="half-row2">
        <p style="float: right; margin-right: 30px;">Totaal</p>
        </div>
        </div>


        <div class="row">
        <div style="margin-left: 30px; width: 900px;">
        <p>'.$request->type.' '.$request->merk.' '.$request->model.'</p>
        </div>
        <div class="half-row2">
        <p style="float: right; margin-right: 30px;">€ '.$request->prijs.'</p>
        </div>
        </div>

        </div>

        <div class="container-border btw-container">

        <div class="row">
        <div class="half-row">
        <p>Subtotaal (excl. btw)</p>
        </div>
        <div class="half-row2">
        <p style="float: right; margin-right: 30px;">€ '.$subtotaal.'</p>
        </div>
        </div>

        <div class="row">
        <div class="half-row">
        <p>Btw (21%) over € '.$request->prijs.'</p>
        </div>
        <div class="half-row2">
        <p style="float: right; margin-right: 30px;">€ '.$btw.'</p>
        </div>
        </div>

        </div>

        <div class="container-border totaal-container">

        <div class="row">
        <div class="half-row">
        <p style="font-weight: 900;">Totaal</p>
        </div>
        <div class="half-row2">
        <p style="float: right; margin-right: 30px;">€ '.$request->prijs.'</p>
        </div>
        </div>

        </div>

        <div class="container-border betaling-container">

        <div class="row">
        <div class="half-row">
        <p style="font-weight: 900;">Betaling</p>
        </div>
        </div>

        <div class="row">
        <div class="half-row">
        <p>'.$request->betalingsType.'</p>
        </div>
        <div class="half-row2">
        <p style="float: right; margin-right: 30px;">€ '.$request->prijs.'</p>
        </div>
        </div>

        </div>

        <div style="text-align: center;">
        <p>Bedankt voor uw aankoop!</p>
        </div>

        <div class="footer">
        <p>Tevreden over de service? Laat dan een bericht</p>
        <p>achter op onze Facebook pagina:</p>
        <p>www.facebook.com/gsmbrielle</p>

        <p style="font-weight: 900; margin-top: 150px;">Algemene voorwaarden</p>
        <p>Op al onze transacties zijn onze algemene</p>
        <p>voorwaarden van toepassing</p>
        </div>

        </div>
        ')
        ->setPaper($customPaper);
        return $pdf->stream();

      }
    }




}
