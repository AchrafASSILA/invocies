<?php

use App\Http\Controllers\InvoicesAttachmentsController;
use App\Http\Controllers\InvoicesController;
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


// Route::prefix('/invoices')->group(function () {
Route::resource('invoices', InvoicesController::class)->middleware('auth');
Route::resource('invoicesAtt', InvoicesAttachmentsController::class)->middleware('auth');
Route::get('/invoiceArchive', [InvoicesController::class, 'getInvoicesArchived'])->name('invoiceArchive')->middleware('auth');
Route::get('/{status}', [InvoicesController::class, 'getInvoicesByStatus'])->name('invoiceStatus')->middleware('auth');
Route::get('/print_invoice/{id}', [InvoicesController::class, 'printInvoice'])->name('printInvoice')->middleware('auth');
Route::delete('/invoice/{id}', [InvoicesController::class, 'transformToArchived'])->name('transformToArchived')->middleware('auth');
Route::put('/restoreInvoice/{id}', [InvoicesController::class, 'restoreInvoice'])->name('restoreInvoice')->middleware('auth');
Route::post('/invoice/{id}', [InvoicesController::class, 'updateStatus'])->name('updateStatus')->middleware('auth');
// });
