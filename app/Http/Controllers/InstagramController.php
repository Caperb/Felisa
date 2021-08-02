<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class InstagramController extends Controller
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

     public function getNewPictures(Request $request)
     {
       $normalTimeLimit = ini_get('max_execution_time');
       ini_set('max_execution_time', 600);

       $accessToken = DB::table('access_token')
       ->where('name', '=', 'instagram')
       ->value('value');

       $allDataResponse = Http::get('https://graph.instagram.com/me/media?fields=id,caption&access_token='.$accessToken);
       $pictureArray = array();
       $pictureLinkArray = array();

       $a = 0;

       for ($x = 0; $x <= 5; $x++) {
         sleep(10);
         $pictureData = Http::get('https://graph.instagram.com/'.$allDataResponse['data'][$a]['id'].'?fields=id,media_type,media_url,username,timestamp&access_token='.$accessToken);

         if ($pictureData['media_type'] == "IMAGE") {
           array_push($pictureArray, $pictureData['media_url']);
         }else {
           $x = $x -1;
         }

         $a++;
       }

        ini_set('max_execution_time', $normalTimeLimit);

       return $pictureArray;
       }

     public function getCurrentPictures(){

       $homeFile = file_get_contents('../resources/js/Layouts/homepage/Home.vue');

       $startEdit = strrpos($homeFile, '<!-- Instagram foto 1 -->');
       $endEdit = strrpos($homeFile, '<!-- Einde instagram foto 1 -->');
       $editLength = $endEdit - $startEdit;
       $editString = substr($homeFile, $startEdit, $editLength);
       $editedFirstPartString = str_replace("<!-- Instagram foto 1 -->\r\n      <img src=\"","", $editString);
       $instagramFoto1 = str_replace("\" alt=\"\">\r\n      ","", $editedFirstPartString);

       $startEdit = strrpos($homeFile, '<!-- Instagram foto 2 -->');
       $endEdit = strrpos($homeFile, '<!-- Einde instagram foto 2 -->');
       $editLength = $endEdit - $startEdit;
       $editString = substr($homeFile, $startEdit, $editLength);
       $editedFirstPartString = str_replace("<!-- Instagram foto 2 -->\r\n      <img src=\"","", $editString);
       $instagramFoto2 = str_replace("\" alt=\"\">\r\n      ","", $editedFirstPartString);

       $startEdit = strrpos($homeFile, '<!-- Instagram foto 3 -->');
       $endEdit = strrpos($homeFile, '<!-- Einde instagram foto 3 -->');
       $editLength = $endEdit - $startEdit;
       $editString = substr($homeFile, $startEdit, $editLength);
       $editedFirstPartString = str_replace("<!-- Instagram foto 3 -->\r\n      <img src=\"","", $editString);
       $instagramFoto3 = str_replace("\" alt=\"\">\r\n      ","", $editedFirstPartString);

       $startEdit = strrpos($homeFile, '<!-- Instagram foto 4 -->');
       $endEdit = strrpos($homeFile, '<!-- Einde instagram foto 4 -->');
       $editLength = $endEdit - $startEdit;
       $editString = substr($homeFile, $startEdit, $editLength);
       $editedFirstPartString = str_replace("<!-- Instagram foto 4 -->\r\n      <img src=\"","", $editString);
       $instagramFoto4 = str_replace("\" alt=\"\">\r\n      ","", $editedFirstPartString);

       $startEdit = strrpos($homeFile, '<!-- Instagram foto 5 -->');
       $endEdit = strrpos($homeFile, '<!-- Einde instagram foto 5 -->');
       $editLength = $endEdit - $startEdit;
       $editString = substr($homeFile, $startEdit, $editLength);
       $editedFirstPartString = str_replace("<!-- Instagram foto 5 -->\r\n      <img src=\"","", $editString);
       $instagramFoto5 = str_replace("\" alt=\"\">\r\n      ","", $editedFirstPartString);

       $startEdit = strrpos($homeFile, '<!-- Instagram foto 6 -->');
       $endEdit = strrpos($homeFile, '<!-- Einde instagram foto 6 -->');
       $editLength = $endEdit - $startEdit;
       $editString = substr($homeFile, $startEdit, $editLength);
       $editedFirstPartString = str_replace("<!-- Instagram foto 6 -->\r\n      <img src=\"","", $editString);
       $instagramFoto6 = str_replace("\" alt=\"\">\r\n      ","", $editedFirstPartString);

       return [$instagramFoto1, $instagramFoto2, $instagramFoto3, $instagramFoto4, $instagramFoto5, $instagramFoto6];
     }

     public function saveNewPictures(Request $request){

       $foto1 = file_get_contents($request->foto1);
       $foto2 = file_get_contents($request->foto2);
       $foto3 = file_get_contents($request->foto3);
       $foto4 = file_get_contents($request->foto4);
       $foto5 = file_get_contents($request->foto5);
       $foto6 = file_get_contents($request->foto6);

       file_put_contents('Insta/foto1.jpg', $foto1);
       file_put_contents('Insta/foto2.jpg', $foto2);
       file_put_contents('Insta/foto3.jpg', $foto3);
       file_put_contents('Insta/foto4.jpg', $foto4);
       file_put_contents('Insta/foto5.jpg', $foto5);
       file_put_contents('Insta/foto6.jpg', $foto6);

       // $homeFile = file_get_contents('../resources/js/Layouts/homepage/Home.vue');
       //
       // $startEdit = strrpos($homeFile, '<!-- Instagram foto 1 -->');
       // $endEdit = strrpos($homeFile, '<!-- Einde instagram foto 1 -->');
       // $editLength = $endEdit - $startEdit;
       // $editString = substr($homeFile, $startEdit, $editLength);
       // $editedFirstPartString = str_replace("<!-- Instagram foto 1 -->\r\n      <img src=\"","", $editString);
       // $instagramFoto1 = str_replace("\" alt=\"\">\r\n      ","", $editedFirstPartString);
       // $newContent = str_replace($instagramFoto1, $request->foto1, $homeFile);
       //
       // $startEdit = strrpos($homeFile, '<!-- Instagram foto 2 -->');
       // $endEdit = strrpos($homeFile, '<!-- Einde instagram foto 2 -->');
       // $editLength = $endEdit - $startEdit;
       // $editString = substr($homeFile, $startEdit, $editLength);
       // $editedFirstPartString = str_replace("<!-- Instagram foto 2 -->\r\n      <img src=\"","", $editString);
       // $instagramFoto2 = str_replace("\" alt=\"\">\r\n      ","", $editedFirstPartString);
       // $newContent2 = str_replace($instagramFoto2, $request->foto2, $newContent);
       //
       // $startEdit = strrpos($homeFile, '<!-- Instagram foto 3 -->');
       // $endEdit = strrpos($homeFile, '<!-- Einde instagram foto 3 -->');
       // $editLength = $endEdit - $startEdit;
       // $editString = substr($homeFile, $startEdit, $editLength);
       // $editedFirstPartString = str_replace("<!-- Instagram foto 3 -->\r\n      <img src=\"","", $editString);
       // $instagramFoto3 = str_replace("\" alt=\"\">\r\n      ","", $editedFirstPartString);
       // $newContent3 = str_replace($instagramFoto3, $request->foto3, $newContent2);
       //
       // $startEdit = strrpos($homeFile, '<!-- Instagram foto 4 -->');
       // $endEdit = strrpos($homeFile, '<!-- Einde instagram foto 4 -->');
       // $editLength = $endEdit - $startEdit;
       // $editString = substr($homeFile, $startEdit, $editLength);
       // $editedFirstPartString = str_replace("<!-- Instagram foto 4 -->\r\n      <img src=\"","", $editString);
       // $instagramFoto4 = str_replace("\" alt=\"\">\r\n      ","", $editedFirstPartString);
       // $newContent4 = str_replace($instagramFoto4, $request->foto4, $newContent3);
       //
       // $startEdit = strrpos($homeFile, '<!-- Instagram foto 5 -->');
       // $endEdit = strrpos($homeFile, '<!-- Einde instagram foto 5 -->');
       // $editLength = $endEdit - $startEdit;
       // $editString = substr($homeFile, $startEdit, $editLength);
       // $editedFirstPartString = str_replace("<!-- Instagram foto 5 -->\r\n      <img src=\"","", $editString);
       // $instagramFoto5 = str_replace("\" alt=\"\">\r\n      ","", $editedFirstPartString);
       // $newContent5 = str_replace($instagramFoto5, $request->foto5, $newContent4);
       //
       // $startEdit = strrpos($homeFile, '<!-- Instagram foto 6 -->');
       // $endEdit = strrpos($homeFile, '<!-- Einde instagram foto 6 -->');
       // $editLength = $endEdit - $startEdit;
       // $editString = substr($homeFile, $startEdit, $editLength);
       // $editedFirstPartString = str_replace("<!-- Instagram foto 6 -->\r\n      <img src=\"","", $editString);
       // $instagramFoto6 = str_replace("\" alt=\"\">\r\n      ","", $editedFirstPartString);
       // $newContent6 = str_replace($instagramFoto6, $request->foto6, $newContent5);
       //
       // file_put_contents('../resources/js/Layouts/homepage/Home.vue', $newContent6);

       // Compile new files
       // shell_exec('npm run development');

       return 'saved';
     }

     public function refreshAccessToken(){

       $oldAccessToken = DB::table('access_token')
       ->where('name', '=', 'instagram')
       ->value('value');

       $newAccessToken = Http::get('https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token='.$oldAccessToken);

       DB::table('access_token')
       ->where('name', '=', 'instagram')
       ->update([
         'value' => $newAccessToken['access_token'],
         'updated_at' => Carbon::now(),
       ]);

     }

     public function instaDataDeleted(){
       return 'Data deleted.';
     }

}
