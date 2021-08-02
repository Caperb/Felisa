<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use DB;

class HappyCustomerController extends Controller
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


     public function get(Request $request)
     {

         if ($request->searchInput == '') {
           return DB::table('happy_customers')
           ->orderBy('id', 'desc')
           ->get();
         }else {
           return DB::table('happy_customers')
           ->where('id', 'like', '%'.$request->searchInput.'%')
           ->orWhere('naam', 'like', '%'.$request->searchInput.'%')
           ->orWhere('type', 'like', '%'.$request->searchInput.'%')
           ->orWhere('fotoNaam', 'like', '%'.$request->searchInput.'%')
           ->orWhere('tekst', 'like', '%'.$request->searchInput.'%')
           ->get();
         }
       }

     public function getHome(Request $request)
     {
           $tekstHappyCustomers = DB::table('happy_customers')
           ->where('type', '=', 'tekst')
           ->orderBy('id', 'desc')
           ->take(2)
           ->get();

           $fotoHappyCustomers = DB::table('happy_customers')
           ->where('type', '=', 'foto')
           ->orderBy('id', 'desc')
           ->take(2)
           ->get();

           return [$tekstHappyCustomers, $fotoHappyCustomers];
     }


    public function add(Request $request)
    {
      if (Auth::check()) {

        return DB::table('happy_customers')
        ->insert([
          'naam' => $request->naam,
          'tekst' => $request->tekst,
          'type' => $request->type,
        ]);

      }
    }

    public function addPicture(Request $request)
    {
      if (Auth::check()) {

        $data = $request->foto;
        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);
        $data = base64_decode($data);

        Storage::disk('public_uploads')
        ->put($request->fotoNaam, $data, 'public');

        return DB::table('happy_customers')
        ->insert([
          'naam' => $request->naam,
          'tekst' => $request->tekst,
          'type' => $request->type,
          'fotoNaam' => '/product_fotos/'.$request->fotoNaam,
        ]);

      }
    }

    public function delete(Request $request)
    {
      if (Auth::check()) {

        $fotoNaam = str_replace('/product_fotos/', '' , $request->fotoNaam);

        Storage::disk('public_uploads')
        ->delete($fotoNaam);

        return DB::table('happy_customers')
        ->where('id', '=', $request->id)
        ->delete();

      }
    }



}
