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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('account_id');
            $table->enum('type',['income','expense']);
            $table->string('transaction_type')->nullable();
            $table->double('amount',20,2)->default(0);
            $table->dateTimeTz('paid_at')->nullable();
            $table->string('reference')->nullable();
            $table->string('document_id')->nullable();
            $table->boolean('is_reconcile')->default(0);
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
        Schema::dropIfExists('transactions');
    }
};
