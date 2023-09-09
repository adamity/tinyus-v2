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
        // Original URLs
        // - id: Integer, Primary Key
        // - url: String, Not Null
        // - shortened_url_id: Integer, Not Null
        // - created_at: DateTime, Not Null
        // - updated_at: DateTime, Not Null
        // - deleted_at: DateTime, Nullable
        Schema::create('original_urls', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->unsignedBigInteger('shortened_url_id');
            $table->foreign('shortened_url_id')->references('id')->on('shortened_urls');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('original_urls');
    }
};
