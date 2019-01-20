<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObiektsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obiekts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->integer('user_id')->unsigned(); //klucz obcy, unsigned czyli dodatnie wartości
            //klucz obcy czyli user_id odnosi się do id w tabeli users,
            //onDelete czyli usuwanie kaskadowe, jeśli usuniemy użytkownika to też wszystkie jego powiadomienia
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            //2 klucz obcy dla miast (jeśli usuniemy miasto obiekty z miastem zostaną usunięte)
            $table->integer('city_id')->unsigned();
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('obiekts');
    }
}
