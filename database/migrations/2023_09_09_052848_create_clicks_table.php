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
        // Clicks
        // - id: Integer, Primary Key
        // - shortened_url_id: Integer, Not Null
        // - ip_address: String, Not Null
        // - user_agent: String, Not Null
        // - created_at: DateTime, Not Null
        // - updated_at: DateTime, Not Null
        // - deleted_at: DateTime, Nullable
        Schema::create('clicks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shortened_url_id');
            $table->foreign('shortened_url_id')->references('id')->on('shortened_urls');
            $table->string('ip_address');
            $table->string('user_agent');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clicks');
    }
};
