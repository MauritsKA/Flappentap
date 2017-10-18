<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMutations2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mutations2', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mutation_count');
            $table->integer('company_id');
            $table->integer('version_id');
            $table->integer('user_id');
            $table->datetime('dated_at')->nullable();
            $table->float('size',99,2)->nullable();
            $table->string('description')->nullable();
            $table->integer('item_id')->nullable();
            $table->integer('mutationtype_id')->nullable();
            $table->integer('vattype_id')->nullable();
            $table->float('basic_size',99,2)->nullable();
            $table->float('vat_size',99,2)->nullable();
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
        Schema::dropIfExists('mutations2');
    }
}
