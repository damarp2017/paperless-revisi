<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->char('id', 10)->unique()->primary();
            $table->char('api_token', 80);
            $table->string('fcm_token')->nullable();
            $table->string('name', 50);
            $table->text('image')->nullable();
            $table->string('email', 30)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->char('password', 60);
            $table->rememberToken();
            $table->timestamps();
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
        Schema::dropIfExists('users');
    }
}
