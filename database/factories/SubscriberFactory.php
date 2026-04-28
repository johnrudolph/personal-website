<?php

namespace Database\Factories;

use App\Models\Subscriber;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscriber>
 */
class SubscriberFactory extends Factory
{
    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail(),
            'name' => $this->faker->name(),
            'unsubscribe_token' => Str::random(48),
            'status' => Subscriber::STATUS_SUBSCRIBED,
            'source' => 'test',
            'subscribed_at' => now(),
        ];
    }

    public function unsubscribed(): self
    {
        return $this->state([
            'status' => Subscriber::STATUS_UNSUBSCRIBED,
            'unsubscribed_at' => now(),
        ]);
    }

    public function bounced(): self
    {
        return $this->state([
            'status' => Subscriber::STATUS_BOUNCED,
            'bounced_at' => now(),
        ]);
    }
}
