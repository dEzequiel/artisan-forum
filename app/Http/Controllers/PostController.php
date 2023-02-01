<?php

namespace App\Http\Controllers;
use App\Http\Requests\PostPostRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;


class PostController extends Controller
{
    /**
     * Display the post creation form.
     * @return View
     */
    public function index(): View {
        return view('post.form');
    }

    /**
     * Display all created posts
     * @return View
     */
    public function list(): View {
        $posts = Post::all();

        return view('post.list')->with('posts', $posts);
    }

    /**
     * Creates and saves model into database.
     * @param PostPostRequest $request
     * @return RedirectResponse
     */
    public function store(PostPostRequest $request): JsonResponse {

        $request->validated();

        $post = new Post;
        $post->title = $request->input('title');
        $post->extract = $request->input('extract');
        $post->content = $request->input('body');
        $post->user_id = auth()->user()->getAuthIdentifier();
        $post->save();

        return response()->json('Post created successfully!', 201);

    }
}
