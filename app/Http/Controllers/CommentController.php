<?php

namespace App\Http\Controllers;

use App\ApiResponse;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    use ApiResponse;

	public function index($postId)
    {
        $post = Post::whereNull('deleted_at')->find($postId);

        if (!$post) {
            return $this->error('Post not found', 404);
        }

        $comments = Comment::with('user')
                          ->where('post_id', $postId)
                          ->whereNull('deleted_at')
                          ->latest()
                          ->get();

        return $this->success($comments);
    }

    public function store(Request $request, $postId)
    {
        $post = Post::whereNull('deleted_at')->find($postId);

        if (!$post) {
            return $this->error('Post not found', 404);
        }

        $validator = Validator::make($request->all(), [
            'content' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 422);
        }

        $comment = Comment::create([
            'content' => $request->content,
            'user_id' => $request->user()->id,
            'post_id' => $postId,
        ]);

        return $this->success($comment->load('user'), 'Comment created successfully', 201);
    }

    public function destroy(Request $request, $id)
    {
        $comment = Comment::where('user_id', $request->user()->id)
                         ->whereNull('deleted_at')
                         ->find($id);

        if (!$comment) {
            return $this->error('Comment not found', 404);
        }

        $comment->delete();

        return $this->success(null, 'Comment deleted successfully');
    }
}
