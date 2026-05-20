<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstitutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('institutions', function (Blueprint $table) {
            $table->id();
            $table->string('institution_name');
            $table->integer('registration_fee');
            $table->integer('instalation_fee');
            $table->integer('monthly_payment_id');
            $table->integer('No_of_computers');
            $table->integer('lan_nodes');
            $table->integer('lan_nodes_amount');
            $table->integer('monthlyPayment_id');
            $table->integer('fine')->nullable();
            $table->integer('reconnection_fee')->nullable();
            $table->integer('defaulters_status')->nullable();
            $table->integer('connection_status')->nullable();
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
        Schema::dropIfExists('institutions');
    }
}
