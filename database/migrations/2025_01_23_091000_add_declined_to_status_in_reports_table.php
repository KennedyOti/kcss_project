<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeclinedToStatusInReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reports', function (Blueprint $table) {
            // Modify the enum column to add the 'declined' value
            $table->enum('status', ['submitted', 'under_review', 'approved', 'declined'])
                ->default('submitted')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reports', function (Blueprint $table) {
            // Revert the status column to its original state
            $table->enum('status', ['submitted', 'under_review', 'approved'])
                ->default('submitted')
                ->change();
        });
    }
}
