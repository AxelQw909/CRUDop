@extends('layouts.app')

@section('title', 'Вход')

@section('content')
<div class="max-w-md mx-auto bg-gray-800 rounded-lg shadow-lg p-6 mt-10">
    <h2 class="text-2xl font-bold text-center mb-6">Вход в аккаунт</h2>
    
    <form method="POST" action="{{ route('login') }}">
        @csrf
        
        <div class="mb-4">
            <label for="email" class="block text-gray-300 mb-2">Email</label>
            <input type="email" 
                   id="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:border-blue-500"
                   required>
            @error('email')
                <span class="text-red-400 text-sm">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="mb-6">
            <label for="password" class="block text-gray-300 mb-2">Пароль</label>
            <input type="password" 
                   id="password" 
                   name="password" 
                   class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:border-blue-500"
                   required>
            @error('password')
                <span class="text-red-400 text-sm">{{ $message }}</span>
            @enderror
        </div>
        
        <button type="submit" 
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg transition duration-200">
            Войти
        </button>
        
        <div class="text-center mt-4">
            <a href="{{ route('register') }}" class="text-blue-400 hover:text-blue-300">
                Нет аккаунта? Зарегистрируйтесь
            </a>
        </div>
    </form>
</div>
@endsection