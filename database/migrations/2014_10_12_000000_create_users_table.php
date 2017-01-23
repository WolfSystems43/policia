<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('name');
            $table->string('steamid')->unique();
            $table->string('email')->unique()->nullable();
            $table->string('profile')->nullable();
            $table->string('password')->nullable();
            $table->integer('corp')->default(0);
            $table->integer('rank')->default(1);
            $table->boolean('disabled')->default(false);
            $table->boolean('admin')->default(false);
            $table->integer('shop')->default(1);
            $table->text('shop_reason')->nullable();
            $table->rememberToken();
            $table->dateTime('active_at')->nullable();
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
        Schema::dropIfExists('users');
    }
}
