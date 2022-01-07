<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('nom')->unique();
            $table->text('Prenom');
            $table->text('adresse');
            $table->text('telephone')->unique();
            $table->text('commentaire')->nullable();
            $table->text('source');
            $table->string('temperature');

            $table->unsignedBigInteger('id_createur');
            $table->foreign('id_createur')
            ->references('id')
            ->on('user')
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
        Schema::dropIfExists('clients');
    }
}
