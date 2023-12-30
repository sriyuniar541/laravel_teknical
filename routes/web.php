<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PurchasesController;
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



// _______________dashboar____________________
Route::get('/', [ ProductsController::class, 'index'])->middleware(['auth']);


// _______________user________________________
Route::get('/user/register', [ UserController::class, 'index']);
Route::post('/user/register', [ UserController::class, 'register']);
Route::get('/user/login', [ UserController::class, 'viewLogin']);
Route::post('/user/login', [ UserController::class, 'login'])->name('login');
Route::get('/user/logout', [ UserController::class, 'logout']);
Route::get('/user/profile', [ UserController::class, 'profile'])->middleware('auth');


// _______________role Manager___________________
Route::get('/sales/viewSales', [ SalesController::class, 'viewSales'])->middleware('manager');
Route::get('/purchases/viewPurchases', [ PurchasesController::class, 'viewPurchases'])->middleware('manager');


// _______________role Purchase__________________
Route::get('/purchases/purc/get', [ PurchasesController::class, 'getPurchases'])->middleware('purchase');
Route::delete('/purchases/purc/{id}', [ PurchasesController::class, 'destroy_purc'])->middleware('purchase');
Route::put('/purchases/purc/{id}', [ PurchasesController::class, 'update_purc'])->middleware('purchase');

// update bayar dan stock
Route::put('/product/purc/stock/{id}', [ ProductsController::class, 'update_stock_purc'])->middleware('purchase');



// _______________role Super admin_______________

// sales
    Route::post('/sales', [ SalesController::class, 'store'])->middleware('superAdmin');
    Route::delete('/sales/{id}', [ SalesController::class, 'destroy'])->middleware('superAdmin');
    Route::put('/sales/{id}', [ SalesController::class, 'update'])->middleware('superAdmin');
    Route::get('/sales', [ SalesController::class, 'index'])->middleware('superAdmin');

//purchases
    Route::get('/purchases', [ PurchasesController::class, 'index'])->middleware('superAdmin');
    Route::get('/purchases', [ PurchasesController::class, 'index'])->middleware('auth');
    Route::post('/purchases', [ PurchasesController::class, 'store']);
    Route::delete('/purchases/{id}', [ PurchasesController::class, 'destroy'])->middleware('superAdmin');
    Route::put('/purchases/{id}', [ PurchasesController::class, 'update'])->middleware('superAdmin');

//inventory
    Route::get('/product/addProduct', [ ProductsController::class, 'create'])->middleware('superAdmin');
    Route::post('/product', [ ProductsController::class, 'store'])->middleware('superAdmin');
    Route::delete('/product/{id}', [ ProductsController::class, 'destroy'])->middleware('superAdmin');
    Route::put('/product/{id}', [ ProductsController::class, 'update'])->middleware('superAdmin');
    Route::put('/product/stock/{id}', [ ProductsController::class, 'update_stock'])->middleware('superAdmin');
    


// _______________role sales_____________________
    Route::get('/product/sal/addProduct', [ ProductsController::class, 'create_sal'])->middleware('sales');
    Route::post('/product/sal', [ ProductsController::class, 'store_sal'])->middleware('sales');
    Route::delete('/product/sal/{id}', [ ProductsController::class, 'destroy_sal'])->middleware('sales');
    Route::put('/product/sal/{id}', [ ProductsController::class, 'update_sal'])->middleware('sales');
    Route::put('/product/sal/stock/{id}', [ ProductsController::class, 'update_stock_sal'])->middleware('sales');


// _______________export ________________________
    // sales
    Route::get('/sales/exportExcel', [ SalesController::class, 'exportExcel'])->name('exportSalesExcel');
    Route::get('/sales/exportPdf', [ SalesController::class, 'exportPdf'])->name('exportSalesPdf');
    Route::get('/sales/exportCsv', [ SalesController::class, 'exportCsv'])->name('exportSalesCsv');

    //purchases 
    Route::get('/purchases/exportExcel', [ PurchasesController::class, 'exportExcel'])->name('exportPurchasesExcel');
    Route::get('/purchases/exportPdf', [ PurchasesController::class, 'exportPdf'])->name('exportPurchasesPdf');
    Route::get('/purchases/exportCsv', [ PurchasesController::class, 'exportCsv'])->name('exportPurchasesCsv');

    //inventory 
    Route::get('/product/exportExcel', [ ProductsController::class, 'exportExcel'])->name('exportExcel');
    Route::get('/product/exportPdf', [ ProductsController::class, 'exportPdf'])->name('exportPdf');
    Route::get('/product/exportCsv', [ ProductsController::class, 'exportCsv'])->name('exportCsv');


