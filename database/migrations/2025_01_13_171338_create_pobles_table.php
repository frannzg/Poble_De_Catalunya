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
        Schema::create('pobles', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('comarca');
            $table->string('provincia');
            $table->text('descripcio')->nullable();
            $table->string('foto')->nullable();
            $table->float('latitud')->nullable();
            $table->float('longitud')->nullable();
            $table->float('altitud')->nullable();
            $table->float('superficie')->nullable();
            $table->integer('poblacio')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pobles');
    }
};
