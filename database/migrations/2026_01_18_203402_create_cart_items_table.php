<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
        protected $fillable = ['units','cart_id','product_id','product_name','product_price'];

    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->integer('units');
            $table->foreignId('user_id')->index();
            $table->foreignId('product_id')->index();
            $table->string('product_name');
            $table->string('product_price');
            $table->boolean('bought')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
