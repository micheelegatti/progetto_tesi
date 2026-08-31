<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_invii', function (Blueprint $table) {
            $table->id();
            // Chiave esterna che collega il log alla tabella delle campagne
            $table->foreignId('invio_id')->constrained('invios')->onDelete('cascade');
            $table->string('email_destinatario');
            //Stato di consegna (sempre webhook)
            $table->enum('esito_consegna', ['In Attesa', 'Inviato', 'Consegnato', 'Rimbalzato', 'Invio Bloccato'])->default('In Attesa');

            //webhook avanzati per analisi
            $table->boolean('is_aperto')->default(false);
            $table->boolean('is_cliccato')->default(false);
            $table->boolean('is_disiscritto')->default(false); // Fondamentale per la suppression list del marketing
            $table->boolean('is_spam')->default(false);        // Segnalazione di spam

            //timestamp associati ai webhook
            $table->timestamp('consegnato_il')->nullable();
            $table->timestamp('aperto_il')->nullable();
            $table->timestamp('cliccato_il')->nullable();
            $table->timestamp('disiscritto_il')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_invii');
    }
};