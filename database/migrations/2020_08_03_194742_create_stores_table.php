<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->char('id', 10)->unique()->primary();
            $table->unsignedInteger('owner_id');
            $table->string('name', 50);
            $table->char('code', 6)->unique();
            $table->text('store_logo');
            $table->string('phone', 15);
            $table->string('address');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('owner_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stores');
    }
}
