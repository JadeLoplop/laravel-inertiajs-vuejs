<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends BaseController
{
    protected $postRepository;
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
        parent::__construct($postRepository);
    }

    // Index method to display the list of posts
    public function index()
    {
        $posts = $this->postRepository->all(); // Fetch all posts
        // Render the Posts page with the posts data
        return Inertia::render('Posts/Index', [
            'posts' => $posts
        ]);
    }

    // Show method to display a single post
    public function show($id)
    {
        $post = $this->postRepository->find($id); // Find the specific post
        // Render the PostDetails page with the post data
        return Inertia::render('Posts/Show', [
            'post' => $post
        ]);
    }

    // Optional destroy method for deleting posts
    public function destroy($id)
    {
        $this->postRepository->delete($id); // Delete the post
        // Redirect back to the index page after deleting
        return redirect()->route('posts.index');
    }



}
