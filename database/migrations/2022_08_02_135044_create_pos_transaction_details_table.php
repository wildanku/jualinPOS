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
        Schema::create('pos_transaction_details', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('pos_transaction_id');
            $table->foreignId('product_id')->nullable();
            $table->string('product_name')->nullable();
            $table->foreignId('custom_product_id')->nullable();
            $table->string('custom_product_name')->nullable();
            $table->double('amount', 20, 0)->nullable();
            $table->double('price', 20, 0)->nullable();
            $table->double('total', 20, 0)->nullable();
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
        Schema::dropIfExists('pos_transaction_details');
    }
};
