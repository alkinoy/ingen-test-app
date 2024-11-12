<?php

use App\Modules\Invoices\Infrastructure\Http\InvoiceController;
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

Route::get('/', static function () {
    return 'test11';
});


Route::get('/invoices/{id}', [InvoiceController::class, 'show']);
Route::patch('/invoices/{id}/approve', [InvoiceController::class, 'approve']);
Route::patch('/invoices/{id}/reject', [InvoiceController::class, 'reject']);
