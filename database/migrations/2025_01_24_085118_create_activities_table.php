<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('activity_name');
            $table->string('organization')->nullable(); // Allow null if no value is provided
            $table->text('activity_description');
            $table->string('location');
            $table->enum('status', ['in_progress', 'cancelled', 'completed'])->default('in_progress');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('actual_beneficiaries');
            $table->integer('expected_beneficiaries');
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
        Schema::dropIfExists('activities');
    }
}
