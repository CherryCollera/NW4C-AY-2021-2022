<?php

namespace Database\Factories;

use App\Models\Message;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Message::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'convo_id' => Conversation::factory(),
            'sender_id' => User::factory(),
            'post_id' => User::factory(),
            'content' => $this->faker->word(20),
            'image_path' => '',
            'is_read' => false,
        ];
    }
}
