<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderVerstuurd;
use App\Mail\workingOnOrder;
use Carbon\Carbon;

class BestellingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

     public function getAll(Request $request)
     {
       if (Auth::check()) {

         if ($request->input != '') {
           return DB::table('orders')
           ->where('orderID', 'like' , '%' . $request->input . '%')
           ->orWhere('status', 'like' , '%' . $request->input . '%')
           ->orWhere('deliveryStatus', 'like' , '%' . $request->input . '%')
           ->get();
         }else {
           return DB::table('orders')
           ->get();
         }

       }
     }

     public function getBestellingWithStatus(Request $request){
       if (Auth::check()) {
         if ($request->status == '') {
           return DB::table('orders')
           ->orderBy('id', 'desc')
           ->get();
         }else {
           return DB::table('orders')
           ->where('deliveryStatus', '=', $request->status)
           ->get();
         }
       }
     }

    public function getBestellingInfo(Request $request){
       if (Auth::check()) {

         $besteldeProducten = DB::table('ordered_products')
         ->where('orderID', '=', $request->bestelling)
         ->get();

         $optiesArray = array();

         foreach($besteldeProducten as $product) {
           $productOpties = DB::table('ordered_products_opties')
           ->where('orderID', '=', $request->bestelling)
           ->where('indexOfProduct', '=', $product->indexOfProduct)
           ->get();

           array_push($optiesArray, $productOpties);
         }

         $productArray = array();

         foreach($besteldeProducten as $product) {
           $productInfo = DB::table('products')
           ->where('id', '=', $product->productID)
           ->get();

           array_push($productArray, $productInfo);
         }

         return [$besteldeProducten, $optiesArray, $productArray];

       }
    }

    public function changeBestellingStatus(Request $request){

      DB::table('orders')
      ->where('id', '=', $request->id)
      ->update([
        'deliveryStatus' => $request->deliveryStatus,
        'updated_at' => Carbon::now(),
      ]);

    }

    public function changeOrderedProductStatus(Request $request){

      DB::table('ordered_products')
      ->where('id', '=', $request->id)
      ->update([
        'done' => $request->status,
      ]);

    }

    public function sendEmailWorkingOn(Request $request){

        Mail::to($request->email)->send(new workingOnOrder());

    }

    public function sendEmailOrderSend(Request $request){

        Mail::to($request->email)->send(new OrderVerstuurd());

    }
}
