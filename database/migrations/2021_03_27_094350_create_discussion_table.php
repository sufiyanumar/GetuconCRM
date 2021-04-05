<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscussionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discussions', function (Blueprint $table) {
            $table->id();
            $table->longText('message')->nullable();
            $table->unsignedBigInteger('user_id')->default('0');
            $table->unsignedBigInteger('ticket_id')->default('0');
            $table->unsignedBigInteger('org_id')->default('0');
            $table->unsignedBigInteger('is_private')->default('0');
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
        Schema::dropIfExists('discussion');
    }
}
