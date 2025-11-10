@extends('layouts.app')

@section('title', 'Редактировать пост')

@section('content')
<div class="max-w-2xl mx-auto bg-gray-800 rounded-lg shadow-lg p-6">
    <h2 class="text-2xl font-bold text-center mb-6">Редактировать пост</h2>
    
    <form method="POST" action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data">
        @csrf
        @method('POST')
        
        <div class="mb-4">
            <label for="title" class="block text-gray-300 mb-2">Заголовок</label>
            <input type="text" 
                   id="title" 
                   name="title" 
                   value="{{ old('title', $post->title) }}" 
                   class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:border-blue-500"
                   placeholder="Введите заголовок..."
                   required>
            @error('title')
                <span class="text-red-400 text-sm">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="image" class="block text-gray-300 mb-2">Изображение</label>
            
            @if($post->image)
                <div class="mb-3">
                    <label class="block text-gray-300 mb-2">Текущее изображение:</label>
                    <img src="{{ asset('storage/' . $post->image) }}" 
                         alt="Current post image" 
                         class="max-w-full h-auto rounded-lg max-h-64">
                </div>
            @endif
            
            <input type="file" 
                   id="image" 
                   name="image" 
                   accept="image/*"
                   class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:border-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
            <p class="text-gray-400 text-sm mt-1">Оставьте пустым, чтобы сохранить текущее изображение</p>
            @error('image')
                <span class="text-red-400 text-sm">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="mb-6">
            <label for="content" class="block text-gray-300 mb-2">Описание</label>
            <textarea 
                id="content" 
                name="content" 
                rows="6"
                class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:border-blue-500 resize-none"
                placeholder="Напишите что-нибудь..."
                required>{{ old('content', $post->content) }}</textarea>
            @error('content')
                <span class="text-red-400 text-sm">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="flex space-x-4">
            <a href="{{ route('posts.index') }}" 
               class="flex-1 bg-gray-600 hover:bg-gray-700 text-white py-2 rounded-lg text-center transition duration-200">
                Отмена
            </a>
            <button type="submit" 
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg transition duration-200">
                <i class="fas fa-save mr-2"></i>Обновить пост
            </button>
        </div>
    </form>
</div>

<script>
    
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                
                const oldPreview = document.getElementById('image-preview');
                if (oldPreview) {
                    oldPreview.remove();
                }
                
               
                const preview = document.createElement('div');
                preview.id = 'image-preview';
                preview.className = 'mt-4';
                preview.innerHTML = `
                    <label class="block text-gray-300 mb-2">Новое изображение:</label>
                    <img src="${e.target.result}" class="max-w-full h-auto rounded-lg max-h-64">
                `;
                
                document.querySelector('form').insertBefore(preview, document.querySelector('button[type="submit"]').parentElement);
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection