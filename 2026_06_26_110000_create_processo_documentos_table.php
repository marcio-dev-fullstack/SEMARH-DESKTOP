<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('processo_documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('processo_licenciamento_id')->constrained('processos_licenciamento')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('name');
            $table->string('path');
            $table->timestamps();
        });
    }
};