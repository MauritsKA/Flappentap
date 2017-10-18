<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVersions2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('versions2', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mutation_id');
            $table->integer('version_count');
            $table->integer('updatetype_id');
            $table->integer('user_id');
            $table->datetime('dated_at')->nullable();
            $table->float('size',99,2)->nullable();
            $table->string('description')->nullable();
            $table->integer('item_id')->nullable();
            $table->integer('mutationtype_id')->nullable();
            $table->integer('vattype_id')->nullable();
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
        Schema::dropIfExists('versions2');
    }
}
