<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('title'); // Report title
            $table->date('date_of_report'); // Date of the report
            $table->string('file_path', 2048); // File path for the uploaded report
            $table->unsignedBigInteger('user_id'); // User ID of the report submitter
            $table->enum('status', ['submitted', 'under_review', 'approved'])->default('submitted'); // Report status
            $table->timestamps(); // Created at & Updated at timestamps

            // Foreign key constraint
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade'); // Delete reports if the user is deleted
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
