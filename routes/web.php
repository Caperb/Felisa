<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KlantController;
use App\Http\Controllers\ReparatieController;
use App\Http\Controllers\AanvraagController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BonController;
use App\Http\Controllers\HandtekeningController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OptiesController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\BestellingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\HappyCustomerController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\InstagramController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('', function () {
  return Inertia\Inertia::render('Homepage');
})->name('homepage');

//Bedankt voor de aankoop
Route::get('/aankoop-gelukt', function () {
  return Inertia\Inertia::render('BedanktVoorDeAankoop');
})->name('Bedankt voor de aankoop!');

// Route::get('/adminlogin', function () {
//     return view('/auth/login');
// });

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia\Inertia::render('Dashboard');
})->name('dashboard');

//home
Route::post('/send-contact-form', [ContactController::class, 'send']);

//Klanten
Route::post('/klant-aanmaken', [KlantController::class, 'add'])->middleware('auth');
Route::post('/klant-zoeken', [KlantController::class, 'search'])->middleware('auth');
Route::post('/delete-klant', [KlantController::class, 'delete'])->middleware('auth');
Route::post('/all-klanten', [KlantController::class, 'getAll'])->middleware('auth');
Route::post('/dashboard-customer-search', [KlantController::class, 'dashboardSearch'])->middleware('auth');
Route::post('/edit-klant', [KlantController::class, 'edit'])->middleware('auth');
Route::post('/add-klant-dashboard', [KlantController::class, 'dashboardAdd'])->middleware('auth');


Route::post('/upload-contract', [ContractController::class, 'upload'])->middleware('auth');
Route::post('/all-contracts', [ContractController::class, 'allContracts'])->middleware('auth');
Route::post('/download-contract', [ContractController::class, 'download'])->middleware('auth');
Route::post('/delete-contract', [ContractController::class, 'delete'])->middleware('auth');

//Users
Route::post('/delete-user', [UserController::class, 'delete'])->middleware('auth');
Route::post('/all-users', [UserController::class, 'getAll'])->middleware('auth');
Route::post('/user-search', [UserController::class, 'search'])->middleware('auth');
Route::post('/edit-user', [UserController::class, 'edit'])->middleware('auth');
Route::post('/add-user', [UserController::class, 'add'])->middleware('auth');
Route::post('/user-list', [UserController::class, 'userList'])->middleware('auth');

//Orders
Route::post('/delete-order', [OrderController::class, 'delete'])->middleware('auth');
Route::post('/all-orders', [OrderController::class, 'getAll'])->middleware('auth');
Route::post('/order-search', [OrderController::class, 'search'])->middleware('auth');
Route::post('/edit-order', [OrderController::class, 'edit'])->middleware('auth');
Route::post('/add-order', [OrderController::class, 'add'])->middleware('auth');
Route::post('/get-extra-artikelen', [OrderController::class, 'getArtikelen'])->middleware('auth');

//Repairs
Route::post('/delete-repair', [ReparatieController::class, 'delete'])->middleware('auth');
Route::post('/all-repairs', [ReparatieController::class, 'getAll'])->middleware('auth');
Route::post('/repair-search', [ReparatieController::class, 'search'])->middleware('auth');
Route::post('/edit-repair', [ReparatieController::class, 'edit'])->middleware('auth');
Route::post('/add-repair', [ReparatieController::class, 'dashboardAdd'])->middleware('auth');

//Tickets
Route::post('/delete-ticket', [TicketController::class, 'delete'])->middleware('auth');
Route::post('/all-tickets', [TicketController::class, 'getAll'])->middleware('auth');
Route::post('/ticket-search', [TicketController::class, 'search'])->middleware('auth');

//Reminders
Route::post('/delete-reminder', [ReminderController::class, 'delete'])->middleware('auth');
Route::post('/all-reminders', [ReminderController::class, 'getAll'])->middleware('auth');
Route::post('/add-reminder', [ReminderController::class, 'add'])->middleware('auth');
Route::post('/change-reminder-status', [ReminderController::class, 'edit'])->middleware('auth');
Route::post('/done-reminders', [ReminderController::class, 'getDone'])->middleware('auth');
Route::post('/active-reminders', [ReminderController::class, 'getActive'])->middleware('auth');

//Categorie
Route::post('/add-categorie-dashboard', [CategorieController::class, 'add'])->middleware('auth');
Route::post('/all-main-categories', [CategorieController::class, 'allMain'])->middleware('auth');
Route::post('/get-subs', [CategorieController::class, 'getSubs'])->middleware('auth');
Route::post('/edit-categorie', [CategorieController::class, 'edit'])->middleware('auth');
Route::post('/move-categorie-up', [CategorieController::class, 'moveUp'])->middleware('auth');
Route::post('/move-categorie-down', [CategorieController::class, 'moveDown'])->middleware('auth');
Route::post('/delete-categorie', [CategorieController::class, 'delete'])->middleware('auth');

//Home
Route::get('/all-home-data', [HomeController::class, 'getAll'])->middleware('auth');
Route::get('/home-refresh-reminders', [HomeController::class, 'refreshReminders'])->middleware('auth');
Route::get('/home-refresh-contracts', [HomeController::class, 'refreshContracts'])->middleware('auth');
Route::post('/change-contract-status', [HomeController::class, 'editContract'])->middleware('auth');
Route::get('/home-refresh-reminder-count', [HomeController::class, 'refreshReminderCount'])->middleware('auth');


//Bon
Route::post('/print-bon', [BonController::class, 'getBon'])->middleware('auth');

//Handtekening
Route::post('/get-handtekening', [HandtekeningController::class, 'get'])->middleware('auth');

//Onboarding
Route::post('/reparatie-aanmaken', [ReparatieController::class, 'add'])->middleware('auth');
Route::post('/aanvraag-aanmaken', [AanvraagController::class, 'add'])->middleware('auth');

//products
Route::post('/add-product', [ProductController::class, 'add'])->middleware('auth');
Route::post('/edit-product', [ProductController::class, 'edit'])->middleware('auth');
Route::post('/all-products', [ProductController::class, 'getAll'])->middleware('auth');
Route::post('/delete-product', [ProductController::class, 'delete'])->middleware('auth');
Route::post('/get-home-products', [ProductController::class, 'getHomeProducts']);

//Opties
Route::post('/all-opties', [OptiesController::class, 'allOpties'])->middleware('auth');
Route::post('/get-keuzes', [OptiesController::class, 'getKeuzes'])->middleware('auth');
Route::post('/add-optie', [OptiesController::class, 'add'])->middleware('auth');
Route::post('/delete-optie', [OptiesController::class, 'delete'])->middleware('auth');
Route::post('/delete-keuze', [OptiesController::class, 'deleteKeuze'])->middleware('auth');
Route::post('/edit-optie', [OptiesController::class, 'editOptie'])->middleware('auth');

//Shop
Route::post('/get-all-categories', [ShopController::class, 'getAllCategories']);
Route::post('/get-all-sub-categories', [ShopController::class, 'getAllSubCategories']);
Route::post('/get-all-products', [ShopController::class, 'getAllProducts']);
Route::post('/search-products', [ShopController::class, 'searchProducts']);
Route::post('/get-categorie-name', [ShopController::class, 'getCategorieName']);
Route::post('/get-keuze-opties', [ShopController::class, 'getKeuzeOpties']);
Route::post('/get-related-products', [ShopController::class, 'getRelatedProducts']);
Route::post('/prepare-payment', [ShopController::class, 'preparePayment']);
Route::post('/mollie-webhook', [ShopController::class, 'handleWebhookNotification']);
Route::post('/refund-payment', [ShopController::class, 'refund']);

//Bestellingen
Route::post('/all-bestellingen', [BestellingController::class, 'getAll']);
Route::post('/get-bestelling-info', [BestellingController::class, 'getBestellingInfo']);
Route::post('/change-bestelling-status', [BestellingController::class, 'changeBestellingStatus']);
Route::post('/change-ordered-product-status', [BestellingController::class, 'changeOrderedProductStatus']);
Route::post('/email-working-on-order', [BestellingController::class, 'sendEmailWorkingOn']);
Route::post('/email-order-send', [BestellingController::class, 'sendEmailOrderSend']);
Route::post('get-bestelling-with-status', [BestellingController::class, 'getBestellingWithStatus']);

//content
Route::get('/get-homepage-content', [ContentController::class, 'getHomeContent']);
Route::post('/save-homepage-content', [ContentController::class, 'saveHomeContent']);
Route::post('/save-homepage-content-no-foto', [ContentController::class, 'saveHomeContentNoFoto']);

//Happy customer controller
Route::post('/get-happy-customers', [HappyCustomerController::class, 'get']);
Route::post('/add-happy-customer', [HappyCustomerController::class, 'add']);
Route::post('/add-happy-customer-picture', [HappyCustomerController::class, 'addPicture']);
Route::post('/delete-happy-customer', [HappyCustomerController::class, 'delete']);
Route::get('/get-home-happy-customers', [HappyCustomerController::class, 'getHome']);

//Document Controller
Route::post('/download-algemene-voorwaarden', [DocumentController::class, 'getAlgemeneVoorwaarden']);
Route::post('/download-privacy-policy', [DocumentController::class, 'getPrivacyPolicy']);
Route::post('/download-return-form', [DocumentController::class, 'getReturnForm']);

//Instagram Controller
Route::get('/get-new-instagram-pictures', [InstagramController::class, 'getNewPictures']);
Route::get('/get-instagram-pictures', [InstagramController::class, 'getCurrentPictures']);
Route::post('/delete-instagram-data', [InstagramController::class, 'instaDataDeleted']);
Route::post('/save-new-instagram-pictures', [InstagramController::class, 'saveNewPictures']);






//test
// Route::post('/test', [ShopController::class, 'test']);
