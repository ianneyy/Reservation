<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Foreign key for the user making the reservation
            $table->foreign('user_id')->references('id')->on('students')->onDelete('cascade');
            $table->string('cart_id')->nullable();
            $table->string('image_url');
            $table->string('name');
            $table->integer('price');
            $table->string('variation_type')->nullable();
            $table->string('size')->nullable();
            $table->integer('qty');
            $table->integer('total_price');
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
        Schema::dropIfExists('cart');
    }
};
