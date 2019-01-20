<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('content');
            $table->boolean('status');
            $table->boolean('shown')->default(false);
            $table->integer('user_id')->unsigned(); //klucz obcy, unsigned czyli dodatnie wartości
            //klucz obcy czyli user_id odnosi się do id w tabeli users,
            //onDelete czyli usuwanie kaskadowe, jeśli usuniemy użytkownika to też wszystkie jego powiadomienia
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
