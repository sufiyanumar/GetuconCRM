<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->longText('translate')->nullable();
            $table->unsignedBigInteger('org_id')->default('0');
            $table->unsignedBigInteger('user')->default('0');
            $table->unsignedBigInteger('personnel')->default('0');
            $table->integer('status_id')->default('0');
            $table->date('due_date');
            $table->integer('priority')->default('0');
            $table->integer('category')->default('0');
            $table->integer('good_will')->default('0');
            $table->string('coding')->nullable();
            $table->string('consulting')->nullable();
            $table->string('testing')->nullable();
            $table->integer('transport_price')->nullable();
            $table->unsignedBigInteger('add_by', '0');
            $table->string('add_ip', '0');
            $table->unsignedBigInteger('update_by', '0');
            $table->string('update_ip', '0');
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
        Schema::dropIfExists('tickets');
    }
}
