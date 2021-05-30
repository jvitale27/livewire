<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;


class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'   => $this->faker->sentence(),
            'content' => $this->faker->text(100),        //corto en 100 caracteres
            // almacena 'posts/{imagen}'
            'image'   => 'posts/' . $this->faker->image('public/storage/posts', 640, 480, null, false)
            // almacena 'public/storage/posts/{imagen}'
            //'image' => $this->faker->image('public/storage/posts', 640, 480, null, true)
            // almacena '{imagen}'
            //'image' => $this->faker->image('public/storage/posts', 640, 480, null, false)
        ];
    }
}
