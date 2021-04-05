<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets_status', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ticket_id')->default('0');
            $table->unsignedBigInteger('status')->default('0');
            $table->unsignedBigInteger('add_by', '0');
            $table->string('add_ip', '0');
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
        Schema::dropIfExists('tickets_status');
    }
}
