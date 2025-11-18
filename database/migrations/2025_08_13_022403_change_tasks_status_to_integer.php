<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, let's check and clean any invalid status values
        DB::statement("UPDATE tasks SET status = '1' WHERE status NOT IN ('1', '2', '3', '4')");
        
        // First, fix the task_statuses table to have proper primary key
        Schema::table('task_statuses', function (Blueprint $table) {
            $table->primary('id');
        });
        
        // Change the status column from varchar to unsigned integer
        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedInteger('status')->change();
        });
        
        // Add foreign key constraint
        Schema::table('tasks', function (Blueprint $table) {
            $table->foreign('status')->references('id')->on('task_statuses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['status']);
        });
        
        Schema::table('tasks', function (Blueprint $table) {
            // Change back to varchar
            $table->string('status', 50)->change();
        });
    }
};
