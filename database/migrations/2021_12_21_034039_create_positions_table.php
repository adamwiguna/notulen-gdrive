<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('alias')->nullable();
            $table->foreignID('division_id')->nullable();
            $table->foreignID('organization_id')->nullable();
            $table->boolean('is_staff')->default(false);
            // $table->boolean('can_view_note_in_division')->default(false);
            $table->boolean('can_view_note_in_organization')->default(false);
            $table->boolean('can_share_note')->default(false);
            $table->boolean('can_view_shared_note')->default(false);
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
        Schema::dropIfExists('positions');
    }
}
