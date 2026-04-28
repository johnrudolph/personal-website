<?php

namespace Database\Factories;

use App\Models\Newsletter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Newsletter>
 */
class NewsletterFactory extends Factory
{
    public function definition(): array
    {
        return [
            'subject' => $this->faker->sentence(),
            'html' => '<p>'.$this->faker->paragraph().'</p>',
            'status' => Newsletter::STATUS_DRAFT,
        ];
    }

    public function sent(): self
    {
        return $this->state([
            'status' => Newsletter::STATUS_SENT,
            'sent_at' => now(),
        ]);
    }
}
