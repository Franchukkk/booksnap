@extends('layouts.app')

@section('content')
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <div class="mb-4">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                        {{ $book->title }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">Автор: {{ $book->author }}</p>
                    <p class="text-gray-600 dark:text-gray-400">Жанр: {{ $book->genre }}</p>
                    <p class="text-gray-600 dark:text-gray-400">Тип: {{ $book->type }}</p>
                    <p class="text-gray-600 dark:text-gray-400">Предмет: {{ $book->subject }}</p>
                    <p class="text-gray-600 dark:text-gray-400">Клас: {{ $book->class_level }}</p>
                    <p class="text-gray-600 dark:text-gray-400">ISBN: {{ $book->isbn }}</p>
                    <p class="text-gray-600 dark:text-gray-400">Кількість: {{ $book->quantity }}</p>
                    <p class="text-gray-600 dark:text-gray-400">
                        Рекомендована: 
                        <span class="{{ $book->is_recommended ? 'text-green-500' : 'text-red-500' }}">
                            {{ $book->is_recommended ? 'Так' : 'Ні' }}
                        </span>
                    </p>
                </div>

                @if($book->description)
                    <div class="mt-6">
                        <h4 class="text-lg font-medium text-gray-800 dark:text-gray-300">Опис:</h4>
                        <p class="text-gray-700 dark:text-gray-400 mt-2 whitespace-pre-line">{{ $book->description }}</p>
                    </div>
                @endif

                <div class="mt-6">
                    <a href="{{ route('books.index') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Назад до списку
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection