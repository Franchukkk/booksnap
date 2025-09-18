@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-semibold mb-6 text-gray-800 dark:text-gray-100">Список книг</h1>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Фільтри та сортування -->
    <div class="mb-6 p-4 bg-white dark:bg-gray-800 rounded shadow">
        <form action="{{ route('books.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Жанр</label>
                    <select name="genre" class="mt-1 block w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                        <option value="">Всі жанри</option>
                        @foreach($genres as $genre)
                            <option value="{{ $genre }}" {{ request('genre') == $genre ? 'selected' : '' }}>
                                {{ $genre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Пошук</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="mt-1 block w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700"
                           placeholder="Назва або автор...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Сортування</label>
                    <select name="sort" class="mt-1 block w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                        <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>Назва (А-Я)</option>
                        <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Назва (Я-А)</option>
                        <option value="author_asc" {{ request('sort') == 'author_asc' ? 'selected' : '' }}>Автор (А-Я)</option>
                        <option value="author_desc" {{ request('sort') == 'author_desc' ? 'selected' : '' }}>Автор (Я-А)</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Застосувати фільтри
                </button>
            </div>
        </form>
    </div>

    @auth
        @if(Auth::user()->role === 'admin')
            <a href="{{ route('books.create') }}"
               class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                Додати книгу
            </a>
        @endif
    @endauth

    <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow rounded">
        <table class="min-w-full text-left">
            <thead class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                <tr>
                    <th class="px-4 py-3">Назва</th>
                    <th class="px-4 py-3">Автор</th>
                    <th class="px-4 py-3">Жанр</th>
                    <th class="px-4 py-3">Тип</th>
                    <th class="px-4 py-3">Дії</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                @foreach($books as $book)
                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                        <td class="px-4 py-3 text-gray-900 dark:text-gray-100">{{ $book->title }}</td>
                        <td class="px-4 py-3 text-gray-900 dark:text-gray-100">{{ $book->author }}</td>
                        <td class="px-4 py-3 text-gray-900 dark:text-gray-100">{{ $book->genre }}</td>
                        <td class="px-4 py-3 text-gray-900 dark:text-gray-100">{{ $book->type }}</td>
                        <td class="px-4 py-3 space-x-2">
                            <a href="{{ route('books.show', $book) }}"
                            class="px-3 py-1 text-sm bg-indigo-500 text-white rounded hover:bg-indigo-600">
                                Переглянути
                            </a>

                            @auth
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('books.edit', $book) }}"
                                    class="px-3 py-1 text-sm bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                        Редагувати
                                    </a>
                                    <form action="{{ route('books.destroy', $book) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Ви впевнені, що хочете видалити цю книгу?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-1 text-sm bg-red-600 text-white rounded hover:bg-red-700">
                                            Видалити
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('reservations.store') }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                                    <button type="submit"
                                            class="px-3 py-1 text-sm bg-green-600 text-white rounded hover:bg-green-700">
                                        Забронювати
                                    </button>
                                </form>

                                <a href="{{ route('book_reviews.index', $book->id) }}"
                                class="px-3 py-1 text-sm bg-purple-600 text-white rounded hover:bg-purple-700">
                                    Відгуки
                                </a>

                                <a href="{{ route('book_reviews.form', $book->id) }}"
                                class="px-3 py-1 text-sm bg-pink-600 text-white rounded hover:bg-pink-700">
                                    Залишити відгук
                                </a>
                            @endauth
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $books->appends(request()->query())->links() }}
    </div>
</div>
@endsection