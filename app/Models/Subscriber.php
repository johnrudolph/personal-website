<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Subscriber extends Model
{
    use HasFactory;

    public const STATUS_SUBSCRIBED = 'subscribed';
    public const STATUS_UNSUBSCRIBED = 'unsubscribed';
    public const STATUS_BOUNCED = 'bounced';
    public const STATUS_COMPLAINED = 'complained';

    protected $fillable = [
        'email',
        'name',
        'unsubscribe_token',
        'status',
        'source',
        'subscribed_at',
        'unsubscribed_at',
        'bounced_at',
        'complained_at',
        'last_event_at',
        'meta',
    ];

    protected $casts = [
        'subscribed_at' => 'datetime',
        'unsubscribed_at' => 'datetime',
        'bounced_at' => 'datetime',
        'complained_at' => 'datetime',
        'last_event_at' => 'datetime',
        'meta' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function (Subscriber $subscriber) {
            if (! $subscriber->unsubscribe_token) {
                $subscriber->unsubscribe_token = Str::random(48);
            }
        });
    }

    public function recipients(): HasMany
    {
        return $this->hasMany(NewsletterRecipient::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(EmailEvent::class);
    }

    public function isMailable(): bool
    {
        return $this->status === self::STATUS_SUBSCRIBED;
    }
}
