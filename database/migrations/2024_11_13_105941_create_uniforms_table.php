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
        Schema::create('uniforms', function (Blueprint $table) {
             $table->id();
            $table->string('name'); // Name of the item (e.g., "Fabric")
            $table->longText('description'); // Description (e.g., "White polo and black pants")
            $table->integer('price')->nullable(); // Price of the item (e.g., 500)
            $table->string('image_url')->nullable();
            $table->string('status')->default('available'); 
            $table->timestamps();
        });
     
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
         Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('uniform_id');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('uniform_id')->references('id')->on('uniforms')->onDelete('cascade');
            $table->date('reservation_date');
            $table->date('scheduled_purchase_date');
            $table->enum('status', ['pending', 'confirmed', 'completed'])->default('pending');            
            $table->timestamps();
        });
        Schema::create('reservation', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->unsignedBigInteger('user_id'); // Foreign key for the user making the reservation
            $table->foreign('user_id')->references('id')->on('students')->onDelete('cascade');
            $table->string('full_name');
            $table->string('email');
            $table->bigInteger('contact_number')->nullable();
            $table->string('image_url');
            $table->string('name');
            $table->integer('price');
            $table->string('variation_type')->nullable();
            $table->string('size')->nullable();
            $table->integer('qty');
            $table->integer('subTotal')->nullable();
            
            $table->integer('total_price');
            $table->timestamps();
        });
        Schema::create('student_reservation', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('order_id');
            $table->integer('qrcode_id')->nullable();
            $table->foreign('user_id')->references('id')->on('students')->onDelete('cascade');
            $table->string('full_name');
            $table->string('email');
            $table->bigInteger('contact_number')->nullable();
            $table->string('name');
            $table->string('department')->nullable();
            $table->string('size')->nullable();
            $table->integer('subTotal');
            $table->integer('qty');
            $table->integer('total_price');
            $table->date('reservation_date');
            $table->string('pay_method');
            $table->string('status')->default('pending'); 
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
        Schema::dropIfExists('uniforms');
        Schema::dropIfExists('reservations');
        Schema::dropIfExists('students');
    }
};
