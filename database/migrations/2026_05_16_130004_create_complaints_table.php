<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('tracking_code', 14)->unique(); // PPID-XXXX-XXXX
            $table->string('complainant_name', 100);
            $table->string('complainant_email');
            $table->string('complainant_phone', 20);
            $table->text('complainant_address');
            $table->string('subject', 200);
            $table->longText('description');
            $table->enum('category', ['permohonan_informasi', 'pengaduan', 'saran']);
            $table->enum('status', ['pending', 'processing', 'approved', 'rejected', 'completed'])->default('pending');
            $table->json('attachment_media_ids')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->ulid('processed_by')->nullable();
            $table->ulid('response_letter_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('processed_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->index(['tracking_code', 'status', 'submitted_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
