<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   Schema::disableForeignKeyConstraints();
        Schema::create('client_user', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('valide');
            $table->text('commentaire');
            $table->dateTime('datetransfert');
            $table->text('motif');

            $table->unsignedBigInteger('id_client');
            $table->foreign('id_client')
            ->references('id')
            ->on('client')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->unsignedBigInteger('id_user_exp');
            $table->foreign('id_user_exp')
            ->references('id')
            ->on('user')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->unsignedBigInteger('id_user_dest');
            $table->foreign('id_user_dest')
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
        Schema::dropIfExists('client_user');
    }
}
