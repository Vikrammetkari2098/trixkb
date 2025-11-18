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
        Schema::table('meetings', function (Blueprint $table) {
            // Improve existing columns
            $table->string('title', 255)->change(); // Increase from 50 to 255
            $table->text('description')->nullable()->change(); // Change from varchar(50) to text
            $table->string('location', 255)->nullable()->change(); // Increase from 50 to 255
            
            // Add new useful columns
            $table->text('agenda')->nullable()->after('description');
            $table->text('notes')->nullable()->after('agenda');
            $table->string('timezone', 50)->nullable()->after('end_time');
            $table->integer('max_participants')->nullable()->after('timezone');
            $table->boolean('is_recurring')->default(false)->after('max_participants');
            $table->json('recurring_pattern')->nullable()->after('is_recurring');
            $table->text('meeting_password')->nullable()->after('meeting_link');
            $table->boolean('requires_approval')->default(false)->after('meeting_password');
            $table->timestamp('reminder_sent_at')->nullable()->after('requires_approval');
            
            // Add indexes for better performance
            $table->index(['start_time', 'end_time']);
            $table->index(['is_recurring']);
            $table->index(['requires_approval']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('meetings', function (Blueprint $table) {
            // Remove indexes
            $table->dropIndex(['start_time', 'end_time']);
            $table->dropIndex(['is_recurring']);
            $table->dropIndex(['requires_approval']);
            
            // Remove new columns
            $table->dropColumn([
                'agenda',
                'notes', 
                'timezone',
                'max_participants',
                'is_recurring',
                'recurring_pattern',
                'meeting_password',
                'requires_approval',
                'reminder_sent_at'
            ]);
            
            // Revert column changes (note: this may truncate data)
            $table->string('title', 50)->change();
            $table->string('description', 50)->nullable()->change();
            $table->string('location', 50)->nullable()->change();
        });
    }
};
