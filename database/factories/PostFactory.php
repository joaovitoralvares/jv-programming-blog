<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'meta_title' => $this->faker->sentence(),
            'summary' => $this->faker->paragraph(),
            'author_id' => 1,
            'content' => $this->faker->paragraphs(3,true),
            'slug' => $this->faker->slug(),
            'published' => 0,
        ];
    }
}
