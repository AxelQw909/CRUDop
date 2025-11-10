<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function create()
    {
        return view('posts.create');
    }

    
    public function index()
    {
        $posts = Post::with(['user', 'comments.user'])
                    ->whereNull('deleted_at')
                    ->latest()
                    ->get();

        return view('posts.index', compact('posts'));
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        Post::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imagePath,
        ]);

        return redirect()->route('posts.index')->with('success', 'Пост успешно создан!');
    }

    
    public function edit($id)
    {
        $post = Post::where('user_id', auth()->id())
                    ->whereNull('deleted_at')
                    ->find($id);

        if (!$post) {
            return redirect()->route('posts.index')->with('error', 'Пост не найден.');
        }

        return view('posts.edit', compact('post'));
    }

    
    public function update(Request $request, $id)
    {
        $post = Post::where('user_id', auth()->id())
                    ->whereNull('deleted_at')
                    ->find($id);

        if (!$post) {
            return redirect()->route('posts.index')->with('error', 'Пост не найден.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $post->image = $request->file('image')->store('posts', 'public');
        }

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('posts.index')->with('success', 'Пост успешно обновлен!');
    }

    
    public function destroy($id)
    {
        $post = Post::where('user_id', auth()->id())
                    ->whereNull('deleted_at')
                    ->find($id);

        if (!$post) {
            return redirect()->route('posts.index')->with('error', 'Пост не найден.');
        }

        
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Пост удален успешно.');
    }
}