<?php

// database/migrations/xxxx_xx_xx_create_events_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location');
            $table->text('description');
            $table->date('date');
            $table->time('time');
            $table->unsignedBigInteger('standart_ticket_id')->nullable();
            $table->unsignedBigInteger('premium_ticket_id')->nullable();
            $table->unsignedBigInteger('vip_ticket_id')->nullable();
            $table->timestamps();

            // Define foreign key constraints if needed
            $table->foreign('standart_ticket_id')->references('id')->on('tickets')->onDelete('set null');
            $table->foreign('premium_ticket_id')->references('id')->on('tickets')->onDelete('set null');
            $table->foreign('vip_ticket_id')->references('id')->on('tickets')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('events');
    }
}
