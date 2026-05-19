<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Create contact_messages table
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->text('message');
            $table->timestamps();
        });

        // 2. Insert or update standard settings for the contact page
        $settings = [
            [
                'key' => 'contact_address',
                'value' => 'Gedung Pusat Pemerintahan, Jl. Jend. Sudirman No. 1, Jakarta',
                'type' => 'text',
                'group' => 'contact',
            ],
            [
                'key' => 'contact_phone',
                'value' => '(021) 1234-5678',
                'type' => 'string',
                'group' => 'contact',
            ],
            [
                'key' => 'contact_email',
                'value' => 'ppid@instansi.go.id',
                'type' => 'string',
                'group' => 'contact',
            ],
            [
                'key' => 'contact_map_embed',
                'value' => 'https://maps.google.com/maps?q=Gedung%20Pusat%20Pemerintahan,%20Jl.%20Jend.%20Sudirman%20No.%201,%20Jakarta&t=&z=15&ie=UTF8&iwloc=&output=embed',
                'type' => 'text',
                'group' => 'contact',
            ],
        ];

        foreach ($settings as $setting) {
            \App\Models\Setting::updateOrCreate(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'type' => $setting['type'],
                    'group' => $setting['group'],
                ]
            );
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
    }
};
