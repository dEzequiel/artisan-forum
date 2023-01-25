<?php

namespace App\Http\Controllers;
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
}
