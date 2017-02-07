<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;

class PostController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function newForm() {
    	return view('posts.new');
    }

    public function viewPost($id) {
        $post = Post::findOrFail($id);

        return view('posts.view')->with('post', $post);
    }

    public function listPosts() {
        $posts = Post::orderBy('created_at', 'desc')->paginate(15);
        return view('posts.list')->with('posts', $posts);
    }
}
