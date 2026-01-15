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
        Schema::table('dtr_logs', function (Blueprint $table) {
            $table->decimal('break_hours', 5, 2)->default(0)->after('time_out');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dtr_logs', function (Blueprint $table) {
            $table->dropColumn('break_hours');
        });
    }
};
