<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/f', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('fdsfsd', [\App\Http\Controllers\AuthController::class, 'index']);

Route::get('/', [\App\Http\Controllers\LogicController::class, 'index']);

Route::get('registered', [\App\Http\Controllers\LogicController::class, 'registered']);
Route::get('defaulters', [\App\Http\Controllers\LogicController::class, 'defaulters']);
Route::get('default/{id}', [\App\Http\Controllers\LogicController::class, 'default']);
Route::get('removeDefault/{id}', [\App\Http\Controllers\LogicController::class, 'removeDefault']);
Route::get('connect/{id}', [\App\Http\Controllers\LogicController::class, 'connect']);
Route::get('removeConnect/{id}', [\App\Http\Controllers\LogicController::class, 'removeConnect']);
Route::get('disconnected', [\App\Http\Controllers\LogicController::class, 'disconnected']);
Route::get('connection/{id}', [\App\Http\Controllers\LogicController::class, 'connection']);
Route::get('register', [\App\Http\Controllers\LogicController::class, 'register']);
Route::get('editRegister/{id}', [\App\Http\Controllers\LogicController::class, 'editRegister']);
Route::post('storeInstitution', [\App\Http\Controllers\LogicController::class, 'storeInstitution']);
Route::post('eInstitution', [\App\Http\Controllers\LogicController::class, 'eInstitution']);
Route::get('bandwidth', [\App\Http\Controllers\LogicController::class, 'bandwidth']);
Route::get('Addbandwidth', [\App\Http\Controllers\LogicController::class, 'Addbandwidth']);
Route::post('storeBandwidth', [\App\Http\Controllers\LogicController::class, 'storeBandwidth']);
Route::get('editbandwidth/{id}', [\App\Http\Controllers\LogicController::class, 'editbandwidth']);
Route::post('eBandwidth/{id}', [\App\Http\Controllers\LogicController::class, 'eBandwidth']);
Route::get('deleteBandwith/{id}', [\App\Http\Controllers\LogicController::class, 'deleteBandwidth']);


Route::get('receiptFooter', [\App\Http\Controllers\AuthController::class, 'receiptFooter']);
Route::get('receiptF', [\App\Http\Controllers\AuthController::class, 'receiptF']);
Route::get('users', [\App\Http\Controllers\AuthController::class, 'users']);
Route::get('deleteUser', [\App\Http\Controllers\AuthController::class, 'deleteUser']);
Route::post('eUser', [\App\Http\Controllers\AuthController::class, 'eUser']);
Route::post('dUser', [\App\Http\Controllers\AuthController::class, 'dUser']);
Route::get('reset/{id}', [\App\Http\Controllers\AuthController::class, 'reset']);
Route::post('Login', [\App\Http\Controllers\AuthController::class, 'Login']);
Route::get('addUser', [\App\Http\Controllers\AuthController::class, 'addUser']);
Route::get('restock', [\App\Http\Controllers\AuthController::class, 'restock']);
Route::post('storeUsers', [\App\Http\Controllers\AuthController::class, 'storeUsers']);
Route::get('userEdit/{id}', [\App\Http\Controllers\AuthController::class, 'userEdit']);
Route::get('admin', [\App\Http\Controllers\AdminController::class, 'index']);
Route::get('hotelDashboard', [\App\Http\Controllers\AdminController::class, 'hotelAdmin']);
Route::get('HardwareDashboard', [\App\Http\Controllers\AdminController::class, 'HardwareDashboard']);
Route::get('stock', [\App\Http\Controllers\AdminController::class, 'stock']);
Route::get('stockBelowFive', [\App\Http\Controllers\AdminController::class, 'stockBelowFive']);
Route::get('hotelStock', [\App\Http\Controllers\AdminController::class, 'hotelStock']);
Route::get('addProduct', [\App\Http\Controllers\AdminController::class, 'addProduct']);
Route::get('addHotelProduct', [\App\Http\Controllers\AdminController::class, 'addHotelProduct']);
Route::post('storeStock', [\App\Http\Controllers\StockController::class, 'storeStock']);
Route::post('storeHotelStock', [\App\Http\Controllers\StockController::class, 'storeHotelStock']);
Route::get('totalTax', [\App\Http\Controllers\StockController::class, 'totalTax']);
Route::get('viewStock', [\App\Http\Controllers\StockController::class, 'viewStock']);
Route::get('viewHotelStock', [\App\Http\Controllers\StockController::class, 'viewHotelStock']);
Route::get('deleteStock', [\App\Http\Controllers\StockController::class, 'deleteStock']);
Route::get('deleteHotelStock', [\App\Http\Controllers\StockController::class, 'deleteHotelStock']);
Route::post('eStock', [\App\Http\Controllers\StockController::class, 'eStock']);
Route::get('purchase', [\App\Http\Controllers\StockController::class, 'purchase']);
Route::post('eHotelStock', [\App\Http\Controllers\StockController::class, 'eHotelStock']);
Route::post('dStock', [\App\Http\Controllers\StockController::class, 'dStock']);
Route::post('dHotelStock', [\App\Http\Controllers\StockController::class, 'dHotelStock']);
Route::get('sellStock', [\App\Http\Controllers\StockController::class, 'sellStock']);
Route::get('sellHotelStock', [\App\Http\Controllers\StockController::class, 'sellHotelStock']);
Route::get('add', [\App\Http\Controllers\StockController::class, 'add']);
Route::get('addHotel', [\App\Http\Controllers\StockController::class, 'addHotel']);
Route::get('minus', [\App\Http\Controllers\StockController::class, 'minus']);
Route::get('minusHotel', [\App\Http\Controllers\StockController::class, 'minusHotel']);
Route::get('del', [\App\Http\Controllers\StockController::class, 'del']);
Route::get('delHotel', [\App\Http\Controllers\StockController::class, 'delHotel']);
Route::get('sales', [\App\Http\Controllers\StockController::class, 'sales']);
Route::get('salesHotel', [\App\Http\Controllers\StockController::class, 'salesHotel']);
Route::get('salesMeat', [\App\Http\Controllers\StockController::class, 'salesMeat']);
Route::get('salesB', [\App\Http\Controllers\StockController::class, 'salesB']);
Route::get('stockEdit/{id}', [\App\Http\Controllers\StockController::class, 'stockEdit']);
Route::get('stockHotelEdit/{id}', [\App\Http\Controllers\StockController::class, 'stockHotelEdit']);
Route::get('highMovingproducts', [\App\Http\Controllers\StockController::class, 'highMovingproducts']);
Route::get('sell', [\App\Http\Controllers\AdminController::class, 'sell']);
Route::get('sellHotel', [\App\Http\Controllers\AdminController::class, 'sellHotel']);
Route::get('uSell', [\App\Http\Controllers\AdminController::class, 'uSell']);
Route::get('uHotelSell', [\App\Http\Controllers\AdminController::class, 'uHotelSell']);
Route::post('burgain', [\App\Http\Controllers\AdminController::class, 'burgain']);
Route::post('burgainHotel', [\App\Http\Controllers\AdminController::class, 'burgainHotel']);
Route::get('expense', [\App\Http\Controllers\AdminController::class, 'expense']);
Route::get('expenseHotel', [\App\Http\Controllers\AdminController::class, 'expenseHotel']);
Route::get('filterHotelEach', [\App\Http\Controllers\AdminController::class, 'filterHotelEach']);
Route::get('reprintReceipt', [\App\Http\Controllers\AdminController::class, 'reprintReceipt']);
Route::get('addExpense', [\App\Http\Controllers\AdminController::class, 'addExpense']);
Route::get('addHotelExpense', [\App\Http\Controllers\AdminController::class, 'addHotelExpense']);
Route::post('storeExpense', [\App\Http\Controllers\AdminController::class, 'storeExpense']);
Route::get('storeHotelExpense', [\App\Http\Controllers\AdminController::class, 'storeHotelExpense']);
Route::get('expenseEdit/{id}', [\App\Http\Controllers\AdminController::class, 'expenseEdit']);
Route::get('expenseHotelEdit/{id}', [\App\Http\Controllers\AdminController::class, 'expenseHotelEdit']);
Route::post('eExpense', [\App\Http\Controllers\AdminController::class, 'eExpense']);
Route::post('eHotelExpense', [\App\Http\Controllers\AdminController::class, 'eHotelExpense']);
Route::get('deleteExpense', [\App\Http\Controllers\AdminController::class, 'deleteExpense']);
Route::get('deleteHotelExpense', [\App\Http\Controllers\AdminController::class, 'deleteHotelExpense']);
Route::post('dExpense', [\App\Http\Controllers\AdminController::class, 'dExpense']);
Route::post('dHotelExpense', [\App\Http\Controllers\AdminController::class, 'dHotelExpense']);
Route::get('viewSale', [\App\Http\Controllers\AdminController::class, 'viewSale']);
Route::get('viewHotelSale', [\App\Http\Controllers\AdminController::class, 'viewHotelSale']);
Route::get('viewSaleHeader', [\App\Http\Controllers\AdminController::class, 'viewSaleHeader']);
Route::get('viewHotelSaleHeader', [\App\Http\Controllers\AdminController::class, 'viewHotelSaleHeader']);
Route::get('CalTotal', [\App\Http\Controllers\AdminController::class, 'CalTotal']);
Route::get('CalTotalHotel', [\App\Http\Controllers\AdminController::class, 'CalTotalHotel']);
Route::get('profile', [\App\Http\Controllers\AdminController::class, 'profile']);
Route::post('updateProfile', [\App\Http\Controllers\AdminController::class, 'updateProfile']);
Route::get('filterHardware', [\App\Http\Controllers\AdminController::class, 'filterHardware']);
Route::post('hardwareFilter', [\App\Http\Controllers\AdminController::class, 'filterMpesa']);
Route::post('hardwareF', [\App\Http\Controllers\StockController::class, 'filterMpesa']);
Route::post('highly', [\App\Http\Controllers\AdminController::class, 'highly']);
Route::get('filterHotelIndex', [\App\Http\Controllers\AdminController::class, 'filterHotelIndex']);
Route::post('filterHotel', [\App\Http\Controllers\AdminController::class, 'filterHotel']);
Route::get('sellButchery', [\App\Http\Controllers\AdminController::class, 'sellButchery']);
Route::get('sellByProduct', [\App\Http\Controllers\AdminController::class, 'sellByProduct']);
Route::get('payCredit', [\App\Http\Controllers\AdminController::class, 'payCredit']);
Route::post('creditPay', [\App\Http\Controllers\AdminController::class, 'creditPay']);
Route::get('quotation', [\App\Http\Controllers\Quote::class, 'quotation']);
Route::get('quote', [\App\Http\Controllers\Quote::class, 'quote']);
Route::get('editQuotation', [\App\Http\Controllers\Quote::class, 'editQuotation']);
Route::get('dQuotation', [\App\Http\Controllers\Quote::class, 'dQuotation']);
Route::post('dQ', [\App\Http\Controllers\Quote::class, 'dQ']);
Route::post('editQ', [\App\Http\Controllers\Quote::class, 'editQ']);
Route::get('startAgain', [\App\Http\Controllers\Quote::class, 'startAgain']);
