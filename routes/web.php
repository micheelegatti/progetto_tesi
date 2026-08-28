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
    Route::delete('dashboard/campagna/{id}', [App\Http\Controllers\CampagnaController::class, 'delete']);
    //Rotta per test funzionante con MailPit
    Route::get('dashboard/campagna/{id}/invia-test', [App\Http\Controllers\CampagnaController::class, 'inviaTest']);


    // rotte per i template - TemplateController
    Route::get('dashboard/template', [App\Http\Controllers\TemplateController::class, 'index'])->name('template');
    Route::get('dashboard/template/crea', [App\Http\Controllers\TemplateController::class, 'nuovoTemplate']);
    Route::post('dashboard/template', [App\Http\Controllers\TemplateController::class, 'store']);
    Route::get('dashboard/template/{id}/modifica', [App\Http\Controllers\TemplateController::class, 'edit']);
    Route::put('dashboard/template/{id}', [App\Http\Controllers\TemplateController::class, 'update']);
    Route::delete('dashboard/template/{id}', [App\Http\Controllers\TemplateController::class, 'delete']);

    //rotte per la sezione destinatari
    //pagina contatti come landingPage
    Route::get('dashboard/destinatari/contatti', [App\Http\Controllers\DestinatariController::class, 'index'])->name('destinatari');
    Route::get('dashboard/destinatari/import/{id}/edit', [App\Http\Controllers\DestinatariController::class, 'edit']);
    Route::put('dashboard/destinatari/import/{id}', [App\Http\Controllers\DestinatariController::class, 'update']);
    Route::delete('dashboard/destinatari/contatti/{id}', [App\Http\Controllers\DestinatariController::class, 'delete']);
    //aggiunta contatto a una lista
    Route::get('dashboard/destinatari/contatti/{id}/liste', [App\Http\Controllers\DestinatariController::class, 'listeContatto']);
    Route::put('/dashboard/destinatari/contatti/{id}/liste', [App\Http\Controllers\DestinatariController::class, 'updateListeContatto']);
    

    //rotte per import
    Route::get('dashboard/destinatari/import', [App\Http\Controllers\DestinatariController::class, 'indexImport']);
    Route::get('dashboard/destinatari/import/contatto', [App\Http\Controllers\DestinatariController::class, 'create']);
    Route::post('dashboard/destinatari/import/contatto', [App\Http\Controllers\DestinatariController::class, 'store']);
    Route::get('dashboard/destinatari/import/lista', [App\Http\Controllers\DestinatariController::class, 'showImport']);
    Route::post('dashboard/destinatari/import/lista', [App\Http\Controllers\DestinatariController::class, 'storeImport']);

    //rotte per liste
    Route::get('dashboard/destinatari/liste', [App\Http\Controllers\ListaController::class, 'index']);
    Route::get('dashboard/destinatari/liste/crea', [App\Http\Controllers\ListaController::class, 'create']);
    Route::post('dashboard/destinatari/liste', [App\Http\Controllers\ListaController::class, 'store']);
    Route::get('dashboard/destinatari/liste/{id}/edit', [App\Http\Controllers\ListaController::class, 'edit']);
    Route::put('dashboard/destinatari/liste/{id}', [App\Http\Controllers\ListaController::class, 'update']);
    Route::delete('dashboard/destinatari/liste/{id}', [App\Http\Controllers\ListaController::class, 'delete']);

    //Rotte per Invio
    //Ordinario
    Route::get('dashboard/campagna/{id}/riepilogo', [App\Http\Controllers\InvioController::class, 'index']);
    Route::post('dashboard/campagna/invio', [App\Http\Controllers\InvioController::class, 'store']);

    //Rotte per le statistiche - StatisticheController
    Route::get('dashboard/statistiche', [App\Http\Controllers\StatisticheController::class, 'index'])->name('statistiche');
    Route::get('dashboard/statistiche/{id}', [App\Http\Controllers\StatisticheController::class, 'statisticheInvio']);

    //Rotte per ricezione webhook
    Route::post('/webhooks/brevo', [App\Http\Controllers\WebhookController::class, 'handleBrevo']);
});

require __DIR__.'/settings.php';