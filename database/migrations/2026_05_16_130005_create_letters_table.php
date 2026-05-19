<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('letters', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('complaint_id');
            $table->ulid('template_id')->nullable();
            $table->string('letter_number')->unique(); // SRT/{dept}/{seq}/{month}/{year}
            $table->string('subject');
            $table->longText('body');
            $table->ulid('signature_id')->nullable();
            $table->timestamp('signed_at')->nullable();
            $table->string('pdf_path')->nullable();
            $table->enum('status', ['draft', 'signed', 'sent'])->default('draft');
            $table->ulid('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('complaint_id')
                ->references('id')
                ->on('complaints')
                ->onDelete('restrict');

            $table->foreign('template_id')
                ->references('id')
                ->on('letter_templates')
                ->onDelete('set null');

            $table->foreign('signature_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });

        // Update complaints to add FK to letters
        Schema::table('complaints', function (Blueprint $table) {
            $table->foreign('response_letter_id')
                ->references('id')
                ->on('letters')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropForeign(['response_letter_id']);
        });
        Schema::dropIfExists('letters');
    }
};
