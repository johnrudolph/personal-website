<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmailEvent extends Model
{
    protected $fillable = [
        'record_type',
        'postmark_message_id',
        'email',
        'subscriber_id',
        'newsletter_id',
        'newsletter_recipient_id',
        'payload',
        'received_at',
    ];

    protected $casts = [
        'payload' => 'array',
        'received_at' => 'datetime',
    ];

    public function subscriber(): BelongsTo
    {
        return $this->belongsTo(Subscriber::class);
    }

    public function newsletter(): BelongsTo
    {
        return $this->belongsTo(Newsletter::class);
    }

    public function newsletterRecipient(): BelongsTo
    {
        return $this->belongsTo(NewsletterRecipient::class);
    }
}
