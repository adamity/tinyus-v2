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
        // Shortened URLs
        // - id: Integer, Primary Key
        // - hash: String, Not Null
        // - max_clicks: Integer, Nullable
        // - expired_at: DateTime, Nullable
        // - created_at: DateTime, Not Null
        // - updated_at: DateTime, Not Null
        // - deleted_at: DateTime, Nullable
        Schema::create('shortened_urls', function (Blueprint $table) {
            $table->id();
            $table->string('hash');
            $table->integer('max_clicks')->nullable();
            $table->dateTime('expired_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shortened_urls');
    }
};
