<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoteDistributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('note_distributions', function (Blueprint $table) {
            $table->id();
            $table->foreignID('note_id');
            $table->foreignID('sender_user_id')->nullable();
            $table->foreignID('sender_position_id')->nullable();
            $table->foreignID('receiver_user_id')->nullable();
            $table->foreignID('receiver_position_id')->nullable();
            $table->boolean('is_read')->default(false);
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
        Schema::dropIfExists('note_distributions');
    }
}
