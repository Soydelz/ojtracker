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
        // Add face descriptor to users table
        Schema::table('users', function (Blueprint $table) {
            $table->text('face_descriptor')->nullable()->after('cover_photo');
        });

        // Add face photo and confidence to dtr_logs table
        Schema::table('dtr_logs', function (Blueprint $table) {
            $table->string('face_photo')->nullable()->after('notes');
            $table->decimal('face_confidence', 5, 2)->nullable()->after('face_photo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('face_descriptor');
        });

        Schema::table('dtr_logs', function (Blueprint $table) {
            $table->dropColumn(['face_photo', 'face_confidence']);
        });
    }
};
