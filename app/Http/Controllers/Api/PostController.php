<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user:id,name')
            ->orderBy("created_at", "desc")
            ->paginate(10);
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $valid_data = $request->validate([
            "title" => "required|max:90",
            "body" => "required|min:10|max:255",
        ]);
        $valid_data["user_id"] = Auth::user()->id;
        $post = Post::create($valid_data);

        return response()->json([
            "status" => "success",
            "post" => $post
        ], 200);
    }

    public function show($id)
    {
        $post = Post::with([
            'user:id,name,email'
        ])->find($id);

        if (!$post) {
            return response()->json([
                "status" => "error",
                "error" => "this post doesn't exist"
            ], 404);
        }
        return response()->json([
            "status" => "success",
            "post" => $post
        ], 200);
    }


    public function update(Request $request, $id)
    {
        if (Auth::user()->id != Post::findorFail($id)->user_id) {
            return response()->json([
                "status" => "error",
                "message" => "Unauthorized"
            ], 401);

        }

        $post = Post::findorFail($id);
        $valid_data = $request->validate([
            "title" => "required|max:90",
            "body" => "required|min:10|max:255",
        ]);
        $post->update($valid_data);
        return response()->json([
            "status" => "success",
            "message" => "Post Updated Successfully",
            "post" => $post
        ]);
    }

    public function destroy($id)
    {
        if (Auth::user()->id != Post::findorFail($id)->user_id) {
            return response()->json([
                "status" => "error",
                "message" => "Unauthorized"
            ], 401);

        }
        Post::destroy($id);
        return response()->json([
            "status" => "success",
            "message" => "Your post has been Deleted Successfully",

        ]);
    }
}

