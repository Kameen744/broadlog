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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware(['guest'])->group(function () {
    Route::get('/', App\Http\Livewire\Auth\Login::class)->name('login');
    Route::get('/admin', App\Http\Livewire\Auth\AdminLogin::class)->name('admin.login');
});

Route::middleware('auth')->group(function () {
    Route::get('/user-dashboard', App\Http\Livewire\UserDashboard::class)->name('user.dashboard');
});

Route::middleware('admn:admin')->group(function () {
    Route::get('/admin-dashboard', App\Http\Livewire\AdminDashboard::class)->name('admin.dashboard');
    Route::get('/opening-days', App\Http\Livewire\Station\OpeningDays::class)->name('opening.days.index');

    Route::get('/advert-type', App\Http\Livewire\Advert\AdvertType::class)->name('advert.type.index');
    Route::get('/adverts-index', App\Http\Livewire\Advert\AdvertIndex::class)->name('advert.index');
});

Route::get('/offline-index', App\Http\Livewire\Offline\Index::class)->name('offline.index');
