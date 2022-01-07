<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatutdevisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('statutdevis', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('temperature');
            $table->datetime('date');
            $table->string('statut');

            $table->unsignedBigInteger('id_devis');
            $table->foreign('id_devis')
            ->references('id')
            ->on('devisfacture')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statutdevis');
    }
}
