<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

use Faker\Factory as Faker;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_renders_the_user_index_page_with_users()
    {
        // Arrange: Create users and posts manually
        $user1 = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
        ]);

        $user2 = User::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => bcrypt('password'),
        ]);

        // Create posts for users
        Post::create([
            'title' => 'Post Title 1',
            'content' => 'Content of post 1',
            'user_id' => $user1->id,
        ]);

        Post::create([
            'title' => 'Post Title 2',
            'content' => 'Content of post 2',
            'user_id' => $user1->id,
        ]);

        Post::create([
            'title' => 'Post Title 3',
            'content' => 'Content of post 3',
            'user_id' => $user2->id,
        ]);

        // Act: Call the index method via the route
        $response = $this->get(route('users.index'));

        // Assert: Check that the correct view is rendered and users are passed to the view
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Users/Index')
            ->has('users', 2)
        );
    }

    /** @test */
    public function it_deletes_a_user_and_their_associated_posts()
    {
        // Create an instance of Faker
        $faker = Faker::create();

        // Arrange: Create a user and associated posts manually using Faker
        $user = User::create([
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'password' => bcrypt('password'),
        ]);

        Post::create([
            'title' => $faker->sentence,
            'content' => $faker->paragraph,
            'user_id' => $user->id,
        ]);

        Post::create([
            'title' => $faker->sentence,
            'content' => $faker->paragraph,
            'user_id' => $user->id,
        ]);

        // Act: Call the destroy method via the route
        $response = $this->delete(route('users.destroy', $user->id));

        // Assert: Ensure the user and their posts are deleted from the database
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
        $this->assertDatabaseMissing('posts', ['user_id' => $user->id]);

        // Assert: Ensure it redirects to the correct route
        $response->assertRedirect(route('app'));
    }
}
