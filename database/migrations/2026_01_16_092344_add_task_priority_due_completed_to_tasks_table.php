<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {

            // Task importance
            $table->enum('priority', ['low', 'medium', 'high'])
                ->default('medium')
                ->after('description');

            // Deadline of task
            $table->date('due_date')
                ->nullable()
                ->after('priority');

            // When task was completed
            $table->timestamp('completed_at')
                ->nullable()
                ->after('status');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn(['priority', 'due_date', 'completed_at']);
        });
    }
};
