<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutorepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autoreplies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('device',20);
            $table->string('keyword');
            $table->enum('type',['text','image','button','template']);
            $table->json('reply');
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
        Schema::dropIfExists('autoreplies');
    }
}
