<?php

namespace Database\Seeders;

use App\Models\Categorie;
use App\Models\Comment;
use App\Models\Event;
use App\Models\Post;
use App\Models\Reader;
use App\Models\User;
use App\Models\Webtv;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => '12334567',
            'phone' => '1234567890',
            'role' => 'admin',
        ]);

        $categorie1 = Categorie::create([
            'title' => 'Category 1',
            'slug' => 'category-1',
        ]);

        $categorie2 = Categorie::create([
            'title' => 'Category 2',
            'slug' => 'category-2',
        ]);

        $post1 = Post::create([
            'user_id' => $user->id,
            'title' => 'Post Title 1',
            'content' => 'Content for post 1',
            'categorie_id' => $categorie1->id,
            'image' => 'image1.jpg',
            'slug' => 'post-title-1',
            'status' => 'publier',
        ]);

        $post2 = Post::create([
            'user_id' => $user->id,
            'title' => 'Post Title 2',
            'content' => 'Content for post 2',
            'categorie_id' => $categorie2->id,
            'image' => 'image2.jpg',
            'slug' => 'post-title-2',
            'status' => 'revision',
        ]);

        $event1 = Event::create([
            'user_id' => $user->id,
            'title' => 'Event Title 1',
            'description' => 'Description for event 1',
            'url' => 'https://example.com/event1',
            'location' => 'Location 1',
            'start_date' => now()->subDays(5), // A past event
            'end_date' => now()->subDays(3),
            'categorie_id' => $categorie1->id,
            'image' => 'event1.jpg',
            'slug' => 'event-title-1',
            'status' => 'publier',
        ]);

        $event2 = Event::create([
            'user_id' => $user->id,
            'title' => 'Event Title 3',
            'description' => 'Description for event 3',
            'url' => 'https://example.com/event3',
            'location' => 'Location 3',
            'start_date' => now()->addDays(7), // A future event
            'end_date' => now()->addDays(10),
            'categorie_id' => $categorie1->id,
            'image' => 'event3.jpg',
            'slug' => 'event-title-3',
            'status' => 'publier',
        ]);

        $event3 = Event::create([
            'user_id' => $user->id,
            'title' => 'Event Title 2',
            'description' => 'Description for event 2',
            'url' => 'https://example.com/event2',
            'location' => 'Location 2',
            'start_date' => now()->addDays(3),
            'end_date' => now()->addDays(5),
            'categorie_id' => $categorie2->id,
            'image' => 'event2.jpg',
            'slug' => 'event-title-2',
            'status' => 'revision',
        ]);

        $webtv1 = Webtv::create([
            'user_id' => $user->id,
            'title' => 'title 1',
            'description' => 'description 1',
            'url' => 'https://example.com/webtv1',
            'read_time' => '5 minutes',
            'categorie_id' => $categorie1->id,
            'image' => 'webtv1.jpg',
            'slug' => 'webtv-title-1',
            'status' => 'publier',
        ]);

        $webtv2 = Webtv::create([
            'user_id' => $user->id,
            'title' => 'title 2',
            'description' => 'description 2',
            'url' => 'https://example.com/webtv2',
            'read_time' => '10 minutes',
            'categorie_id' => $categorie2->id,
            'image' => 'webtv2.jpg',
            'slug' => 'webtv-title-2',
            'status' => 'revision',
        ]);

        $reader1 = Reader::create([
            'name' => 'Reader 1',
            'email' => 'ben@gmail.com',
            'password' => '12334567',
            'profile_picture' => 'image.jpg',
            'bio' => 'This is a bio',
            'phone' => '773281684',
            'status' => 'active',
        ]);

        $reader2 = Reader::create([
            'name' => 'Reader 2',
            'email' => 'test@gmail.com',
            'password' => '',
            'profile_picture' => 'image.jpg',
            'bio' => 'this is a bio 2',
            'phone' => '773281684',
            'status' => 'active',
        ]);

        Comment::create([
            'post_id' => $post1->id,
            'reader_id' => $reader1->id,
            'content' => 'This is a comment on post 1',
        ]);

        Comment::create([
            'post_id' => $post2->id,
            'reader_id' => $reader1->id,
            'content' => 'This is a comment on post 2',
        ]);

        Comment::create([
            'post_id' => $post1->id,
            'reader_id' => $reader1->id,
            'content' => 'This is another comment on post 1',
        ]);

        Comment::create([
            'post_id' => $post2->id,
            'reader_id' => $reader1->id,
            'content' => 'This is a comment on post 2',
        ]);
    }
}
