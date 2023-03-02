<?php

namespace App\Http\Controllers;

use App\Models\Post;

use Illuminate\View\View;

use Illuminate\Http\RedirectResponse;

use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * index
     * 
     * @return View
     */
    public function index(): View
    {
        // get posts
        $posts = Post::latest()->paginate(5);

        // return view with posts
        return view('posts.index', compact('posts'));
    }

    /** 
     * create
     * 
     * @return View
     */
    public function create(): View
    {
        // return view
        return view('posts.create');
    }

    /**
     * store
     * 
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // validate form
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'title' => 'required|min:5',
            'content' => 'required|min:10',
        ]);

        // upload image
        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());

        // create post
        Post::create([
            'image' => $image->hashName(),
            'title' => $request->title,
            'content' => $request->content,
        ]);

        // redirect to index
        return redirect()->route('posts.index')->with(['success' => 'Data berhasil disimpan!']);
    }
}
