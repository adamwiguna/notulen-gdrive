<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id(); 
            $table->string('slug')->unique();
            $table->string('title');
            $table->foreignID('user_id');
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->foreignID('position_id')->nullable();
            // $table->foreignID('division_id')->nullable();
            $table->foreignID('organization_id')->nullable();
            $table->string('organizer');
            $table->text('content');
            $table->date('date');
            $table->softDeletes();
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
        Schema::dropIfExists('notes');
    }
}
