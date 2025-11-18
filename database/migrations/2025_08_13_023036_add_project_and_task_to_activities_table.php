<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')->nullable()->after('user_id');
            $table->unsignedBigInteger('task_id')->nullable()->after('project_id');
            $table->string('type')->nullable()->after('action');
            
            // Add foreign key constraints
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
            
            // Add indexes for better performance
            $table->index('project_id');
            $table->index('task_id');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropForeign(['task_id']);
            $table->dropIndex(['project_id']);
            $table->dropIndex(['task_id']);
            $table->dropIndex(['type']);
            $table->dropColumn(['project_id', 'task_id', 'type']);
        });
    }
};
