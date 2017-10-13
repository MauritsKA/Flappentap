<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBalanceUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balance_user', function (Blueprint $table) {
            $table->integer('balance_id');
            $table->integer('user_id');
            $table->primary(['balance_id','user_id']);
        });
    }

   
    public function down()
    {
        Schema::dropIfExists('balance_user');
    }
}
