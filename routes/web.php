<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\OrganizationsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UsersController;
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

// Auth
Route::group(['middleware' => 'guest'], function(){
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
    ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store'])
    ->name('login.store');
});

Route::delete('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

// Authenticated Routes
Route::group(['middleware' => 'auth'], function(){
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Users
    Route::put('users/{user}/restore', [UsersController::class, 'restore'])->name('users.restore');
    Route::resource('users', UsersController::class)->except('show');

    // Organizations
    Route::put('organizations/{organization}/restore', [OrganizationsController::class, 'restore'])
        ->name('organizations.restore');
    Route::resource('organizations', OrganizationsController::class)->except('show');

    // Contacts
    Route::put('contacts/{contact}/restore', [ContactsController::class, 'restore'])
        ->name('contacts.restore');
    Route::resource('contacts', ContactsController::class)->except('show');

    // Reports
    Route::get('reports', ReportsController::class)->name('reports');
});

// Images
Route::get('/img/{path}', [ImagesController::class, 'show'])
    ->where('path', '.*')
    ->name('image');
