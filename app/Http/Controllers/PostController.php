<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Http\Request;


class PostController extends Controller
{
    /**
     * Form to create a post
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index() {
        return view('./post/post-form');
    }

    public function store(Request $request) {
        $request->validate([
            'title' => ['required', 'max:255'],
            'extract' => ['required', 'max:100'],
            'postcontent' => ['required']
        ]);

        $post = new Post;
        $post->title = $request->input('title');
        $post->extract = $request->input('extract');
        $post->content = $request->input('postcontent');
        $post->save();
    }
}
