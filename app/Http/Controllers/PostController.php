<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'image' => 'nullable|image'
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->body = $request->body;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = Storage::putFile('public/images', $file);
            $nuevo_path = str_replace('public/', '', $path);
            $post->image_url = $nuevo_path;
        }

        $post->save();
        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy($id)
    {
        // Find the post by ID
        $post = Post::find($id);

        // Check if the post exists
        if ($post) {
            $post->delete(); // Delete the post
            return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
        }

        // If the post does not exist, redirect back with an error message
        return redirect()->route('posts.index')->with('error', 'Post not found.');
    }
}
