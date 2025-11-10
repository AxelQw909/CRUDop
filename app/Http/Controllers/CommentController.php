<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $post = Post::whereNull('deleted_at')->find($postId);

        if (!$post) {
            return redirect()->back()->with('error', 'Пост не найден.');
        }

        Comment::create([
            'content' => $request->content,
            'user_id' => auth()->id(),
            'post_id' => $postId,
        ]);

        return redirect()->back()->with('success', 'Комментарий добавлен.');
    }

    public function destroy($id)
    {
        $comment = Comment::where('user_id', auth()->id())
                         ->whereNull('deleted_at')
                         ->find($id);

        if (!$comment) {
            return redirect()->back()->with('error', 'Комментарий не найден.');
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Комментарий удален.');
    }
}