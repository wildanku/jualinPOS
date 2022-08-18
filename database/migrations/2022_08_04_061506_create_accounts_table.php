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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->foreignId('account_type_id');
            $table->json('additional_data')->nullable();
            $table->boolean('isLock')->default(1);
            $table->dateTimeTz('archived_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('taxes', function(Blueprint $table) {
            $table->foreignId('account_id')->nullable();
        });

        Schema::table('payment_methods', function(Blueprint $table) {
            $table->foreignId('account_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');

        Schema::table('taxes', function(Blueprint $table) {
            $table->dropColumn('account_id');
        });

        Schema::table('payment_methods', function(Blueprint $table) {
            $table->dropColumn('account_id');
        });
    }
};
