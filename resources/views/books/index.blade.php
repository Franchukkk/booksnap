@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-semibold mb-6 text-gray-800 dark:text-gray-100">Список книг</h1>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100 rounded">
            {{ session('success') }}
        </div>
    @endif

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

                                {{-- Кнопка перегляду відгуків --}}
                                <a href="{{ route('book_reviews.index', $book->id) }}"
                                class="px-3 py-1 text-sm bg-purple-600 text-white rounded hover:bg-purple-700">
                                    Відгуки
                                </a>

                                {{-- Кнопка залишити/редагувати відгук --}}
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
        {{ $books->links() }}
    </div>
</div>
@endsection