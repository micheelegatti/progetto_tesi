<?php

use Illuminate\Support\Facades\Route;

//mi passa al login se c'è bisogno
Route::get('/', function () {
    return redirect()->route('login');
})->name('home');


//ROTTE PRIVATE
Route::middleware(['auth', 'verified'])->group(function () {
    //rotta dal login alla home/dashboard
    Route::get('dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    //rotte per caricamento VUE della dashboard
    Route::get('dashboard/campagna', [App\Http\Controllers\CampagnaController::class, 'index'])->name('campagna');
    Route::get('dashboard/template', [App\Http\Controllers\TemplateController::class, 'index'])->name('template');
});

require __DIR__.'/settings.php';
