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
                    'products.opties', 'products.prijs', 'products.gewicht', 'products.foto', 'products.foto2', 'products.foto3', 'categorie.naam as categorieNaam')
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
                    'products.opties', 'products.prijs', 'products.gewicht', 'products.foto', 'products.foto2', 'products.foto3', 'categorie.naam as categorieNaam')
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

          if ($request->foto2 != '') {
            $data2 = $request->foto2;
            list($type, $data2) = explode(';', $data2);
            list(, $data2)      = explode(',', $data2);
            $data2 = base64_decode($data2);

            Storage::disk('public_uploads')
            ->put($request->fotoNaam2, $data2, 'public');
          }

          if ($request->foto3 != '') {
            $data3 = $request->foto3;
            list($type, $data3) = explode(';', $data3);
            list(, $data3)      = explode(',', $data3);
            $data3 = base64_decode($data3);

            Storage::disk('public_uploads')
            ->put($request->fotoNaam3, $data3, 'public');
          }

           return DB::table('products')
           ->insert([
             'naam' => $request->naam,
             'beschrijving' => $request->beschrijving,
             'categorie' => $request->selectedCategorie,
             'subCategorie' => $request->selectedSubCategorie,
             'opties' => $request->selectedOpties,
             'prijs' => $request->prijs,
             'gewicht' => $request->gewicht,
             'foto' => '/product_fotos/'.$request->fotoNaam,
             'foto2' => '/product_fotos/'.$request->fotoNaam2,
             'foto3' => '/product_fotos/'.$request->fotoNaam3,
             'created_at' => Carbon::now(),
           ]);
       }
     }

     public function edit(Request $request)
     {
       if (Auth::check()) {

         if ($request->foto == 'none' && $request->foto2 == 'none' && $request->foto3 == 'none') {

           $product = DB::table('products')
           ->where('id', '=', $request->id)
           ->update([
             'naam' => $request->naam,
             'beschrijving' => $request->beschrijving,
             'categorie' => $request->categorie,
             'subCategorie' => $request->subCategorie,
             'opties' => $request->opties,
             'gewicht' => $request->gewicht,
             'prijs' => $request->prijs,
           ]);

         }elseif ($request->foto != 'none' && $request->foto2 == 'none' && $request->foto3 == 'none'){

           $product = DB::table('products')
           ->where('id', '=', $request->id)
           ->update([
             'naam' => $request->naam,
             'beschrijving' => $request->beschrijving,
             'categorie' => $request->categorie,
             'subCategorie' => $request->subCategorie,
             'opties' => $request->opties,
             'prijs' => $request->prijs,
             'gewicht' => $request->gewicht,
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

         }elseif ($request->foto == 'none' && $request->foto2 != 'none' && $request->foto3 == 'none'){

           $product = DB::table('products')
           ->where('id', '=', $request->id)
           ->update([
             'naam' => $request->naam,
             'beschrijving' => $request->beschrijving,
             'categorie' => $request->categorie,
             'subCategorie' => $request->subCategorie,
             'opties' => $request->opties,
             'prijs' => $request->prijs,
             'gewicht' => $request->gewicht,
             'foto2' => '/product_fotos/'.$request->newFotoNaam,
           ]);

           Storage::disk('public_uploads')
           ->delete($request->oudeFotoNaam2);

           $data = $request->foto2;
           list($type, $data) = explode(';', $data);
           list(, $data)      = explode(',', $data);
           $data = base64_decode($data);

           Storage::disk('public_uploads')
           ->put($request->newFotoNaam2, $data, 'public');

         }elseif ($request->foto == 'none' && $request->foto2 == 'none' && $request->foto3 != 'none'){

           $product = DB::table('products')
           ->where('id', '=', $request->id)
           ->update([
             'naam' => $request->naam,
             'beschrijving' => $request->beschrijving,
             'categorie' => $request->categorie,
             'subCategorie' => $request->subCategorie,
             'opties' => $request->opties,
             'prijs' => $request->prijs,
             'gewicht' => $request->gewicht,
             'foto3' => '/product_fotos/'.$request->newFotoNaam,
           ]);

           Storage::disk('public_uploads')
           ->delete($request->oudeFotoNaam3);

           $data = $request->foto3;
           list($type, $data) = explode(';', $data);
           list(, $data)      = explode(',', $data);
           $data = base64_decode($data);

           Storage::disk('public_uploads')
           ->put($request->newFotoNaam3, $data, 'public');

         }elseif ($request->foto != 'none' && $request->foto2 != 'none' && $request->foto3 == 'none'){

           $product = DB::table('products')
           ->where('id', '=', $request->id)
           ->update([
             'naam' => $request->naam,
             'beschrijving' => $request->beschrijving,
             'categorie' => $request->categorie,
             'subCategorie' => $request->subCategorie,
             'opties' => $request->opties,
             'prijs' => $request->prijs,
             'gewicht' => $request->gewicht,
             'foto' => '/product_fotos/'.$request->newFotoNaam,
             'foto2' => '/product_fotos/'.$request->newFotoNaam2,
           ]);

           Storage::disk('public_uploads')
           ->delete($request->oudeFotoNaam);

           Storage::disk('public_uploads')
           ->delete($request->oudeFotoNaam2);

           $data = $request->foto;
           list($type, $data) = explode(';', $data);
           list(, $data)      = explode(',', $data);
           $data = base64_decode($data);

           Storage::disk('public_uploads')
           ->put($request->newFotoNaam, $data, 'public');

           $data = $request->foto2;
           list($type, $data) = explode(';', $data);
           list(, $data)      = explode(',', $data);
           $data = base64_decode($data);

           Storage::disk('public_uploads')
           ->put($request->newFotoNaam2, $data, 'public');


         }elseif ($request->foto != 'none' && $request->foto2 == 'none' && $request->foto3 != 'none'){

           $product = DB::table('products')
           ->where('id', '=', $request->id)
           ->update([
             'naam' => $request->naam,
             'beschrijving' => $request->beschrijving,
             'categorie' => $request->categorie,
             'subCategorie' => $request->subCategorie,
             'opties' => $request->opties,
             'prijs' => $request->prijs,
             'gewicht' => $request->gewicht,
             'foto' => '/product_fotos/'.$request->newFotoNaam,
             'foto3' => '/product_fotos/'.$request->newFotoNaam2,
           ]);

           Storage::disk('public_uploads')
           ->delete($request->oudeFotoNaam);

           Storage::disk('public_uploads')
           ->delete($request->oudeFotoNaam3);

           $data = $request->foto;
           list($type, $data) = explode(';', $data);
           list(, $data)      = explode(',', $data);
           $data = base64_decode($data);

           Storage::disk('public_uploads')
           ->put($request->newFotoNaam, $data, 'public');

           $data = $request->foto3;
           list($type, $data) = explode(';', $data);
           list(, $data)      = explode(',', $data);
           $data = base64_decode($data);

           Storage::disk('public_uploads')
           ->put($request->newFotoNaam3, $data, 'public');


         }elseif ($request->foto == 'none' && $request->foto2 != 'none' && $request->foto3 != 'none'){

           $product = DB::table('products')
           ->where('id', '=', $request->id)
           ->update([
             'naam' => $request->naam,
             'beschrijving' => $request->beschrijving,
             'categorie' => $request->categorie,
             'subCategorie' => $request->subCategorie,
             'opties' => $request->opties,
             'prijs' => $request->prijs,
             'gewicht' => $request->gewicht,
             'foto2' => '/product_fotos/'.$request->newFotoNaam,
             'foto3' => '/product_fotos/'.$request->newFotoNaam2,
           ]);

           Storage::disk('public_uploads')
           ->delete($request->oudeFotoNaam2);

           Storage::disk('public_uploads')
           ->delete($request->oudeFotoNaam3);

           $data = $request->foto2;
           list($type, $data) = explode(';', $data);
           list(, $data)      = explode(',', $data);
           $data = base64_decode($data);

           Storage::disk('public_uploads')
           ->put($request->newFotoNaam2, $data, 'public');

           $data = $request->foto3;
           list($type, $data) = explode(';', $data);
           list(, $data)      = explode(',', $data);
           $data = base64_decode($data);

           Storage::disk('public_uploads')
           ->put($request->newFotoNaam3, $data, 'public');


         }elseif ($request->foto != 'none' && $request->foto2 != 'none' && $request->foto3 != 'none'){

           $product = DB::table('products')
           ->where('id', '=', $request->id)
           ->update([
             'naam' => $request->naam,
             'beschrijving' => $request->beschrijving,
             'categorie' => $request->categorie,
             'subCategorie' => $request->subCategorie,
             'opties' => $request->opties,
             'prijs' => $request->prijs,
             'gewicht' => $request->gewicht,
             'foto' => '/product_fotos/'.$request->newFotoNaam,
             'foto2' => '/product_fotos/'.$request->newFotoNaam2,
             'foto3' => '/product_fotos/'.$request->newFotoNaam3,
           ]);

           Storage::disk('public_uploads')
           ->delete($request->oudeFotoNaam);

           Storage::disk('public_uploads')
           ->delete($request->oudeFotoNaam2);

           Storage::disk('public_uploads')
           ->delete($request->oudeFotoNaam3);

           $data = $request->foto;
           list($type, $data) = explode(';', $data);
           list(, $data)      = explode(',', $data);
           $data = base64_decode($data);

           Storage::disk('public_uploads')
           ->put($request->newFotoNaam, $data, 'public');

           $data = $request->foto2;
           list($type, $data) = explode(';', $data);
           list(, $data)      = explode(',', $data);
           $data = base64_decode($data);

           Storage::disk('public_uploads')
           ->put($request->newFotoNaam2, $data, 'public');

           $data = $request->foto3;
           list($type, $data) = explode(';', $data);
           list(, $data)      = explode(',', $data);
           $data = base64_decode($data);

           Storage::disk('public_uploads')
           ->put($request->newFotoNaam3, $data, 'public');

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
