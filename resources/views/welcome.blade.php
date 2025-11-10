@extends('layouts.app')

@section('title', 'Добро пожаловать')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-900">
    <div class="text-center">
        <h1 class="text-4xl font-bold text-white mb-4">Защита</h1>
        <p class="text-gray-400 mb-8">к</p>
        
        <div class="space-y-4">
            <a href="{{ route('login') }}" 
               class="block w-64 mx-auto bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg transition duration-200">
                Войти
            </a>
            <a href="{{ route('register') }}" 
               class="block w-64 mx-auto bg-gray-600 hover:bg-gray-700 text-white py-3 rounded-lg transition duration-200">
                Зарегистрироваться
            </a>
        </div>
    </div>
</div>
@endsection