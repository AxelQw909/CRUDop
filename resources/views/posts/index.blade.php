@extends('layouts.app')

@section('title', 'Лента')

@section('content')
<div class="space-y-6">
    @foreach($posts as $post)
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <!-- Заголовок поста с пользователем -->
            <div class="flex items-center mb-4">
                <img src="{{ $post->user->avatar_url }}" 
                     alt="Avatar" 
                     class="w-10 h-10 rounded-full object-cover">
                <div class="ml-3">
                    <div class="font-semibold text-white">{{ $post->user->name }}</div>
                    <div class="text-gray-400 text-sm">{{ $post->created_at->diffForHumans() }}</div>
                </div>
                
                <!-- Кнопки управления для автора поста -->
                @if(auth()->id() === $post->user_id)
                <div class="ml-auto flex space-x-2">
                    <a href="{{ route('posts.edit', $post->id) }}" 
                       class="text-blue-400 hover:text-blue-300 transition duration-200"
                       title="Редактировать">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button onclick="deletePost({{ $post->id }})" 
                            class="text-red-400 hover:text-red-300 transition duration-200"
                            title="Удалить">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                @endif
            </div>
            
            <!-- Контент поста -->
            @if($post->image)
                <div class="mb-4">
                    <img src="{{ asset('storage/' . $post->image) }}" 
                         alt="Post image" 
                         class="w-full rounded-lg max-h-96 object-cover">
                </div>
            @endif
            
            <div class="mb-4">
                <h3 class="text-xl font-bold text-white mb-2">{{ $post->title }}</h3>
                <p class="text-gray-300 whitespace-pre-line">{{ $post->content }}</p>
            </div>
            
            <!-- Кнопки действий -->
            <div class="flex items-center justify-between border-t border-gray-700 pt-4">
                <button onclick="toggleCommentForm({{ $post->id }})" 
                        class="flex items-center text-gray-400 hover:text-white transition duration-200">
                    <i class="far fa-comment mr-2"></i>
                    <span>Комментарий</span>
                </button>
                
                <div class="text-gray-400 text-sm">
                    {{ $post->comments->count() }} комментариев
                </div>
            </div>
            
            <!-- Форма комментария -->
            <div id="comment-form-{{ $post->id }}" class="hidden mt-4">
                <form id="comment-form-{{ $post->id }}-form" method="POST" action="{{ route('comments.store', $post->id) }}">
                    @csrf
                    <div class="flex space-x-2">
                        <textarea 
                            id="comment-content-{{ $post->id }}"
                            name="content"
                            placeholder="Напишите комментарий..." 
                            class="flex-1 px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:border-blue-500 resize-none"
                            rows="2"></textarea>
                        <button type="button" onclick="submitComment({{ $post->id }})" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 self-end">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Список комментариев -->
            @if($post->comments->count() > 0)
                <div class="mt-4 space-y-3">
                    @foreach($post->comments as $comment)
                        <div class="bg-gray-700 rounded-lg p-3">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center">
                                    <img src="{{ $comment->user->avatar_url }}" 
                                         alt="Avatar" 
                                         class="w-6 h-6 rounded-full object-cover mr-2">
                                    <span class="font-semibold text-white text-sm">{{ $comment->user->name }}</span>
                                </div>
                                
                                @if(auth()->id() === $comment->user_id)
                                <button onclick="deleteComment({{ $comment->id }})" 
                                        class="text-red-400 hover:text-red-300 text-sm transition duration-200">
                                    <i class="fas fa-trash"></i>
                                </button>
                                @endif
                            </div>
                            <p class="text-gray-300 text-sm mt-1 ml-8">{{ $comment->content }}</p>
                            <div class="text-gray-400 text-xs mt-1 ml-8">{{ $comment->created_at->diffForHumans() }}</div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endforeach
    
    @if($posts->isEmpty())
        <div class="text-center py-12">
            <i class="fas fa-newspaper text-6xl text-gray-600 mb-4"></i>
            <h3 class="text-xl text-gray-400">Пока нет постов</h3>
            <p class="text-gray-500 mt-2">Будьте первым, кто поделится чем-то интересным!</p>
            <a href="{{ route('posts.create') }}" 
               class="inline-block mt-4 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition duration-200">
                <i class="fas fa-plus mr-2"></i>Создать первый пост
            </a>
        </div>
    @endif
</div>
@endsection