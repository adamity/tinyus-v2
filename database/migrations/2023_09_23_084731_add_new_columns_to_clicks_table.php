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
        Schema::table('clicks', function (Blueprint $table) {
            $table->string('operating_system')->nullable()->after('referrer');
            $table->string('operating_system_version')->nullable()->after('operating_system');
            $table->string('browser')->nullable()->after('operating_system_version');
            $table->string('browser_version')->nullable()->after('browser');
            $table->boolean('is_mobile')->nullable()->after('browser_version');
            $table->boolean('is_tablet')->nullable()->after('is_mobile');
            $table->boolean('is_desktop')->nullable()->after('is_tablet');
            $table->boolean('is_phone')->nullable()->after('is_desktop');
            $table->string('country')->nullable()->after('is_phone');
            $table->string('city')->nullable()->after('country');
            $table->string('region')->nullable()->after('city');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clicks', function (Blueprint $table) {
            $table->dropColumn('operating_system');
            $table->dropColumn('operating_system_version');
            $table->dropColumn('browser');
            $table->dropColumn('browser_version');
            $table->dropColumn('is_mobile');
            $table->dropColumn('is_tablet');
            $table->dropColumn('is_desktop');
            $table->dropColumn('is_phone');
            $table->dropColumn('country');
            $table->dropColumn('city');
            $table->dropColumn('region');
        });
    }
};
