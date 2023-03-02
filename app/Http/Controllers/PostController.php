<?php

namespace App\Http\Controllers;

use App\Models\Post;

use Illuminate\View\View;

use Illuminate\Http\RedirectResponse;

use Illuminate\Support\Facades\Storage;

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

    /**
     * show
     * 
     * @param mixed $id
     * @return View
     */
    public function show($id): View
    {
        // get post by id
        $post = Post::findOrFail($id);

        // return view with post
        return view('posts.show', compact('post'));
    }

    /**
     * edit
     * 
     * @param mixed $id
     * @return View
     */
    public function edit($id): View
    {
        // get post by id
        $post = Post::findOrFail($id);

        // return view with post
        return view('posts.edit', compact('post'));
    }

    /**
     * update
     * 
     * @param Request $request
     * @param mixed $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        // validate form
        $this->validate($request, [
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'title' => 'required|min:5',
            'content' => 'required|min:10',
        ]);

        // get post by id
        $post = Post::findOrFail($id);

        // check if image is not empty
        if ($request->hasFile('image')) {
            // upload new image
            $image = $request->file('image');
            $image->storeAs('public/posts', $image->hashName());

            // delete old image
            Storage::delete('public/posts/' . $post->image);

            // update post with new image
            $post->update([
                'image' => $image->hashName(),
                'title' => $request->title,
                'content' => $request->content,
            ]);
        } else {
            // update post without image
            $post->update([
                'title' => $request->title,
                'content' => $request->content,
            ]);
        }

        // redirect to index
        return redirect()->route('posts.index')->with(['success' => 'Data berhasil diubah!']);
    }

    /**
     * destroy
     * 
     * @param mixed $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        // get post by id
        $post = Post::findOrFail($id);

        // delete image
        Storage::delete('public/posts/' . $post->image);

        // delete post
        $post->delete();

        // redirect to index
        return redirect()->route('posts.index')->with(['success' => 'Data berhasil dihapus!']);
    }
}
