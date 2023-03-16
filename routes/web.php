<?php

use App\Http\Controllers\CeremonyController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Route::get('/ceremonies', [CeremonyController::class, 'index'])->name('ceremonies.index');
    // Route::get('/ceremonies/form', [CeremonyController::class, 'form'])->name('ceremonies.form');

    Route::controller(CeremonyController::class)
        ->prefix('/ceremonies')
        ->name('ceremonies.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('{ceremony}/edit', 'edit')->name('edit');
            Route::get('/export', 'export')->name('export');
        });
});
