<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchasments', function (Blueprint $table) {
            $table->char('id', 20)->unique()->primary(); // PCM2008-000000000001
            $table->string('name', 100);
            $table->integer('quantity');
            $table->integer('price');
            $table->date('date');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchasments');
    }
}
