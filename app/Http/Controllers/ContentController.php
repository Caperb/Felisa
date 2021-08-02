<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
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
    public function getHomeContent(Request $request)
    {
      if (Auth::check()) {
        // Get file content
        $file =  file_get_contents("../resources/js/Layouts/homepage/Home.vue");


        //HEADER TEKST
        // Get position of string
        $startEdit = strrpos($file, '<!-- begin header tekst -->');
        $endEdit = strrpos($file, '<!-- einde header tekst -->');
        $editLength = $endEdit - $startEdit;

        // Get part from string
        $editString = substr($file, $startEdit, $editLength);

        // Replace part of the string
        $editedFirstPartString = str_replace("<!-- begin header tekst -->\r\n  <p class=\"md-display-3\">","", $editString);
        $headerText = str_replace("</p>\r\n  ","", $editedFirstPartString);

        //HEADER IMAGE
        $startEdit = strrpos($file, '<!-- begin header foto -->');
        $endEdit = strrpos($file, '<!-- einde header foto -->');
        $editLength = $endEdit - $startEdit;
        $editString = substr($file, $startEdit, $editLength);
        $editedFirstPartString = str_replace("<!-- begin header foto -->\r\n  <img src=\"","", $editString);
        $headerFoto = str_replace("\"></img>\r\n  ","", $editedFirstPartString);
        $headerFotoNaam = str_replace("/product_fotos/","", $headerFoto);

        //About titel
        $startEdit = strrpos($file, '<!-- begin about titel -->');
        $endEdit = strrpos($file, '<!-- einde about titel -->');
        $editLength = $endEdit - $startEdit;
        $editString = substr($file, $startEdit, $editLength);
        $editedFirstPartString = str_replace("<!-- begin about titel -->\r\n        <h2>","", $editString);
        $aboutTitel = str_replace("</h2>\r\n        ","", $editedFirstPartString);

        //About tekst
        $startEdit = strrpos($file, '<!-- begin about tekst -->');
        $endEdit = strrpos($file, '<!-- einde about tekst -->');
        $editLength = $endEdit - $startEdit;
        $editString = substr($file, $startEdit, $editLength);
        $editedFirstPartString = str_replace("<!-- begin about tekst -->\r\n        <p>","", $editString);
        $aboutTekst = str_replace("</p>\r\n        ","", $editedFirstPartString);

        //About foto
        $startEdit = strrpos($file, '<!-- begin about foto -->');
        $endEdit = strrpos($file, '<!-- einde about foto -->');
        $editLength = $endEdit - $startEdit;
        $editString = substr($file, $startEdit, $editLength);
        $editedFirstPartString = str_replace("<!-- begin about foto -->\r\n      <img src=\"","", $editString);
        $aboutFoto = str_replace("\"></img>\r\n      ","", $editedFirstPartString);
        $aboutFotoNaam = str_replace("/product_fotos/content-pictures/","", $aboutFoto);;

        //Achtergrond kleur
        $cssFile = file_get_contents("../resources/scss/app.scss");
        $startEdit = strrpos($cssFile, '// begin achtergrond kleur');
        $endEdit = strrpos($cssFile, '// einde achtergrond kleur');
        $editLength = $endEdit - $startEdit;
        $editString = substr($cssFile, $startEdit, $editLength);
        $editedFirstPartString = str_replace("// begin achtergrond kleur\r\n #about{\r\n   background-color: ","", $editString);
        $cssKleur = str_replace(";\r\n }\r\n #contact{\r\n   background-color: #c0deec;\r\n }\r\n","", $editedFirstPartString);

        return ["headerText" => $headerText, "headerFoto" => $headerFoto, "headerFotoNaam" => $headerFotoNaam,
          "oudeHeaderFotoNaam" => $headerFotoNaam, "aboutTitel" => $aboutTitel, "aboutTekst" => $aboutTekst, "cssKleur" => $cssKleur,
          "aboutFoto" => $aboutFoto, "aboutFotoNaam" => $aboutFotoNaam, "oudeAboutFotoNaam" => $aboutFotoNaam];
      }
    }

    public function saveHomeContent(Request $request)
    {
      if (Auth::check()) {

        // Get default execution time limit
        $normalTimeLimit = ini_get('max_execution_time');
        // Set new execution time limit
        ini_set('max_execution_time', 600);

        if ($request->oudeAboutFotoNaam != $request->aboutFotoNaam && $request->oudeHeaderFotoNaam != $request->headerFotoNaam) {

        // File path
        $path = '../resources/js/Layouts/homepage/Home.vue';
        // Get file content
        $file =  file_get_contents($path);
        // Get position of string
        $startEdit = strrpos($file, '<!-- begin header tekst -->');
        $endEdit = strrpos($file, '<!-- einde header tekst -->');
        $editLength = $endEdit - $startEdit;
        // Get part from string
        $editString = substr($file, $startEdit, $editLength);
        // Replace part of the string
        $editedFirstPartString = str_replace("<!-- begin header tekst -->\r\n  <p class=\"md-display-3\">","", $editString);
        $editedSecondPartString = str_replace("</p>\r\n  ","", $editedFirstPartString);
        // Replace file content with new content
        $newContent = str_replace($editedSecondPartString, $request->headerText, $file);

        //HEADER IMAGE
        Storage::disk('public_uploads')
        ->delete($request->oudeHeaderFotoNaam);

        $data = $request->headerFoto;
        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);
        $data = base64_decode($data);

        Storage::disk('public_uploads')
        ->put($request->headerFotoNaam, $data, 'public');

        $startEdit = strrpos($file, '<!-- begin header foto -->');
        $endEdit = strrpos($file, '<!-- einde header foto -->');
        $editLength = $endEdit - $startEdit;
        $editString = substr($file, $startEdit, $editLength);
        $editedFirstPartString = str_replace("<!-- begin header foto -->\r\n  <img src=\"","", $editString);
        $headerFoto = str_replace("\"></img>\r\n  ","", $editedFirstPartString);
        $newContent2 = str_replace($headerFoto, '/product_fotos/'.$request->headerFotoNaam, $newContent);

        //Cart header image
        $cartFile = file_get_contents('../resources/js/Layouts/homepage/Cart.vue');
        $startEdit = strrpos($cartFile, '<!-- begin header foto -->');
        $endEdit = strrpos($cartFile, '<!-- einde header foto -->');
        $editLength = $endEdit - $startEdit;
        $editString = substr($cartFile, $startEdit, $editLength);
        $editedFirstPartString = str_replace("<!-- begin header foto -->\r\n      <img src=\"","", $editString);
        $headerFoto = str_replace("\"></img>\r\n      ","", $editedFirstPartString);
        $newContentCart = str_replace($headerFoto, '/product_fotos/'.$request->headerFotoNaam, $cartFile);
        file_put_contents('../resources/js/Layouts/homepage/Cart.vue', $newContentCart);

        //Happy customers header image
        $happyCustomersFile = file_get_contents('../resources/js/Layouts/homepage/HappyCustomers.vue');
        $startEdit = strrpos($happyCustomersFile, '<!-- begin header foto -->');
        $endEdit = strrpos($happyCustomersFile, '<!-- einde header foto -->');
        $editLength = $endEdit - $startEdit;
        $editString = substr($happyCustomersFile, $startEdit, $editLength);
        $editedFirstPartString = str_replace("<!-- begin header foto -->\r\n      <img src=\"","", $editString);
        $headerFoto = str_replace("\"></img>\r\n      ","", $editedFirstPartString);
        $newContentHappyCustomers = str_replace($headerFoto, '/product_fotos/'.$request->headerFotoNaam, $happyCustomersFile);
        file_put_contents('../resources/js/Layouts/homepage/HappyCustomers.vue', $newContentHappyCustomers);

        //Product detail page header image
        $productDetailPageFile = file_get_contents('../resources/js/Layouts/homepage/ProductDetailPage.vue');
        $startEdit = strrpos($productDetailPageFile, '<!-- begin header foto -->');
        $endEdit = strrpos($productDetailPageFile, '<!-- einde header foto -->');
        $editLength = $endEdit - $startEdit;
        $editString = substr($productDetailPageFile, $startEdit, $editLength);
        $editedFirstPartString = str_replace("<!-- begin header foto -->\r\n      <img src=\"","", $editString);
        $headerFoto = str_replace("\"></img>\r\n      ","", $editedFirstPartString);
        $newContentProductDetailPage = str_replace($headerFoto, '/product_fotos/'.$request->headerFotoNaam, $productDetailPageFile);
        file_put_contents('../resources/js/Layouts/homepage/ProductDetailPage.vue', $newContentProductDetailPage);

        //Shop header image
        $shopFile = file_get_contents('../resources/js/Layouts/homepage/Shop.vue');
        $startEdit = strrpos($shopFile, '<!-- begin header foto -->');
        $endEdit = strrpos($shopFile, '<!-- einde header foto -->');
        $editLength = $endEdit - $startEdit;
        $editString = substr($shopFile, $startEdit, $editLength);
        $editedFirstPartString = str_replace("<!-- begin header foto -->\r\n      <img src=\"","", $editString);
        $headerFoto = str_replace("\"></img>\r\n      ","", $editedFirstPartString);
        $newContentShop = str_replace($headerFoto, '/product_fotos/'.$request->headerFotoNaam, $shopFile);
        file_put_contents('../resources/js/Layouts/homepage/Shop.vue', $newContentShop);

        //Bedankt voor de aankoop header image
        $bedanktVoorDeAankoopFile = file_get_contents('../resources/js/Pages/BedanktVoorDeAankoop.vue');
        $startEdit = strrpos($bedanktVoorDeAankoopFile, '<!-- begin header foto -->');
        $endEdit = strrpos($bedanktVoorDeAankoopFile, '<!-- einde header foto -->');
        $editLength = $endEdit - $startEdit;
        $editString = substr($bedanktVoorDeAankoopFile, $startEdit, $editLength);
        $editedFirstPartString = str_replace("<!-- begin header foto -->\r\n      <img src=\"","", $editString);
        $headerFoto = str_replace("\"></img>\r\n      ","", $editedFirstPartString);
        $newContentBedanktVoorDeAankoop = str_replace($headerFoto, '/product_fotos/'.$request->headerFotoNaam, $bedanktVoorDeAankoopFile);
        file_put_contents('../resources/js/Pages/BedanktVoorDeAankoop.vue', $newContentBedanktVoorDeAankoop);

        //About titel
        $startEdit = strrpos($file, '<!-- begin about titel -->');
        $endEdit = strrpos($file, '<!-- einde about titel -->');
        $editLength = $endEdit - $startEdit;
        $editString = substr($file, $startEdit, $editLength);
        $editedFirstPartString = str_replace("<!-- begin about titel -->\r\n        <h2>","", $editString);
        $aboutTitel = str_replace("</h2>\r\n        ","", $editedFirstPartString);
        $newContent3 = str_replace($aboutTitel, $request->aboutTitel, $newContent2);

        //About tekst
        $startEdit = strrpos($file, '<!-- begin about tekst -->');
        $endEdit = strrpos($file, '<!-- einde about tekst -->');
        $editLength = $endEdit - $startEdit;
        $editString = substr($file, $startEdit, $editLength);
        $editedFirstPartString = str_replace("<!-- begin about tekst -->\r\n        <p>","", $editString);
        $aboutTekst = str_replace("</p>\r\n        ","", $editedFirstPartString);
        $newContent4 = str_replace($aboutTekst, $request->aboutTekst, $newContent3);

        //About image
        Storage::disk('public_uploads')
        ->delete($request->oudeAboutFotoNaam);

        $data = $request->aboutFoto;
        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);
        $data = base64_decode($data);

        Storage::disk('public_uploads')
        ->put('/content-pictures/'.$request->aboutFotoNaam, $data, 'public');

        $startEdit = strrpos($file, '<!-- begin about foto -->');
        $endEdit = strrpos($file, '<!-- einde about foto -->');
        $editLength = $endEdit - $startEdit;
        $editString = substr($file, $startEdit, $editLength);
        $editedFirstPartString = str_replace("<!-- begin about foto -->\r\n      <img src=\"","", $editString);
        $aboutFoto = str_replace("\"></img>\r\n      ","", $editedFirstPartString);
        $newContent5 = str_replace($aboutFoto, '/product_fotos/content-pictures/'.$request->aboutFotoNaam, $newContent4);
        file_put_contents($path, $newContent5);

        //Achtergrond kleur
        $cssFile = file_get_contents("../resources/scss/app.scss");
        $startEdit = strrpos($cssFile, '// begin achtergrond kleur');
        $endEdit = strrpos($cssFile, '// einde achtergrond kleur');
        $editLength = $endEdit - $startEdit;
        $editString = substr($cssFile, $startEdit, $editLength);
        $editedFirstPartString = str_replace("// begin achtergrond kleur\r\n #about{\r\n   background-color: ","", $editString);
        $cssKleur = str_replace(";\r\n }\r\n #contact{\r\n   background-color: #c0deec;\r\n }\r\n","", $editedFirstPartString);
        $editedString = str_replace($cssKleur,$request->cssKleur,$editString);
        $newContent6 = str_replace($editString, $editedString, $cssFile);
        file_put_contents("../resources/scss/app.scss", $newContent6);

      }elseif ($request->oudeAboutFotoNaam == $request->aboutFotoNaam && $request->oudeHeaderFotoNaam != $request->headerFotoNaam) {

        // File path
        $path = '../resources/js/Layouts/homepage/Home.vue';
        // Get file content
        $file =  file_get_contents($path);
        // Get position of string
        $startEdit = strrpos($file, '<!-- begin header tekst -->');
        $endEdit = strrpos($file, '<!-- einde header tekst -->');
        $editLength = $endEdit - $startEdit;
        // Get part from string
        $editString = substr($file, $startEdit, $editLength);
        // Replace part of the string
        $editedFirstPartString = str_replace("<!-- begin header tekst -->\r\n  <p class=\"md-display-3\">","", $editString);
        $editedSecondPartString = str_replace("</p>\r\n  ","", $editedFirstPartString);
        // Replace file content with new content
        $newContent = str_replace($editedSecondPartString, $request->headerText, $file);

        //HEADER IMAGE
        Storage::disk('public_uploads')
        ->delete($request->oudeHeaderFotoNaam);

        $data = $request->headerFoto;
        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);
        $data = base64_decode($data);

        Storage::disk('public_uploads')
        ->put($request->headerFotoNaam, $data, 'public');

        $startEdit = strrpos($file, '<!-- begin header foto -->');
        $endEdit = strrpos($file, '<!-- einde header foto -->');
        $editLength = $endEdit - $startEdit;
        $editString = substr($file, $startEdit, $editLength);
        $editedFirstPartString = str_replace("<!-- begin header foto -->\r\n  <img src=\"","", $editString);
        $headerFoto = str_replace("\"></img>\r\n  ","", $editedFirstPartString);
        $newContent2 = str_replace($headerFoto, '/product_fotos/'.$request->headerFotoNaam, $newContent);

        //Cart header image
        $cartFile = file_get_contents('../resources/js/Layouts/homepage/Cart.vue');
        $startEdit = strrpos($cartFile, '<!-- begin header foto -->');
        $endEdit = strrpos($cartFile, '<!-- einde header foto -->');
        $editLength = $endEdit - $startEdit;
        $editString = substr($cartFile, $startEdit, $editLength);
        $editedFirstPartString = str_replace("<!-- begin header foto -->\r\n      <img src=\"","", $editString);
        $headerFoto = str_replace("\"></img>\r\n      ","", $editedFirstPartString);
        $newContentCart = str_replace($headerFoto, '/product_fotos/'.$request->headerFotoNaam, $cartFile);
        file_put_contents('../resources/js/Layouts/homepage/Cart.vue', $newContentCart);

        //Happy customers header image
        $happyCustomersFile = file_get_contents('../resources/js/Layouts/homepage/HappyCustomers.vue');
        $startEdit = strrpos($happyCustomersFile, '<!-- begin header foto -->');
        $endEdit = strrpos($happyCustomersFile, '<!-- einde header foto -->');
        $editLength = $endEdit - $startEdit;
        $editString = substr($happyCustomersFile, $startEdit, $editLength);
        $editedFirstPartString = str_replace("<!-- begin header foto -->\r\n      <img src=\"","", $editString);
        $headerFoto = str_replace("\"></img>\r\n      ","", $editedFirstPartString);
        $newContentHappyCustomers = str_replace($headerFoto, '/product_fotos/'.$request->headerFotoNaam, $happyCustomersFile);
        file_put_contents('../resources/js/Layouts/homepage/HappyCustomers.vue', $newContentHappyCustomers);

        //Product detail page header image
        $productDetailPageFile = file_get_contents('../resources/js/Layouts/homepage/ProductDetailPage.vue');
        $startEdit = strrpos($productDetailPageFile, '<!-- begin header foto -->');
        $endEdit = strrpos($productDetailPageFile, '<!-- einde header foto -->');
        $editLength = $endEdit - $startEdit;
        $editString = substr($productDetailPageFile, $startEdit, $editLength);
        $editedFirstPartString = str_replace("<!-- begin header foto -->\r\n      <img src=\"","", $editString);
        $headerFoto = str_replace("\"></img>\r\n      ","", $editedFirstPartString);
        $newContentProductDetailPage = str_replace($headerFoto, '/product_fotos/'.$request->headerFotoNaam, $productDetailPageFile);
        file_put_contents('../resources/js/Layouts/homepage/ProductDetailPage.vue', $newContentProductDetailPage);

        //Shop header image
        $shopFile = file_get_contents('../resources/js/Layouts/homepage/Shop.vue');
        $startEdit = strrpos($shopFile, '<!-- begin header foto -->');
        $endEdit = strrpos($shopFile, '<!-- einde header foto -->');
        $editLength = $endEdit - $startEdit;
        $editString = substr($shopFile, $startEdit, $editLength);
        $editedFirstPartString = str_replace("<!-- begin header foto -->\r\n      <img src=\"","", $editString);
        $headerFoto = str_replace("\"></img>\r\n      ","", $editedFirstPartString);
        $newContentShop = str_replace($headerFoto, '/product_fotos/'.$request->headerFotoNaam, $shopFile);
        file_put_contents('../resources/js/Layouts/homepage/Shop.vue', $newContentShop);

        //Bedankt voor de aankoop header image
        $bedanktVoorDeAankoopFile = file_get_contents('../resources/js/Pages/BedanktVoorDeAankoop.vue');
        $startEdit = strrpos($bedanktVoorDeAankoopFile, '<!-- begin header foto -->');
        $endEdit = strrpos($bedanktVoorDeAankoopFile, '<!-- einde header foto -->');
        $editLength = $endEdit - $startEdit;
        $editString = substr($bedanktVoorDeAankoopFile, $startEdit, $editLength);
        $editedFirstPartString = str_replace("<!-- begin header foto -->\r\n      <img src=\"","", $editString);
        $headerFoto = str_replace("\"></img>\r\n      ","", $editedFirstPartString);
        $newContentBedanktVoorDeAankoop = str_replace($headerFoto, '/product_fotos/'.$request->headerFotoNaam, $bedanktVoorDeAankoopFile);
        file_put_contents('../resources/js/Pages/BedanktVoorDeAankoop.vue', $newContentBedanktVoorDeAankoop);

        //About titel
        $startEdit = strrpos($file, '<!-- begin about titel -->');
        $endEdit = strrpos($file, '<!-- einde about titel -->');
        $editLength = $endEdit - $startEdit;
        $editString = substr($file, $startEdit, $editLength);
        $editedFirstPartString = str_replace("<!-- begin about titel -->\r\n        <h2>","", $editString);
        $aboutTitel = str_replace("</h2>\r\n        ","", $editedFirstPartString);
        $newContent3 = str_replace($aboutTitel, $request->aboutTitel, $newContent2);

        //About tekst
        $startEdit = strrpos($file, '<!-- begin about tekst -->');
        $endEdit = strrpos($file, '<!-- einde about tekst -->');
        $editLength = $endEdit - $startEdit;
        $editString = substr($file, $startEdit, $editLength);
        $editedFirstPartString = str_replace("<!-- begin about tekst -->\r\n        <p>","", $editString);
        $aboutTekst = str_replace("</p>\r\n        ","", $editedFirstPartString);
        $newContent4 = str_replace($aboutTekst, $request->aboutTekst, $newContent3);
        file_put_contents($path, $newContent4);

        //Achtergrond kleur
        $cssFile = file_get_contents("../resources/scss/app.scss");
        $startEdit = strrpos($cssFile, '// begin achtergrond kleur');
        $endEdit = strrpos($cssFile, '// einde achtergrond kleur');
        $editLength = $endEdit - $startEdit;
        $editString = substr($cssFile, $startEdit, $editLength);
        $editedFirstPartString = str_replace("// begin achtergrond kleur\r\n #about{\r\n   background-color: ","", $editString);
        $cssKleur = str_replace(";\r\n }\r\n #contact{\r\n   background-color: #c0deec;\r\n }\r\n","", $editedFirstPartString);
        $editedString = str_replace($cssKleur,$request->cssKleur,$editString);
        $newContent5 = str_replace($editString, $editedString, $cssFile);
        file_put_contents("../resources/scss/app.scss", $newContent5);

      }elseif ($request->oudeAboutFotoNaam != $request->aboutFotoNaam && $request->oudeHeaderFotoNaam == $request->headerFotoNaam) {

        // File path
        $path = '../resources/js/Layouts/homepage/Home.vue';
        // Get file content
        $file =  file_get_contents($path);
        // Get position of string
        $startEdit = strrpos($file, '<!-- begin header tekst -->');
        $endEdit = strrpos($file, '<!-- einde header tekst -->');
        $editLength = $endEdit - $startEdit;
        // Get part from string
        $editString = substr($file, $startEdit, $editLength);
        // Replace part of the string
        $editedFirstPartString = str_replace("<!-- begin header tekst -->\r\n  <p class=\"md-display-3\">","", $editString);
        $editedSecondPartString = str_replace("</p>\r\n  ","", $editedFirstPartString);
        // Replace file content with new content
        $newContent = str_replace($editedSecondPartString, $request->headerText, $file);

        //About titel
        $startEdit = strrpos($file, '<!-- begin about titel -->');
        $endEdit = strrpos($file, '<!-- einde about titel -->');
        $editLength = $endEdit - $startEdit;
        $editString = substr($file, $startEdit, $editLength);
        $editedFirstPartString = str_replace("<!-- begin about titel -->\r\n        <h2>","", $editString);
        $aboutTitel = str_replace("</h2>\r\n        ","", $editedFirstPartString);
        $newContent2 = str_replace($aboutTitel, $request->aboutTitel, $newContent);

        //About tekst
        $startEdit = strrpos($file, '<!-- begin about tekst -->');
        $endEdit = strrpos($file, '<!-- einde about tekst -->');
        $editLength = $endEdit - $startEdit;
        $editString = substr($file, $startEdit, $editLength);
        $editedFirstPartString = str_replace("<!-- begin about tekst -->\r\n        <p>","", $editString);
        $aboutTekst = str_replace("</p>\r\n        ","", $editedFirstPartString);
        $newContent3 = str_replace($aboutTekst, $request->aboutTekst, $newContent2);

        //About image
        Storage::disk('public_uploads')
        ->delete($request->oudeAboutFotoNaam);

        $data = $request->aboutFoto;
        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);
        $data = base64_decode($data);

        Storage::disk('public_uploads')
        ->put('/content-pictures/'.$request->aboutFotoNaam, $data, 'public');

        $startEdit = strrpos($file, '<!-- begin about foto -->');
        $endEdit = strrpos($file, '<!-- einde about foto -->');
        $editLength = $endEdit - $startEdit;
        $editString = substr($file, $startEdit, $editLength);
        $editedFirstPartString = str_replace("<!-- begin about foto -->\r\n      <img src=\"","", $editString);
        $aboutFoto = str_replace("\"></img>\r\n      ","", $editedFirstPartString);
        $newContent4 = str_replace($aboutFoto, '/product_fotos/content-pictures/'.$request->aboutFotoNaam, $newContent3);
        file_put_contents($path, $newContent4);

        //Achtergrond kleur
        $cssFile = file_get_contents("../resources/scss/app.scss");
        $startEdit = strrpos($cssFile, '// begin achtergrond kleur');
        $endEdit = strrpos($cssFile, '// einde achtergrond kleur');
        $editLength = $endEdit - $startEdit;
        $editString = substr($cssFile, $startEdit, $editLength);
        $editedFirstPartString = str_replace("// begin achtergrond kleur\r\n #about{\r\n   background-color: ","", $editString);
        $cssKleur = str_replace(";\r\n }\r\n #contact{\r\n   background-color: #c0deec;\r\n }\r\n","", $editedFirstPartString);
        $editedString = str_replace($cssKleur,$request->cssKleur,$editString);
        $newContent5 = str_replace($editString, $editedString, $cssFile);
        file_put_contents("../resources/scss/app.scss", $newContent5);

      }

        // Compile new files
        shell_exec('npm run production');

        // Restore default limit
        ini_set('max_execution_time', $normalTimeLimit);

        return 'Saved';
      }
    }

    public function saveHomeContentNoFoto(Request $request)
    {
      if (Auth::check()) {

        $normalTimeLimit = ini_get('max_execution_time');
        ini_set('max_execution_time', 600);

        //Header tekts
        $path = '../resources/js/Layouts/homepage/Home.vue';
        $file =  file_get_contents($path);
        $startEdit = strrpos($file, '<!-- begin header tekst -->');
        $endEdit = strrpos($file, '<!-- einde header tekst -->');
        $editLength = $endEdit - $startEdit;
        $editString = substr($file, $startEdit, $editLength);
        $editedFirstPartString = str_replace("<!-- begin header tekst -->\r\n  <p class=\"md-display-3\">","", $editString);
        $editedSecondPartString = str_replace("</p>\r\n  ","", $editedFirstPartString);
        $newContent = str_replace($editedSecondPartString, $request->headerText, $file);

        //About titel
        $startEdit = strrpos($file, '<!-- begin about titel -->');
        $endEdit = strrpos($file, '<!-- einde about titel -->');
        $editLength = $endEdit - $startEdit;
        $editString = substr($file, $startEdit, $editLength);
        $editedFirstPartString = str_replace("<!-- begin about titel -->\r\n        <h2>","", $editString);
        $aboutTitel = str_replace("</h2>\r\n        ","", $editedFirstPartString);
        $newContent2 = str_replace($aboutTitel, $request->aboutTitel, $newContent);

        //About tekst
        $startEdit = strrpos($file, '<!-- begin about tekst -->');
        $endEdit = strrpos($file, '<!-- einde about tekst -->');
        $editLength = $endEdit - $startEdit;
        $editString = substr($file, $startEdit, $editLength);
        $editedFirstPartString = str_replace("<!-- begin about tekst -->\r\n        <p>","", $editString);
        $aboutTekst = str_replace("</p>\r\n        ","", $editedFirstPartString);
        $newContent3 = str_replace($aboutTekst, $request->aboutTekst, $newContent2);
        file_put_contents($path, $newContent3);

        //Achtergrond kleur
        $cssFile = file_get_contents("../resources/scss/app.scss");
        $startEdit = strrpos($cssFile, '// begin achtergrond kleur');
        $endEdit = strrpos($cssFile, '// einde achtergrond kleur');
        $editLength = $endEdit - $startEdit;
        $editString = substr($cssFile, $startEdit, $editLength);
        $editedFirstPartString = str_replace("// begin achtergrond kleur\r\n #about{\r\n   background-color: ","", $editString);
        $cssKleur = str_replace(";\r\n }\r\n #contact{\r\n   background-color: #c0deec;\r\n }\r\n","", $editedFirstPartString);
        $editedString = str_replace($cssKleur,$request->cssKleur,$editString);
        $newContent5 = str_replace($editString, $editedString, $cssFile);
        file_put_contents("../resources/scss/app.scss", $newContent5);

        // Compile new files
        shell_exec('npm run production');

        // Restore default limit
        ini_set('max_execution_time', $normalTimeLimit);

        return 'saved';
      }
    }



}
