<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoicesAttachmentsController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SectionsController;
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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
Route::prefix('/admin')->group(function () {
    Route::resource('products', ProductsController::class)->middleware('auth');
    Route::get('/section/{id}', [InvoicesController::class, 'getproducts'])->middleware('auth');
    Route::resource('sections', SectionsController::class)->middleware('auth');
    Route::get('/{page}', [AdminController::class, 'index'])->middleware('auth');
});



Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', 'UserManagement\RoleController');
    Route::resource('users', 'UserManagement\UserController');
});
