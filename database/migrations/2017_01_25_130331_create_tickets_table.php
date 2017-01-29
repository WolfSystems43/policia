<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type')->default(3);
            $table->string('title');
            $table->text('body');
            $table->boolean('anonymous')->default(false);
            $table->integer('user_id');
            $table->boolean('closed')->default(false);
            $table->boolean('hidden')->default(false);
            $table->dateTime('closed_at')->nullable();
            $table->integer('result')->default(0);
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
        Schema::dropIfExists('tickets');
    }
}
