<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContactMessage>
 */
class ContactMessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userId = null;
        $applyUser = $this->faker->boolean();

        if($applyUser) {
            $userId = User::inRandomOrder()->first()->id ?? null;
        }

        return [
            'user_id' => $userId,
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'subject' => $this->faker->text(),
            'body' => $this->faker->paragraph(1),
            'ip_address' => $this->faker->ipv4(),
            'site_domain' => env('APP_URL'),
        ];
    }
}
