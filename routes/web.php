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

// Route::get('/adminlogin', function () {
//     return view('/auth/login');
// });

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia\Inertia::render('Dashboard');
})->name('dashboard');

Route::get('/klant-aanmaken', function () {
    // Only authenticated users may enter...
})->middleware('auth');

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
