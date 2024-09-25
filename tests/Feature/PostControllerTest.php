<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $postRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->postRepository = app(PostRepository::class);
    }

    /** @test */
    public function it_renders_the_posts_index_page_with_posts()
    {
        // Arrange: Create a user first
        $user = User::create([
            'id' => 1,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'), // assuming password is required
        ]);

        // Now create some posts associated with that user
        Post::create([
            'id' => 1,
            'title' => 'Post Title 1',
            'content' => 'Content of post 1',
            'user_id' => $user->id,
        ]);

        Post::create([
            'id' => 2,
            'title' => 'Post Title 2',
            'content' => 'Content of post 2',
            'user_id' => $user->id,
        ]);

        // Act: Call the index method via the route
        $response = $this->get(route('posts.index'));

        // Assert: Check that the correct view is rendered and posts are passed to the view
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Posts/Index')
            ->has('posts', 2)
        );
    }

    /** @test */
    public function it_renders_a_single_post_show_page()
    {
        // Arrange: Create a user first
        $user = User::create([
            'id' => 1,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'), // assuming password is required
        ]);

        // Now create a post associated with that user
        $post = Post::create([
            'id' => 1,
            'title' => 'Post Title',
            'content' => 'Content of post',
            'user_id' => $user->id,
        ]);

        // Act: Call the show method via the route
        $response = $this->get(route('posts.show', $post->id));

        // Assert: Check that the correct view is rendered and the post is passed to the view
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Posts/Show')
            ->where('post.id', $post->id)
            ->where('post.title', $post->title)
            ->where('post.content', $post->content)
        );
    }

    /** @test */
    public function it_deletes_a_post()
    {
        // Arrange: Create a user first
        $user = User::create([
            'id' => 1,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'), // assuming password is required
        ]);

        // Now create a post associated with that user
        $post = Post::create([
            'id' => 1,
            'title' => 'Post Title',
            'content' => 'Content of post',
            'user_id' => $user->id,
        ]);

        // Act: Call the destroy method via the route
        $response = $this->delete(route('posts.destroy', $post->id));

        // Assert: Ensure the post is deleted from the database
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);

        // Assert: Ensure it redirects to the correct route
        $response->assertRedirect(route('posts.index'));
    }
}
