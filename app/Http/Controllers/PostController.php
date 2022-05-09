<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return response()->json(['status'=>'success','data'=>$posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'title' => 'required|min:3',
            'body'  => 'required|min:3',
        ]);
        if($validator->fails())
        {
            return response()->json(['status'=>'error','errors'=>$validator->errors()]);
        }

        $post = new Post();
        $post->title = $request->title;
        $post->body  = $request->body;
        $post->save();
        return response()->json(['status'=>'success','data'=>$post]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(),
        [
            'title' => 'required|min:3',
            'body' => 'required|min:3',
        ]);
        if($validator->fails())
        {
            return response()->json(['status'=>'error','errors'=>$validator->errors()]);
        }

        $post = Post::find($id);
        $post->title = $request->title;
        $post->body  = $request->body;
        $post->save();
        return response()->json(['status'=>'success','data'=>$post]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $post = Post::find($id);
        if($post -> delete())
        {
            return response()->json(['status'=>'success','data'=>$post]);
        }
    }
}
