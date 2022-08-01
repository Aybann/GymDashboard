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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('add_customers');
            $table->string('add_equipments');
            $table->string('add_subscriptions');
            $table->string('add_payments');

            $table->string('update_customers');
            $table->string('update__equipments');
            $table->string('update__subscriptions');
            $table->string('update__payments');

            $table->string('delete_customers');
            $table->string('delete__equipments');
            $table->string('delete___subscriptions');
            $table->string('delete__payments');
         
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
        Schema::dropIfExists('permissions');
    }
};
