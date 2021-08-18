<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('employee_id')->index()->comment('Employee in charge');
            $table->foreign('employee_id')->references('id')->on('users')->onDelete('cascade');
            $table->tinyInteger('day')->comment('0:Domingo 1:Lunes 2:Martes 3:Miercoles 4:Jueves 5:Viernes 6:Sabado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('routes');
    }
}
