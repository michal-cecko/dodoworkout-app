<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventCategory;
use App\Models\Post;
use App\Models\PostTag;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $categories = EventCategory::factory()->count(5)->create();
        $postTags = PostTag::factory()->count(5)->create();

        $posts = Post::factory()->count(10)->create()->each(function(Post $post) use ($postTags) {
            $post->tags()->attach(fake()->randomElements($postTags, fake()->numberBetween(1, 5)));
        });

        $events = Event::factory()->count(5)->create([
            'category_id' => fake()->randomElement($categories)->id,
        ]);
    }
}
