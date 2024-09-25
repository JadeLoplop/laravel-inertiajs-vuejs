<?php

namespace Tests\Feature\Console\Commands;

use App\Models\User;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ImportUserDataTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_imports_users_and_posts_from_external_api()
    {
        // Step 1: Mock the external API responses

        // Fake response for users
        Http::fake([
            'jsonplaceholder.typicode.com/users' => Http::response([
                [
                    'id' => 1,
                    'username' => 'john_doe',
                    'email' => 'john@example.com',
                ],
                [
                    'id' => 2,
                    'username' => 'jane_doe',
                    'email' => 'jane@example.com',
                ]
            ], 200),

            // Fake response for posts
            'jsonplaceholder.typicode.com/posts' => Http::response([
                [
                    'id' => 101,
                    'title' => 'Post Title 1',
                    'body' => 'Content of post 1',
                    'userId' => 1
                ],
                [
                    'id' => 102,
                    'title' => 'Post Title 2',
                    'body' => 'Content of post 2',
                    'userId' => 2
                ]
            ], 200),
        ]);

        // Step 2: Run the command
        $this->artisan('import:users-posts')
            ->expectsOutput('Users and posts have been successfully imported.')
            ->assertExitCode(0);

        // Step 3: Assert users are created in the database
        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
            'name' => 'john_doe',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'jane@example.com',
            'name' => 'jane_doe',
        ]);

        // Step 4: Assert posts are created in the database and linked to the correct users
        $this->assertDatabaseHas('posts', [
            'title' => 'Post Title 1',
            'content' => 'Content of post 1',
            'user_id' => User::where('email', 'john@example.com')->first()->id,
        ]);

        $this->assertDatabaseHas('posts', [
            'title' => 'Post Title 2',
            'content' => 'Content of post 2',
            'user_id' => User::where('email', 'jane@example.com')->first()->id,
        ]);
    }
}
