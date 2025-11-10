@extends('layouts.app')

@section('title', 'Профиль')

@section('content')
<div class="max-w-2xl mx-auto bg-gray-800 rounded-lg shadow-lg p-6">
    <h2 class="text-2xl font-bold text-center mb-6">Мой профиль</h2>
    
    <!-- Статистика -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-gray-700 rounded-lg p-4 text-center">
            <div class="text-2xl font-bold text-blue-400">{{ $user->posts_count }}</div>
            <div class="text-gray-300 text-sm">Постов</div>
        </div>
        <div class="bg-gray-700 rounded-lg p-4 text-center">
            <div class="text-2xl font-bold text-green-400">{{ $user->comments()->count() }}</div>
            <div class="text-gray-300 text-sm">Комментариев</div>
        </div>
        <div class="bg-gray-700 rounded-lg p-4 text-center">
            <div class="text-2xl font-bold text-purple-400">{{ $user->created_at->diffForHumans() }}</div>
            <div class="text-gray-300 text-sm">На сайте</div>
        </div>
    </div>

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        
        <!-- Аватар -->
        <div class="mb-6 text-center">
            <div class="relative inline-block">
                <img id="avatar-preview" 
                     src="{{ $user->avatar_url }}" 
                     alt="Avatar" 
                     class="w-32 h-32 rounded-full object-cover border-4 border-gray-600">
                <label for="avatar" class="absolute bottom-0 right-0 bg-blue-600 rounded-full p-2 cursor-pointer hover:bg-blue-700 transition duration-200">
                    <i class="fas fa-camera text-white text-sm"></i>
                </label>
            </div>
            <input type="file" 
                   id="avatar" 
                   name="avatar" 
                   accept="image/*"
                   class="hidden"
                   onchange="previewAvatar(this)">
            @error('avatar')
                <span class="text-red-400 text-sm">{{ $message }}</span>
            @enderror
        </div>
        
        <!-- Основная информация -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="name" class="block text-gray-300 mb-2">Имя</label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $user->name) }}" 
                       class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:border-blue-500"
                       required>
                @error('name')
                    <span class="text-red-400 text-sm">{{ $message }}</span>
                @enderror
            </div>
            
            <div>
                <label for="email" class="block text-gray-300 mb-2">Email</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email', $user->email) }}" 
                       class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:border-blue-500"
                       required>
                @error('email')
                    <span class="text-red-400 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <!-- Смена пароля -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-300 mb-4">Смена пароля</h3>
            
            <div class="space-y-4">
                <div>
                    <label for="current_password" class="block text-gray-300 mb-2">Текущий пароль</label>
                    <input type="password" 
                           id="current_password" 
                           name="current_password" 
                           class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:border-blue-500">
                    @error('current_password')
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                
                <div>
                    <label for="new_password" class="block text-gray-300 mb-2">Новый пароль</label>
                    <input type="password" 
                           id="new_password" 
                           name="new_password" 
                           class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:border-blue-500">
                    @error('new_password')
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                
                <div>
                    <label for="new_password_confirmation" class="block text-gray-300 mb-2">Подтвердите новый пароль</label>
                    <input type="password" 
                           id="new_password_confirmation" 
                           name="new_password_confirmation" 
                           class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:border-blue-500">
                </div>
            </div>
        </div>
        
        <div class="flex space-x-4">
            <a href="{{ route('posts.index') }}" 
               class="flex-1 bg-gray-600 hover:bg-gray-700 text-white py-2 rounded-lg text-center transition duration-200">
                Назад
            </a>
            <button type="submit" 
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg transition duration-200">
                <i class="fas fa-save mr-2"></i>Сохранить изменения
            </button>
        </div>
    </form>
</div>

<script>
    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatar-preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection