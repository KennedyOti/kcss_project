<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCasesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('cases', function (Blueprint $table) {
            $table->id();
            $table->string('client_name'); // This will be auto-filled with the logged-in user's name
            $table->text('description');
            $table->unsignedBigInteger('assigned_staff_id');
            $table->enum('status', ['pending', 'in_progress', 'resolved'])->default('pending');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('attachments')->nullable(); // JSON for multiple file paths
            $table->timestamps();

            $table->foreign('assigned_staff_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('cases');
    }
}
