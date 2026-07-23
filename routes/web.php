<?php

use Illuminate\Support\Facades\Route;

//SOVRASCRIVIAMO IL LOGIN: Forza Laravel a mostrare la vista Blade invece di Inertia
Route::get('login', function () {
    return view('auth.login'); // Cercherà resources/views/auth/login.blade.php
})->name('login');

// Mi passa al login se c'è bisogno
Route::get('/', function () {
    return redirect()->route('login');
})->name('home');


// ROTTE PRIVATE
Route::middleware(['auth', 'verified'])->group(function () {
    // rotta dal login alla home/dashboard
    //PROVVISORIAMENTE USO IL PASSAGGIO ALLA CAMPAGNA
    Route::get('dashboard', [App\Http\Controllers\CampagnaController::class, 'index'])->name('dashboard');

    //Rotte per le campagne - CampagnaController
    Route::get('dashboard/campagna', [App\Http\Controllers\CampagnaController::class, 'index'])->name('campagna');
    Route::get('dashboard/campagna/info', [App\Http\Controllers\CampagnaController::class, 'infoCampagna']);
    Route::post('dashboard/campagna/store', [App\Http\Controllers\CampagnaController::class, 'storeInfo']);
    Route::get('dashboard/campagna/{id}', [App\Http\Controllers\CampagnaController::class, 'getCampagna']);
    Route::put('dashboard/campagna/{id}', [App\Http\Controllers\CampagnaController::class, 'update']);

    // rotte per i template - TemplateController
    Route::get('dashboard/template', [App\Http\Controllers\TemplateController::class, 'index'])->name('template');
    Route::get('dashboard/template/crea', [App\Http\Controllers\TemplateController::class, 'nuovoTemplate']);
    Route::post('dashboard/template', [App\Http\Controllers\TemplateController::class, 'store']);
    Route::get('dashboard/template/{id}/modifica', [App\Http\Controllers\TemplateController::class, 'edit']);
    Route::put('dashboard/template/{id}', [App\Http\Controllers\TemplateController::class, 'update']);
});

require __DIR__.'/settings.php';