<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContactSubmission>
 */
class ContactSubmissionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'company' => $this->faker->company(),
            'scope' => '30-day assessment',
            'message' => $this->faker->paragraph(),
            'ip' => '127.0.0.1',
            'user_agent' => 'PHPUnit',
        ];
    }
}
