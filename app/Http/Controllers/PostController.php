<?php

namespace App\Http\Controllers;
use App\Http\Requests\PostPostRequest;
use App\Models\Post;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
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

    public function edit($id) {

        $post = Post::query()->where('id', '=', $id)->get()->first();

        if (!Gate::allows('update-post', $post)) {
            abort(403);
        }

        return view('post.edit')->with('post', $post);

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
        $post->expirable = ($request->input('expirable')) ? '1' : '0';
        $post->commentable = ($request->input('commentable')) ? '1' : '0';
        $post->visibility = $request->get('visibility');
        $post->user_id = auth()->user()->getAuthIdentifier();

        try {
            $post->save();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        return response()->json('Post created successfully!', 201);
    }

    public function update(PostPostRequest $request, $id): JsonResponse {

        $data = $request->all();

        Post::query()
            ->where('id', $id)
            ->update([
                'title' => $data['title'] ,
                'extract' => $data['extract'],
                'content' => $data['body'],
                'expirable' => isset($data['expirable']) ? '1' : '0',
                'commentable' => isset($data['commentable']) ? '1' : '0',
                'visibility' => $data['visibility']
            ]);

        return response()->json('Post with id=' . $id . ' updated!', 200);

    }

}
