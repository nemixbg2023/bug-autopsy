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
        Schema::create('bug_entries', function (Blueprint $table) {
            $table->id();

            $table->foreignId('bug_report_id')->constrained()->cascadeOnDelete();
            $table->string('type');
            $table->text('content');
            $table->string('evidence')->nullable();

            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bug_entries');
    }
};
