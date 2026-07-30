<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invio_listes', function (Blueprint $table) {
            $table->id();
            // Si collega alla tabella invios
            $table->foreignId('invio_id')->constrained('invios')->cascadeOnDelete();
            // Si collega alla tabella delle liste esistente 
            $table->foreignId('liste_id')->constrained('listes')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invio_listes');
    }
};