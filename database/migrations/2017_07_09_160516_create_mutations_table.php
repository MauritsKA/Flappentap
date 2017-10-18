<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMutationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mutations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mutation_count');
            $table->integer('balance_id');
            $table->integer('version_id');
            $table->integer('user_id');
            $table->datetime('dated_at')->nullable();
            $table->float('size',99,2)->nullable();
            $table->string('description')->nullable();
            $table->boolean('show');
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
        Schema::dropIfExists('mutations');
    }
}
