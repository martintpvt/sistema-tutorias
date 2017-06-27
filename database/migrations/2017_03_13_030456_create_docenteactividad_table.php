<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocenteactividadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('docenteactividad', function (Blueprint $table) {
            $table->integer('Id_Docente');
            $table->integer('Id_Ubicacion');
            $table->integer('Id_Actividad');
            
            $table->unique(['Id_Docente', 'Id_Ubicacion']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("docenteactividad");
    }
}
