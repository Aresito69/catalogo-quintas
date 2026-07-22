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
    Schema::create('quintas', function (Blueprint $table) {
    $table->id();

    $table->string('nombre');
    $table->string('slug')->unique();
    $table->text('descripcion')->nullable();

    $table->unsignedSmallInteger('capacidad');
    $table->unsignedTinyInteger('habitaciones')->default(0);
    $table->unsignedTinyInteger('camas')->default(0);
    $table->decimal('banos', 3, 1)->default(0);

    $table->decimal('precio_fin_semana', 10, 2);
    $table->decimal('anticipo', 10, 2)->nullable();

    $table->string('ubicacion')->nullable();
    $table->string('mapa_url', 2048)->nullable();

    $table->time('hora_entrada')->nullable();
    $table->time('hora_salida')->nullable();

    $table->boolean('publicada')->default(false)->index();
    $table->boolean('destacada')->default(false)->index();
    $table->unsignedInteger('orden')->default(0);

    $table->timestamps();
    $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quintas');
    }
};
