<?php

namespace App\Http\Controllers;
use App\Http\Requests\PostPostRequest;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
     * Creates and saves model into database.
     * @param PostPostRequest $request
     * @return RedirectResponse
     */
    public function store(PostPostRequest $request): RedirectResponse {

        $request->validated();

        $post = new Post;
        $post->title = $request->input('title');
        $post->extract = $request->input('extract');
        $post->content = $request->input('body');
        $post->save();

        return Redirect::route('post.index');
    }
}
