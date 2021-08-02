<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderVerwerkt;
use Mollie\Laravel\Facades\Mollie;
use Carbon\Carbon;

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

public function preparePayment(Request $request)
{
    $orderID = DB::table('sequence')
    ->where('name', '=', 'order')
    ->value('value');

    DB::table('sequence')
    ->where('name', '=', 'order')
    ->increment('value');

    $payment = Mollie::api()->payments->create([
        "amount" => [
            "currency" => "EUR",
            "value" => $request->prijs // You must send the correct number of decimals, thus we enforce the use of strings
        ],
        "description" => "Order #" . $orderID,
        "redirectUrl" => 'https://felisa.verenmanta.com/aankoop-gelukt',
        "webhookUrl" => 'https://felisa.verenmanta.com/mollie-webhook',
        "metadata" => [
            "order_id" => $orderID,
        ],
    ]);

    $indexOfProduct = 0;
    foreach ($request->cart as $product) {
      DB::table('ordered_products')
      ->insert([
        'orderID' => $orderID,
        'productID' => $product['id'],
        'indexOfProduct' => $indexOfProduct,
        'amount' => $product['aantalVanProduct'],
        'weight' => $product['gewicht'],
      ]);
      $indexOfProduct = $indexOfProduct + 1;
    }

    $indexOfProduct = 0;
    foreach ($request->opties as $optie) {
      foreach ($optie as $keuze) {
        if (is_array($keuze['value'])) {
          DB::table('ordered_products_opties')
          ->insert([
            'orderID' => $orderID,
            'productID' => $keuze['id'],
            'indexOfProduct' => $indexOfProduct,
            'naam' => $keuze['naam'],
            'value' => implode(", ",$keuze['value']),
          ]);
        }else{
          DB::table('ordered_products_opties')
          ->insert([
            'orderID' => $orderID,
            'productID' => $keuze['id'],
            'indexOfProduct' => $indexOfProduct,
            'naam' => $keuze['naam'],
            'value' => $keuze['value'],
          ]);
        }
      }
      $indexOfProduct = $indexOfProduct + 1;
    }

    DB::table('orders')
    ->insert([
      'orderID' => $orderID,
      'status' => 'Open',
      'deliveryStatus' => 'Nieuw',
      'naam' => $request->verzendInfo['naam'],
      'email' => $request->verzendInfo['email'],
      'adres' => $request->verzendInfo['adres'],
      'postcode' => $request->verzendInfo['postcode'],
      'plaats' => $request->verzendInfo['plaats'],
      'land' => $request->verzendInfo['land'],
      'created_at' => Carbon::now(),
    ]);

    // Return Mollie checkout page
    return $payment->getCheckoutUrl();
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
    $orderId = $payment->metadata->order_id;

    if ($payment->isPaid() && ! $payment->hasRefunds() && ! $payment->hasChargebacks()) {

      DB::table('orders')
      ->where('orderID', '=', $orderID)
      ->update([
        'status' => 'Betaald',
        'paymentID' => $paymentId,
    ]);

    $email = DB::table('orders')
             ->where('orderID', '=', $orderID)
             ->value('email');

   $producten = DB::table('ordered_products')
              ->select('ordered_products.productID', 'ordered_products.amount', 'products.naam')
              ->leftJoin('products', 'ordered_products.productID', '=', 'products.ID')
              ->where('orderID', '=', $orderID)
              ->get();

    Mail::to($email)->send(new OrderVerwerkt($orderID, $producten));

  } elseif ($payment->isOpen()) {

    DB::table('orders')
    ->where('orderID', '=', $orderID)
    ->update([
      'status' => 'Open',
  ]);

  } elseif ($payment->isPending()) {

    DB::table('orders')
    ->where('orderID', '=', $orderID)
    ->update([
      'status' => 'In afwachting',
  ]);

  } elseif ($payment->isFailed()) {

    DB::table('orders')
    ->where('orderID', '=', $orderID)
    ->update([
      'status' => 'Betaling mislukt',
  ]);

  } elseif ($payment->isExpired()) {

    DB::table('orders')
    ->where('orderID', '=', $orderID)
    ->update([
      'status' => 'Verlopen',
  ]);

  } elseif ($payment->isCanceled()) {

    DB::table('orders')
    ->where('orderID', '=', $orderID)
    ->update([
      'status' => 'Geannuleerd',
  ]);

  } elseif ($payment->hasRefunds()) {

    DB::table('orders')
    ->where('orderID', '=', $orderID)
    ->update([
      'status' => 'Heeft terugboeking',
  ]);

  } elseif ($payment->hasChargebacks()) {

    DB::table('orders')
    ->where('orderID', '=', $orderID)
    ->update([
      'status' => 'Heeft terugboeking',
  ]);

  }
}

public function refund(Request $request){

  if (Auth::check()) {
    $payment = $mollie->payments->get($request->paymentID);

    DB::table('orders')
    ->where('paymentID', '=', $request->paymentID)
    ->update([
      'refunded' => $request->amount,
      'status' => 'Refunded',
    ]);

    // Refund € 2 of this payment
    $refund = $payment->refund([
        "amount" => [
            "currency" => "EUR",
            "value" => $request->amount
        ]
    ]);
  }
}



}
