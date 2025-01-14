<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pobles', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('comarca');
            $table->string('provincia');
            $table->text('descripcio')->nullable();
            $table->string('foto')->nullable();
            $table->decimal('latitud', 10, 6)->nullable();
            $table->decimal('longitud', 10, 6)->nullable();
            $table->integer('altitud')->nullable();
            $table->decimal('superficie', 8, 2)->nullable();
            $table->integer('poblacio')->nullable();
            $table->string('codi');
            $table->string('codiComarca');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pobles');
    }
};
