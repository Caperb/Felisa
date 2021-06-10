<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Mail;
use Mollie\Laravel\Facades\Mollie;

class ShopController extends Controller
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

     public function searchProducts(Request $request){

       return DB::table('products')
       ->where('categorie', '=', $request->main)
       ->orWhere('subCategorie', '=', $request->sub)
       ->orderBy('created_at', 'desc')
       ->get();

     }

     public function getAllProducts()
     {
         return DB::table('products')
         ->orderBy('created_at', 'desc')
         ->get();
     }

     public function getAllCategories()
     {
         return DB::table('categorie')
         ->where('type', '=', 'main')
         ->orderBy('positie', 'asc')
         ->get();
     }

     public function getAllSubCategories()
     {
         return DB::table('categorie')
         ->where('type', '=', 'secondary')
         ->orderBy('positie', 'asc')
         ->get();
     }

     public function getCategorieName(Request $request){

       return DB::table('categorie')
       ->where('id', '=', $request->id)
       ->pluck('naam');

     }

     public function getKeuzeOpties(Request $request){

       $allOpties = array();

       foreach ($request->id as $id) {
         $opties = DB::table('opties')
         ->where('opties.id', '=', $id)
         ->leftJoin('keuze_opties', 'opties.id', '=', 'keuze_opties.optieID')
         ->get();
         array_push($allOpties, $opties);
       }

       return $allOpties;

     }

     public function getRelatedProducts(Request $request){

       $subCategorie = DB::table('products')
       ->where('id', '!=', $request->id)
       ->where('categorie', '=', $request->categorie)
       ->where('subCategorie', '=', $request->subCategorie)
       ->take(4)
       ->get();

       if (count($subCategorie) == 4) {
         return $subCategorie;
       }else {
         $categorie = DB::table('products')
         ->where('id', '!=', $request->id)
         ->where('categorie', '=', $request->categorie)
         ->take(4)
         ->get();
       }

       if (count($categorie) == 4) {
         return $categorie;
       }else {
         return DB::table('products')
         ->where('id', '!=', $request->id)
         ->take(4)
         ->get();
       }


     }

public function preparePayment()
{
    $payment = Mollie::api()->payments->create([
        "amount" => [
            "currency" => "EUR",
            "value" => "10.00" // You must send the correct number of decimals, thus we enforce the use of strings
        ],
        "description" => "Order #12345",
        "redirectUrl" => 'https://felisa.verenmanta.com/',
        "webhookUrl" => 'https://felisa.verenmanta.com/mollie-webhook',
        "metadata" => [
            "order_id" => "12345",
        ],
    ]);

    // redirect customer to Mollie checkout page
    return redirect($payment->getCheckoutUrl(), 303);
}

/**
 * After the customer has completed the transaction,
 * you can fetch, check and process the payment.
 * This logic typically goes into the controller handling the inbound webhook request.
 * See the webhook docs in /docs and on mollie.com for more information.
 */
public function handleWebhookNotification(Request $request) {
    $paymentId = $request->input('id');
    $payment = Mollie::api()->payments->get($paymentId);

    if ($payment->isPaid())
    {
        echo 'Payment received.';
        // Do your thing ...
    }
}



}
