<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campagna_id')->constrained()->cascadeOnDelete();
            
            $table->string('oggetto');
            $table->string('sommario')->nullable();
            $table->text('note')->nullable();
            $table->json('tags')->nullable();
            
            $table->string('email_mittente');
            $table->string('email_risposta')->nullable();
            $table->string('tipo');
            $table->dateTime('data_invio')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invios');
    }
};