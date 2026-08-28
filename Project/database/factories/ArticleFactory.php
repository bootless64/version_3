<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake('fa_IR')->realText(50),
            'content' => fake('fa_IR')->realText(600),
            'user_id' => \App\Models\User::inRandomOrder()->first()->id ?? \App\Models\User::factory(),

            // 'created_at' => now(),
        ];
    }
}
