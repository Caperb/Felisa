<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;

class CategorieController extends Controller
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

     public function allMain(Request $request)
     {
       if (Auth::check()) {

         if ($request->searchInput == '') {

           $mainCategories = DB::table('categorie')
           ->select('id', 'naam', 'positie', 'type', 'hoofdCategorie')
           ->where('type', '=', 'main')
           ->orderBy('positie')
           ->get();

          return $mainCategories;

        }else {

          $mainCategories = DB::table('categorie')
          ->select('id', 'naam', 'positie', 'type', 'hoofdCategorie')
          ->where('type', '=', 'main')
          ->where('naam', 'like', '%' . $request->searchInput . '%')
          ->orderBy('positie')
          ->get();

         return $mainCategories;

        }


       }
     }

     public function getSubs(Request $request)
     {
       if (Auth::check()) {

          $subs = DB::table('categorie')
          ->select('id', 'naam', 'positie', 'type', 'hoofdCategorie')
          ->where('hoofdCategorie', '=', $request->id)
          ->orderBy('positie')
          ->get();

         return $subs;
       }
     }

    public function add(Request $request)
    {
      if (Auth::check()) {

        if ($request->hoofdCategorie == 'main') {

          $aantalCategorieën = DB::table('categorie')
          ->where('type', '=', $request->type)
          ->count();

        } else {
          $aantalCategorieën = DB::table('categorie')
          ->where('type', '=', $request->type)
          ->where('hoofdCategorie', '=', $request->hoofdCategorie)
          ->count();
        }


        $aantalCategorieën = $aantalCategorieën + 1;

         $categorieID = DB::table('categorie')
        ->insertGetId([
          'type' => $request->type,
          'naam' => $request->naam,
          'hoofdCategorie' => $request->hoofdCategorie,
          'positie' => $aantalCategorieën,
          'aantalSubs' => 0,
          'created_at' => Carbon::now(),
        ]);

        if ($request->type == 'secondary') {
          DB::table('categorie')
          ->where('id', '=', $request->hoofdCategorie)
          ->increment('aantalSubs');
        }

        return $categorieID;
      }
    }

    public function edit(Request $request)
    {
      if (Auth::check()) {

        $main = DB::table('categorie')
        ->where('id', '=', $request->main['id'])
        ->update(['naam' => $request->main['naam']]);

        foreach ($request->subs as $sub) {
          $subCategorieën = DB::table('categorie')
          ->where('id', '=', $sub['id'])
          ->update(['naam' => $sub['naam']]);
        }

        return $main;

      }
    }

    public function moveUp(Request $request)
    {
      if (Auth::check()) {

        $nieuwePositie = $request->positie - 1;

        if ($request->type == 'main') {

          DB::table('categorie')
          ->where('type', '=', 'main')
          ->where('positie', '=', $nieuwePositie)
          ->update(['positie' => $request->positie]);

          DB::table('categorie')
          ->where('type', '=', 'main')
          ->where('id', '=', $request->id)
          ->update(['positie' => $nieuwePositie]);


        }else {

          DB::table('categorie')
          ->where('type', '=', 'secondary')
          ->where('hoofdCategorie', '=', $request->hoofdCategorie)
          ->where('positie', '=', $nieuwePositie)
          ->update(['positie' => $request->positie]);

          DB::table('categorie')
          ->where('type', '=', 'secondary')
          ->where('hoofdCategorie', '=', $request->hoofdCategorie)
          ->where('id', '=', $request->id)
          ->update(['positie' => $nieuwePositie]);

        }



      }
    }

    public function moveDown(Request $request)
    {
      if (Auth::check()) {

        $nieuwePositie = $request->positie + 1;

        if ($request->type == 'main') {

          DB::table('categorie')
          ->where('type', '=', 'main')
          ->where('positie', '=', $nieuwePositie)
          ->update(['positie' => $request->positie]);

        return DB::table('categorie')
          ->where('type', '=', 'main')
          ->where('id', '=', $request->id)
          ->update(['positie' => $nieuwePositie]);


        }else {

          DB::table('categorie')
          ->where('type', '=', 'secondary')
          ->where('hoofdCategorie', '=', $request->hoofdCategorie)
          ->where('positie', '=', $nieuwePositie)
          ->update(['positie' => $request->positie]);

          return DB::table('categorie')
          ->where('type', '=', 'secondary')
          ->where('hoofdCategorie', '=', $request->hoofdCategorie)
          ->where('id', '=', $request->id)
          ->update(['positie' => $nieuwePositie]);

        }



      }
    }

    public function delete(Request $request)
    {
      if (Auth::check()) {

        if ($request->type == 'main') {

          DB::table('categorie')
          ->where('id', '=', $request->id)
          ->delete();

        return DB::table('categorie')
        ->where('hoofdCategorie', '=', $request->id)
        ->delete();


        }else {


          $hoofdCategorie = DB::table('categorie')
          ->where('id', '=', $request->id)
          ->pluck('hoofdCategorie');

          DB::table('categorie')
          ->where('id', '=', $hoofdCategorie)
          ->decrement('aantalSubs');

          return DB::table('categorie')
          ->where('id', '=', $request->id)
          ->delete();

        }

      }
    }
}
