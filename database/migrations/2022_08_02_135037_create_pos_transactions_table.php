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
        Schema::create('pos_transactions', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('code');
            $table->string('type')->nullable();
            $table->unsignedBigInteger('operator_id');
            $table->double('total',20,0)->default(0);
            $table->double('discount',20,0)->default(0);
            $table->double('tax', 20,0)->default(0);
            $table->double('grandTotal',20,0)->default(0);
            $table->unsignedBigInteger('payment_method_id')->default(0);
            $table->double('cash_amount', 20, 2)->default(0);
            $table->double('change_amount', 20, 2)->default(0);
            $table->json('product_detail')->nullable();
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
        Schema::dropIfExists('pos_transactions');
    }
};
