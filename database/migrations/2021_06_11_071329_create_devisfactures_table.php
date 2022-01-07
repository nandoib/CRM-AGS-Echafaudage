<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevisfacturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devisfactures', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->datetime('date');
            $table->string('montant');
            $table->string('facture_ou_devis');
            
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')
            ->references('id')
            ->on('user') 
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->unsignedBigInteger('id_client');
            $table->foreign('id_client')
            ->references('id')
            ->on('client')
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
        Schema::dropIfExists('devisfactures');
    }
}
