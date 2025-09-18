<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // Show all posts
    public function index()
    {
        // get all posts ordered by latest with pagination
        $posts = Post::latest()->paginate(10);

        // send to the Blade view
        return view('homepage', compact('posts'));
    }

    // Handle form submission and save a post
    public function store(Request $request)
    {
        // validate input before saving
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // create the post
        Post::create($validated);

        // redirect back to the homepage with a success message
        return redirect('/')->with('success', 'Post created successfully!');
    }
}