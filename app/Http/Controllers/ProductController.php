<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
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
           return DB::table('products')
           ->select('products.id', 'products.naam', 'products.beschrijving', 'products.categorie', 'products.subCategorie',
                    'products.opties', 'products.prijs', 'products.foto', 'categorie.naam as categorieNaam')
           ->orderBy('id', 'desc')
           ->where('products.id', 'like', '%'.$request->input.'%')
           ->orWhere('products.naam', 'like', '%'.$request->input.'%')
           ->orWhere('categorie.naam', 'like', '%'.$request->input.'%')
           ->orWhere('products.prijs', 'like', '%'.$request->input.'%')
           ->leftJoin('categorie', 'products.categorie', '=', 'categorie.id')
           ->get();

         }else {

           return DB::table('products')
           ->select('products.id', 'products.naam', 'products.beschrijving', 'products.categorie', 'products.subCategorie',
                    'products.opties', 'products.prijs', 'products.foto', 'categorie.naam as categorieNaam')
           ->orderBy('id', 'desc')
           ->leftJoin('categorie', 'products.categorie', '=', 'categorie.id')
           ->get();

         }



       }
     }

     public function add(Request $request)
     {
       if (Auth::check()) {

         // return $request;

          $data = $request->foto;
          list($type, $data) = explode(';', $data);
          list(, $data)      = explode(',', $data);
          $data = base64_decode($data);

          Storage::disk('public_uploads')
          ->put($request->fotoNaam, $data, 'public');



           return DB::table('products')
           ->insert([
             'naam' => $request->naam,
             'beschrijving' => $request->beschrijving,
             'categorie' => $request->selectedCategorie,
             'subCategorie' => $request->selectedSubCategorie,
             'opties' => $request->selectedOpties,
             'prijs' => $request->prijs,
             'foto' => '/product_fotos/'.$request->fotoNaam,
             'created_at' => Carbon::now(),
           ]);

       }
     }

     public function edit(Request $request)
     {
       if (Auth::check()) {

         if ($request->foto == 'none') {

           $product = DB::table('products')
           ->where('id', '=', $request->id)
           ->update([
             'naam' => $request->naam,
             'beschrijving' => $request->beschrijving,
             'categorie' => $request->categorie,
             'subCategorie' => $request->subCategorie,
             'opties' => $request->opties,
             'prijs' => $request->prijs,
           ]);

         }else {

           $product = DB::table('products')
           ->where('id', '=', $request->id)
           ->update([
             'naam' => $request->naam,
             'beschrijving' => $request->beschrijving,
             'categorie' => $request->categorie,
             'subCategorie' => $request->subCategorie,
             'opties' => $request->opties,
             'prijs' => $request->prijs,
             'foto' => '/product_fotos/'.$request->newFotoNaam,
           ]);

           Storage::disk('public_uploads')
           ->delete($request->oudeFotoNaam);

           $data = $request->foto;
           list($type, $data) = explode(';', $data);
           list(, $data)      = explode(',', $data);
           $data = base64_decode($data);

           Storage::disk('public_uploads')
           ->put($request->newFotoNaam, $data, 'public');

         }

           return $product;

       }
     }

     public function delete(Request $request)
     {
       if (Auth::check()) {

           $product = DB::table('products')
           ->where('id', '=', $request->id)
           ->delete();

           Storage::disk('public_uploads')
           ->delete($request->foto);

           return $product;

       }
     }

     public function getHomeProducts(Request $request)
     {
           return DB::table('products')
           ->orderBy('created_at', 'desc')
           ->take(8)
           ->get();
     }


}
