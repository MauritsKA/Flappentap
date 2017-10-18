<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMutationUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('mutation_user', function (Blueprint $table) {
            $table->integer('mutation_id');
            $table->integer('user_id');
            $table->primary(['mutation_id','user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
          Schema::dropIfExists('mutation_user');
    }
}
