<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoiceReportController;
use App\Http\Controllers\InvoicesAttachmentsController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\UserManagement\UserController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::prefix('admin')->group(function () {

    Route::resource('invoices', InvoicesController::class)->middleware('auth');
    Route::resource('products', ProductsController::class)->middleware('auth');
    Route::resource('sections', SectionsController::class)->middleware('auth');
    Route::resource('invoicesAtt', InvoicesAttachmentsController::class)->middleware('auth');
    Route::get('/invoice_reports', [InvoiceReportController::class, 'index'])->name('invoice_report');
    Route::get('/invoiceArchive', [InvoicesController::class, 'getInvoicesArchived'])->name('invoiceArchive')->middleware('auth');
    Route::get('/markAsRead', [InvoicesController::class, 'markAllNotificationsAsRead'])->name('markAsRead')->middleware('auth');
    Route::get('/print_invoice/{id}', [InvoicesController::class, 'printInvoice'])->name('printInvoice')->middleware('auth');
    Route::put('/restoreInvoice/{id}', [InvoicesController::class, 'restoreInvoice'])->name('restoreInvoice')->middleware('auth');
    Route::post('/invoice/{id}', [InvoicesController::class, 'updateStatus'])->name('updateStatus')->middleware('auth');
    Route::delete('/invoice/{id}', [InvoicesController::class, 'transformToArchived'])->name('transformToArchived')->middleware('auth');
    Route::post('/search_invoice', [InvoiceReportController::class, 'Search_invoices'])->name('Search_invoices')->middleware('auth');
    Route::get('/section/{id}', [InvoicesController::class, 'getproducts'])->middleware('auth');
    Route::resource('users', UserController::class);
    Route::get('/{page}', [AdminController::class, 'index'])->middleware('auth');
    Route::get('/invoices_status/{status}', [InvoicesController::class, 'getInvoicesByStatus'])->name('invoiceStatus')->middleware('auth');
});
