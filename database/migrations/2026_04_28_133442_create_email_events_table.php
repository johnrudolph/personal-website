<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_events', function (Blueprint $table) {
            $table->id();
            $table->string('record_type');
            $table->string('postmark_message_id')->nullable()->index();
            $table->string('email')->nullable()->index();
            $table->foreignId('subscriber_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('newsletter_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('newsletter_recipient_id')->nullable()->constrained()->nullOnDelete();
            $table->json('payload');
            $table->timestamp('received_at');
            $table->timestamps();

            $table->index('record_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_events');
    }
};
