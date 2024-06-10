<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/home', [DashboardController::class, 'index'])->name('home');
Route::get('/top-up', [WalletController::class, 'showTopUpForm'])->middleware('auth');
Route::post('/top-up', [WalletController::class, 'topUp'])->middleware('auth');
Route::get('/purchase', [TransactionController::class, 'showPurchaseForm'])->middleware('auth');
Route::post('/purchase', [TransactionController::class, 'purchase'])->middleware('auth');



Route::middleware("isLogin")->group(function () {
    Route::get("/dashboard", [DashboardController::class, "index"])->name("dashboard");
    Route::get("/stock", [StockController::class, "index"])->name("stock");
    Route::post("/stock/create", [StockController::class, "store"])->name("stock.store");
    Route::post("/stock/add/{id}", [StockController::class, "updateStock"])->name("stock.update.stock");
    Route::post("/stock/update/{id}", [StockController::class, "update"])->name("stock.update");
    Route::get("/stock_log/in", [StockController::class, "stockIn"])->name("stock.log.in");
    Route::get("/stock_log/out", [StockController::class, "stockOut"])->name("stock.log.out");

    Route::get("/penjualan", [PenjualanController::class, "index"])->name("penjualan");
    Route::post("/penjualan/invoice", [PenjualanController::class, "createInvoice"])->name("penjualan.invoice");
    Route::post("/penjualan/payment", [PenjualanController::class, "confirmPayment"])->name("penjualan.payment");
    Route::get("/history", [PenjualanController::class, "paymentHistory"])->name("penjualan.history");

    Route::middleware("isAdmin")->group(function () {
        Route::get("/user", [UserController::class, "index"])->name("user");
        Route::get("/user/create", [UserController::class, "create"])->name("user.create");
        Route::post("/user/create", [UserController::class, "store"])->name("user.store");
        Route::get("/user/edit/{id}", [UserController::class, "edit"])->name("user.edit");
        Route::patch("/user/update/{id}", [UserController::class, "update"])->name("user.update");
        Route::delete("/user/delete/{id}", [UserController::class, "destroy"])->name("user.delete");
    });
});
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login.post');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerPost'])->name('register.post');

Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

Route::get('users/export/', [UserController::class, 'export'])->name('users.export');
Route::get('stocks/export/', [StockController::class, 'export'])->name('stocks.export');

Route::get('/downloadpdf', [PenjualanController::class, 'downloadpdf'])->name('downloadpdf');