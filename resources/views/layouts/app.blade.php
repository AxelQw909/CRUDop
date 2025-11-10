<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Social App')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1a1a1a;
            color: #e0e0e0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>
</head>
<body class="bg-gray-900 text-white">

    <nav class="bg-gray-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('posts.index') }}" class="text-xl font-bold text-white">
                        <i class="fas fa-users mr-2"></i>SocialApp
                    </a>
                </div>
                
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('posts.create') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200">
                            <i class="fas fa-plus mr-2"></i>Создать пост
                        </a>
                        <span class="text-gray-300">{{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="text-gray-300 hover:text-white transition duration-200">
                                <i class="fas fa-sign-out-alt mr-1"></i>Выйти
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-300 hover:text-white">Войти</a>
                        <a href="{{ route('register') }}" class="text-gray-300 hover:text-white">Регистрация</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>


    <main class="max-w-4xl mx-auto py-6 px-4">
        @if(session('success'))
            <div class="bg-green-600 text-white p-4 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-600 text-white p-4 rounded-lg mb-6">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <script>
        function toggleCommentForm(postId) {
            const form = document.getElementById(`comment-form-${postId}`);
            form.classList.toggle('hidden');
        }

        function submitComment(postId) {
            const content = document.getElementById(`comment-content-${postId}`).value;
            const form = document.getElementById(`comment-form-${postId}-form`);
            
            if (content.trim() === '') {
                alert('Введите текст комментария');
                return;
            }
            
            form.submit();
        }

        function deletePost(postId) {
            if (confirm('Вы уверены, что хотите удалить этот пост?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/posts/${postId}`;
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                
                form.appendChild(csrfToken);
                form.appendChild(methodField);
                document.body.appendChild(form);
                form.submit();
            }
        }

        function deleteComment(commentId) {
            if (confirm('Вы уверены, что хотите удалить этот комментарий?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/comments/${commentId}`;
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                
                form.appendChild(csrfToken);
                form.appendChild(methodField);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</body>
</html>