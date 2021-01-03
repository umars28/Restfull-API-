<?php

namespace App\Http\Controllers;

use App\Http\Resources\Post\PostCollection;
use App\Http\Resources\Post\PostResource;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        // DB::listen(function ($query){
        //     var_dump($query->sql);
        // });
        //return request()->user();
        $data = Post::with('user')->paginate(5);
        return new PostCollection($data);
        // return response()->json($data, 200);
    }

    public function show($id)
    {
        $data = Post::find($id);
        if (is_null($data)) {
            return response()->json([
                'message' => 'Resource not found!'
            ], 404);
        }
        //return response()->json($data, 200);
        return new PostResource($data);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'title' => ['required', 'min:5']
        ]);
        if($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 400);
        }
        //$response = Post::create($data);
        $response = request()->user()->posts()->create($data);
        return response()->json($response, 201);
    }

    public function update(Request $request, Post $post)
    {
        $post->update($request->all());
        return response()->json($post, 200);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(null, 200);
    }

}
