<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Показать форму регистрации
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Показать форму входа
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function register(Request $request)
    {
        // Валидация для веб-запроса
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Создание пользователя
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Автоматический вход после регистрации
        Auth::login($user);

        return redirect()->route('posts.index')->with('success', 'Добро пожаловать!');
    }

    public function login(Request $request)
    {
        // Валидация для веб-запроса
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Попытка аутентификации
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('posts.index')->with('success', 'Добро пожаловать!');
        }

        return back()->withErrors([
            'email' => 'Неверные учетные данные.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'Вы вышли из системы.');
    }
}