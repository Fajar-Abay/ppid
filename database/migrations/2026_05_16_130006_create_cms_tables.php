<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('link_url')->nullable();
            $table->string('button_text')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->enum('display_location', ['homepage', 'sidebar', 'footer'])->default('homepage');
            $table->timestamps();
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->enum('type', ['string', 'text', 'image', 'boolean', 'json'])->default('string');
            $table->enum('group', ['general', 'contact', 'social', 'appearance', 'legal'])->default('general');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
        Schema::dropIfExists('banners');
    }
};
