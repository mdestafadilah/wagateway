<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blasts', function (Blueprint $table) {
            $table->id();
           $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
           $table->string('receiver');
           $table->text('message');
           $table->enum('type',['text','button','image','template']);
           $table->enum('status',['failed','success']);
         
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
        Schema::dropIfExists('blasts');
    }
}
