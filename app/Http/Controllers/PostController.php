<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $per_page = $request->input('per_page') ?: 10;
        return response()->json(Post::paginate($per_page), 201);
        // return response()->json(Post::get(), 201);
        // return Post::get();
        // return Post::select('title', 'content')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->user();
        if ($user->tokenCan('post:create')) {
            $data = $request->validate([
                'title' => 'required',
                'content' => 'required'
            ]);
            $post = new Post();
            $post->title = $data['title'];
            $post->content = $data['content'];
            $post->user_id = $user->id;
            $post->save();
            return response()->json($post, 201);
        }
        return response()->json([
            'error' => true,
            'message' => 'You are not authorized to create posts'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return response()->json($post, 201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return response()->json($post, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $user = $request->user();
        if ($user->tokenCan('post:edit')) {
            $data = $request->validate([
                'title' => 'required',
                'content' => 'required'
            ]);
            $post->title = $data['title'];
            $post->content = $data['content'];
            $post->save();
            return response()->json($post, 201);
        }
        return response()->json([
            'error' => true,
            'message' => 'You are not authorized to edit posts'
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $user = $request->user();
        if ($user->tokenCan('post:delete')) {
            $post->delete();
            return response()->json($post, 201);
        }
        return response()->json([
            'error' => true,
            'message' => 'You are not authorized to delete posts'
        ], 201);
    }
}
