<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrganizationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organizations', function ($table) {
            $table->string('rating')->nullable()->change();
            $table->string('contract')->nullable()->change();
            $table->string('contract_frequency')->nullable()->change();
            $table->string('contract_start_date')->nullable()->change();
            $table->string('contract_end_date')->nullable()->change();
            $table->string('price')->nullable()->change();
            $table->string('transport_price')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
